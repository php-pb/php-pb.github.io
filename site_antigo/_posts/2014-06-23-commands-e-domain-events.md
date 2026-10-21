---
layout: post
title: Commands e Domain Events
date: 2014-06-23 10:42:00
author: Tony Messias
categories: 
  - Tutorial
  - DDD
tags: 
  - DDD
  - PHP
  - Commands
  - Domain Events
  - Patterns

---

Lidar com complexidade é tarefa rotineira de um desenvolvedor de software. "Será que esse código tá bom?" ou "Como testar
isso?" são perguntas frequentes quando estou desenvolvendo. Mas nem sempre precisamos quebrar a cabeça criando soluções
para os nossos problemas. 

Existem vários padrões catalogados para problemas semelhantes aos nossos. Pois é, o seu
sistema não é lá tão diferente dos outros sistemas lá fora. Em uma das minhas buscas para soluções simples para os
problemas do dia-a-dia me deparei com *DDD*, *Domain Events*, *Commands*, etc, etc... Achei muito legal a ideia por trás
e desde então venho estudando tópicos relacionados.
 
<!-- more -->

Hoje vou mostrar um pouco sobre *Commands* e *Domain Events*. Acredito que um exemplo ajuda muito a entender, mas, antes, vamos a uma introdução rápida sobre o que seriam *Commands* e o que seriam *Domain Events*.

É comum, em aplicações pequenas, tratarmos boa parte da lógica de uma feature nos controllers, visto que são pequenas coisas e raramente vamos alterar ou utilizar em outros lugares essa mesma lógica. Só que a medida que as aplicações vão crescendo, elas tendem a se tornar mais complexas. Consequentemente, elas se tornam mais "difíceis" de manter e adicionar novas features passa a ser um processo não tão prazeroso.

Tentando tornar esse processo menos doloroso, resolvi estudar sobre padrões e arquitetura de software, um tema com bastante conteúdo, porém, vejo poucas pessoas interessadas nisso.

Vamos a um pouco de conceito sobre *Commands*:

Commands são uma forma de separar a lógica da nossa aplicação dos frameworks ou aplicações cliente. Fazendo com que essas utilizem uma interface de comando para realizar suas tarefas.. ou seja, o cliente não tem que saber de repositórios, banco de dados, serviços de e-mail, etc. Não interessa a ele. Para ele o mais importante é tarefa. É criar uma task com o título e a descrição que ele tá passando. Não importa de guardamos isso no MySQL, PostgreSQL, Redis, MongoDB.. esses detalhes não importam pra ele.

Eles só precisam saber que "usando esse comando", eu consigo criar essa task. Vê como torna a terefa muito mais simples?

Isso faz com que nossa aplicação seja muito mais "simples" de testar/usar e funcione independente do Framework que utilizamos. Outro fato muito importante sobre Commands é que seja possível re-utilizar os commands em requisições diferentes, em um mecanismo de transporte totalmente diferente do HTTP (ver [Controllers e Mecanismos de Transporte](http://blog.tonydev.com.br/2014/02/21/controllers-e-mecanismos-de-transporte/)), até mesmo nos nossos *Events Listeners*.

Já *Domain Events* são ações que aconteceram na nossa aplicação (dica: use sempre nomes no passado) e que são importantes para a nossa aplicação. Por exemplo: UserSubscribed, TicketWasOpened, UserCanceledSubscription. A tarefa principal já aconteceu, mas podemos usar esses eventos para notificar os administradores sobre os mesmos, enviar e-mails de despedida ou qualquer outra tarefa secundária que quisermos. Utilizo "secundária" aqui não no sentido de "menos importante".

Vale falar também que esses eventos são gerados a partir de interações com os nossos modelos ou entidades. Uma coisa que achei muito legal no DDD é que eles incentivam a não usar Getters/Setters nas nossas entidades, fazendo com que os mesmos funcionem de forma muito semelhante aos conceitos do *business* (ver [Ubiquitous Language](http://martinfowler.com/bliki/UbiquitousLanguage.html)).

Digamos que estamos desenvolvendo um sistema de Helpdesk onde nossos atendentes são notificados quando determinadas tags
são associadas a um ticket. Temos, então, três modelos:

 - Atendee
 - Ticket
 - Tag

A primeira coisa que precisamos fazer é criar um Command, ou uma "ação" que a nossa aplicação sabe executar, assim:

{% highlight php %}
<?php namespace Phppb\Tickets;

class OpenTicketCommand
{
    public $tags = [];
    public $title;
    public $description;
    public $customer;

    function __construct($title, $description, Customer $customer, array $tags = [])
    {
        $this->title = $title;
        $this->description = $description;
        $this->customer = $customer;
        $this->tags = $tags;
    }
}

{% endhighlight %}

Um command, como já foi falado, é basicamente uma mensagem que o Controller irá passar para a nossa aplicação. Essa mensagem é um DTO, ou seja,
não deve conter lógica, apenas os dados necessários para passar pela fronteira da nossa aplicação. Cada *Command* deve ter
o seu *Handler*, de forma que exista uma associação 1-1. Isso quer dizer que não pode existir mais de um Handler pra um 
Command, nem um Command sem Handler.

O controller deve então passar esse Command para um CommandBus, esse que é uma classe que mapeia os Commands e seus Handlers,
passando o trabalho para um handler (ver [CommandBus.php](https://github.com/tonysm/commands-and-domain-events-tickets/blob/master/app/Acme/Commanding/CommandBus.php)).

O CommandHandler é quem faz o trabalho de criar o ticket, como podemos ver:

{% highlight php %}
<?php namespace Phppb\Tickets;

class OpenTicketCommandHandler implements Handler
{
    private $ticketsDao;
    private $dispatcher;

    public function handle($command)
    {
        $ticket = Ticket::open($command->title, $command->description, $command->customer, $command->tags);
        
        $this->ticketsDao->save($ticket);

        $this->dispatcher->dispatch($ticket->releaseEvents());

        return $ticket;
    }
}
{% endhighlight %}

Como podemos ver, o nosso handler chama o model Ticket para fazer o trabalho dele que é submeter um ticket. É ai que a
"mágica" acontece. Nossos *models* são provedores de eventos. Ou seja, tudo o que eles fazem, gera um Evento. Evento
esse que pode ser "ouvido" de outros lugares da nossa aplicação. Esses eventos são basicamente um aviso ao nosso
sistema/aplicação. Nesse caso, quando um cliente abre um ticket, nossa aplicação dispara algum evento para que
outros lugares dela possam se "adaptar" a esse acontecimento.

Vamos dar uma olhada no model Ticket:

{% highlight php %}
<?php namespace Phppb\Tickets;

use Phppb\Eventing\EventProviderInterface;
use Phppb\Eventing\EventProvider;

class Ticket implements EventProviderInterface
{
    use EventProvider;

    // ... imagine que tem outros métodos aqui :)

    public static function open($title, $description, $customer, $tags)
    {
        $ticket = new static($title, $description, $customer, $tags);

        $ticket->raise(
            new TicketWasOpened($ticket)
        );

        return $ticket;
    }
}
{% endhighlight %}

Não vou entrar na discussão do "porque" que usei um método estático aqui. Devemos evitar métodos estáticos. Nesse caso, como
se trata de um exemplo, resolvi usar (ver [When to use static methods](http://verraes.net/2014/06/when-to-use-static-methods-in-php/) e [Named constructors in PHP](http://verraes.net/2014/06/named-constructors-in-php/)).

Como podemos ver, nosso método *open* chama um método "raise" e passa para ele um evento. Lembrete: 
**nomeie seus eventos no passado**. Pois os mesmos já aconteceram. Sua aplicação deve "reagir" aos eventos ocorridos. Assim
sendo, nenhum "listener" dos eventos pode disparar erros. Os erros deve acontecer na validação. Você pode fazer a validação
no seu model, ou criar uma outra camada de validações, ao seu gosto.

Vamos dar uma olhada na trait e interface EventProvider:

{% highlight php %}
<?php

namespace Phppb\Eventing
{
    interface EventProviderInterface
    {
        /** @return array **/
        public function releaseEvents();
    }

    trait EventProvider
    {
        protected $domainEvents = [];

        protected function raise($event)
        {
            $this->domainEvents[] = $event;
        }

        public function releaseEvents()
        {
            $events = $this->domainEvents;
            $this->domainEvents = [];
            return $events;
        }
    }
}
{% endhighlight %}

Utilizei uma trait pois essa é uma forma de herança horizontal (ver [Traits em PHP. Herança horizontal](http://hlegius.pro.br/post/traits-em-php.-heranca-horizontal.)). Isso basicamente uma forma de "herança multipla". Veja bem, PHP não suporta herança multipla, as traits funcionam como receptáculos de métodos reutilizáveis e permite que nossas classes utilizem esses métodos sem precisar herdar um tipo ou comportamente de uma outra classe de nossa aplicação (ver [Traits](http://in3.php.net/traits)).

Perfeito, temos então uma forma das nossas entidades proverem eventos aos nossos CommandHandlers.

Em algum lugar na nossa aplicação podemos definir *listeners* para esse evento. Ah, antes que eu me esqueça, nossos
eventos, assim como nossos Commands, são apenas DTOs, ou seja, só devem conter dados, como vemos abaixo:

{% highlight php %}
<?php namespace Phppb\Tickets;

class TicketWasOpened extends Event
{
    public $ticket;

    function __construct(Ticket $ticket)
    {
        $this->ticket = $ticket;
    }
}

{% endhighlight %}

Agora, podemos então "escutar" esse evento para reagir a ele, vamos criar um listener para notificar nossos
attendees que um ticket foi criado:

{% highlight php %}
<?php namespace Phppb\Atendees\Listeners;

use Phppb\Tickets\Presenters\TicketMailPresenter;

class NotifyAttendeesAboutTicketOpened implements EventListener
{
    private $attendeesDao;
    private $emailNotifier;

    public function react($event)
    {
        $tags = $event->ticket->getTags();
        $atendees = $this->attendeesDao->findByTags($tags);

        foreach ($atendees as $atendee)
            $this->notifyNewTicket($atendee, $event->ticket);
    }
    
    private function notifyNewTicket($atendee, $ticket)
    {
        $mailTicket = $ticket->present(new TicketMailPresenter());
        $this->emailNotifier->sendNewTicketNotification($atendee->getEmail(), $mailTicket);
    }
}
{% endhighlight %}

Pronto. Temos nosso Command/Handler e nosso Domain Event implementado. Nosso controller ficaria mais ou menos assim:

{% highlight php %}
<?php

class TicketsController extends ApiController
{
    public function store()
    {
        $customer = $this->getAuthenticatedUser();
        $inputs = Input::only('title', 'description', 'tags');

        $command = new OpenTicketCommand(
            $inputs['title'],
            $inputs['description'],
            $customer,
            $inputs['tags']
        );

        $ticket = $this->commandBus->execute($command);

        return $this->toJson($ticket);
    }
}
{% endhighlight %}

Dessa forma, podemos então separar o que é "crucial" para o método do que é "reação". Nosso ticket ser aberto corretamente
é crucial. Nossos atendentes serem notificados do ticket criado é uma "reação".

Bom, é isso. Para um exemplo mais "completo", ver [esse repositório que criei](https://github.com/tonysm/commands-and-domain-events-tickets), o [Laracasts](https://laracasts.com/series/commands-and-domain-events) tem uma série sobre isso também, que é muito legal e de onde aprendi boa parte do que tô passando aqui. Ainda estou estudando e testando novas formas de implementar esses padrões e de usar DDD na prática,
mas acredito que o caminho é esse. E ai, o que acharam? Onde acham que errei? Sim, posso ter errado, esse é só um "rascunho"
do que entendi sobre o assunto. Estou aberto a opiniões!
