---
layout: post
title: Commands e Domain Events
date: 2014-06-09 15:15:00
author: Tony Messias
categories: 
tags: 
---

Lidar com complexidade é tarefa rotineira de um desenvolvedor de software. "Será que esse código tá bom?" ou "Como testar
isso?" são perguntas frequentes quando estou desenvolvendo. Mas nem sempre precisamos quebrar a cabeça criando soluções
para os nossos problemas. 

Existem vários padrões catalogados para problemas semelhantes aos nossos. Pois é, o seu
sistema não é lá tão diferente dos outros sistemas lá fora. Em uma das minhas buscas para soluções simples para os
problemas do dia-a-dia me deparei com *DDD*, *Domain Events*, *Commands*, etc, etc... Achei muito legal a ideia por trás
e desde então venho estudando tópicos relacionados a esse.
 
<!-- more -->

Digamos que estamos desenvolvendo um sistema de Helpdesk onde nossos atendentes são notificados quando determinadas tags
são associadas a um ticket. Temos, então, três modelos:

 - Atendee
 - Ticket
 - Tag

A primeira coisa que precisamos fazer é criar um Command, ou uma "ação" que a nossa aplicação sabe executar, assim:

{% highlight php %}
<?php namespace Phppb\Tickets;

class SubmitTicketCommand
{
    public $tags = [];
    public $title;
    public $description;
    public $created_at;
    public $customer;

    function __construct($title, $description, Customer $customer, \DateTime $created_at, array $tags = [])
    {
        $this->title = $title;
        $this->description = $description;
        $this->customer = $customer;
        $this->tags = $tags;
        $this->created_at = $created_at;
    }
}

{% endhighlight %}

Um command é basicamente uma mensagem que o Controller irá passar para a nossa aplicação. Essa mensagem é um DTO, ou seja,
não deve conter lógica, apenas os dados necessários para passar pela fronteira da nossa aplicação. Cada *Command* deve ter
o seu *Handler*, de forma que exista uma associação 1-1. Isso quer dizer que não pode existir mais de um Handler pra um 
Command, nem um Command sem Handler.

O controller deve então passar esse Command para um CommandBus, esse que é uma classe que mapeia os Commands e seus Handlers,
passando o trabalho para um handler.

O CommandHandler é quem faz o trabalho de criar o ticket, como podemos ver:

{% highlight php %}
<?php namespace Phppb\Tickets;

class SubmitTicketCommandHandler implements Handler
{
    private $ticketsDao;
    private $dispatcher;

    public function handle($command)
    {
        $ticket = Ticket::submit($command->title, $command->description, $command->customer, $command->created_at, $command->tags);
        
        $this->ticketsDao->save($ticket);

        $this->dispatcher->dispatch($ticket->releaseEvents());

        return $ticket;
    }
}
{% endhighlight %}

Como podemos ver, o nosso handler chama o model Ticket para fazer o trabalho dele que é submeter um ticket. É ai que a
"mágica" acontece. Nossos *models* são provedores de eventos. Ou seja, tudo o que eles fazem, gera um Evento. Evento
esse que pode ser "ouvido" de outros lugares da nossa aplicação. Esses eventos são basicamente um aviso ao nosso
sistema/aplicação. Nesse caso, quando um cliente submete um ticket, nossa aplicação dispara algum evento para que
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

    public static function submit($title, $description, $customer, $created_at, $tags)
    {
        $ticket = new static($title, $description, $customer, $created_at, $tags);

        $ticket->raise(
            new TicketWasSubmited($ticket)
        );

        return $ticket;
    }
}
{% endhighlight %}

Não vou entrar na discussão do "porque" que usei um método estático. Devemos evitar métodos estáticos. Nesse caso, como
se trata de um exemplo, resolvi usar. Porque sim.

Como podemos ver, nosso método *submit* chama um método "raise" e passa para ele um evento. Aqui vai uma dica: 
nomeie seus eventos no passado. Pois os mesmos já aconteceram. Sua aplicação deve "reagir" aos eventos ocorridos. Assim
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

Perfeito, temos então uma forma dos nossos models proverem eventos aos nossos CommandHandlers.

Em algum lugar na nossa aplicação podemos definir *listeners* para esse evento. Ah, antes que eu me esqueça, nossos
eventos, assim como nossos Commands, são apenas DTOs, ou seja, só devem conter dados, como vemos abaixo:

{% highlight php %}
<?php namespace Phppb\Tickets;

class TicketWasSubmited extends Event
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

class NotifyAttendeesAboutTicketSubmited implements EventListener
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

        $command = new SubmitTicketCommand(
            $inputs['title'],
            $inputs['description'],
            $customer,
            new \DateTime(),
            $inputs['tags']
        );

        $ticket = $this->commandBus->execute($command);

        return $this->toJson($ticket);
    }
}
{% endhighlight %}

Dessa forma, podemos então separar o que é "crucial" para o método do que é "reação". Nosso ticket ser submetido corretamente
é crucial. Nossos atendentes serem notificados do ticket criado é uma "reação".

Bom, é isso. Ainda estou estudando e testando novas formas de implementar esses padrões e de usar DDD na prática,
mas o caminho é esse. E ai, o que acharam? Onde acham que errei? Sim, posso ter errado, esse é só um "rascunho"
do que entendi sobre o assunto. Estou aberto a opiniões!
