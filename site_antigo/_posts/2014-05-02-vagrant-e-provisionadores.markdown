---
layout: post
status: publish
published: true
title: Vagrant e Provisionadores - um guia básico
author: Erika Heidi
date: '2014-06-04 10:41:27 -0300'
date_gmt: '2014-06-04 10:41:27 -0300'
categories:
    - devops
tags:
    - Vagrant
    - Puppet
    - Ansible
    - VM
---

## Por que usar Vagrant
Que atire a primeira pedra quem nunca usou a desculpa "funciona na minha máquina". Muitas vezes nem lembramos quais pacotes temos instalados no nosso ambiente de desenvolvimento, é bastante comum que tudo funcione perfeito na nossa máquina e quando fazemos deploy, BOOM...

![batman](http://i.imgur.com/pdclwXs.jpg)

E quando surge um projeto novo, com dependências bem específicas, um banco de dados diferente, ou pacotes que não parecem muito estáveis? Instalar tudo isso na sua máquina é sempre bastante arriscado, principalmente se você não vai mais usar tais dependências no futuro - o que acontece com certa frequência. Sem contar projetos legados, usando versões antigas do PHP - um simples, pequeno bugfix, pode se tornar uma dor de cabeça enorme.

O Vagrant surgiu para dar um basta a esses problemas. Vagrant (traduzido como "Vagabundo", porém no sentido de não ter casa fixa) gerencia a criação de ambientes de desenvolvimento, normalmente utilizando máquinas virtuais. Você pode usar ferramentas de automação para criar o servidor do jeito que quiser, definindo tudo em arquivos que irão fazer parte da árvore do seu projeto. Dessa maneira, qualquer pessoa que clonar o seu repositório poderá rodar uma instância desse ambiente de desenvolvimento, que será exatamente igual para todo mundo, reduzindo ao máximo os problemas que surgem por causa das diferenças entre sistemas operacionais e configurações de sistema. Projetos Open Source vêm popularizando cada vez mais o Vagrant, porque fica bem mais fácil para outras pessoas contribuirem: com apenas um comando - vagrant up  - o projeto estará rodando e pronto para ser trabalhado.

## Como o Vagrant funciona

Existem 2 "atores" que executam papéis distintos e muito importantes no Vagrant: o _provedor_ (provider) e o _provisionador_ (provisioner). O **provedor** é responsável por criar uma instância de um ambiente, geralmente uma máquina virtual, com um sistema operacional básico instalado. Para ter seu ambiente de desenvolvimento pronto, você precisará executar uma série de tarefas, como instalação de pacotes e configuração do sistema - isso tudo é feito pelo **provisionador**. O provisionador é responsável por configurar o ambiente de maneira automatizada, assim temos um ambiente de desenvolvimento totalmente reproduzível e portátil.

![como funciona](http://i.imgur.com/RnlvjUO.png)

## Terminologia do Vagrant
- **Vagrantfile** - arquivo que contém as definições para criar a máquina virtual 
- **Box** - Uma Box (caixa) é um pacote que contém o esqueleto da uma máquina virtual com um sistema operacional e alguns pacotes básicos instalados. 
- **Máquina Host** - a máquina que irá rodar o Vagrant e levantar o servidor definido através dos arquivos de configuração
- **Máquina Guest** - o servidor que foi levantado pelo Vagrant, a máquina virtual que irá rodar o seu projeto
- **Provedor (Provider)** - software responsável por prover um ambiente, normalmente virtualizado (uma VM). O padrão é VirtualBox, por ser gratuito e Open Source, mas existem várias outras opções
- **Provisionador (Provisioner)** - software de automação que irá preparar a sua máquina, instalando pacotes e executando tarefas. As opções mais comuns são: Shell Script, Puppet, Chef, Ansible.
- **Diretórios Sincronizados** - os diretórios sincronizados permitem que você continue trabalhando na sua máquina Host, com sua IDE favorita, enquanto usa a máquina Guest apenas para rodar o servidor web, por exemplo. Mudanças nos arquivos da aplicação serão refletidas automaticamente dentro da VM.

## Principais Comandos

- **vagrant up**  - faz o boot na máquina virtual. Na primeira vez que é executado, executa os provisionadores para cofigurar o ambiente
- **vagrant ssh**  - faz login na máquina virtual, não precisa de login ou senha
- **vagrant reload**  - reinicia a máquina virtual. Útil principalmente quando há mudanças no Vagrantfile
- **vagrant provision**  - roda apenas os provisionadores, sem reiniciar a máquina. Útil após fazer modificações no provisionamento
- **vagrant destroy**  - destrói a máquina virtual. Use quando quiser começar do zero com um `vagrant up` 
- **vagrant halt**  - "desliga" a máquina, equivalente a um shutdown
- **vagrant suspend**  - suspende a execução da máquina virtual salvando seu estado (ideal para o dia-a-dia quando desenvolvendo)
- **vagrant resume**  - retoma uma máquina virtual previamente suspensa

## Instalação

Para um setup básico, você precisará instalar o Vagrant e o VirtualBox em sua máquina. A melhor maneira de fazer isso é buscar os pacotes mais atualizados diretamente na [página do Vagrant](http://www.vagrantup.com/downloads.html) e na [página do VirtualBox](https://www.virtualbox.org/wiki/Downloads). Ambos estão disponíveis para os principais sistemas operacionais.

## Primeiros Passos

A primeira coisa que precisamos fazer é criar um arquivo Vagrantfile. O Vagrantfile é o arquivo de configuração do seu ambiente de desenvolvimento.

Abaixo, um exemplo de um Vagrantfile super básico:

{% highlight ruby %}
Vagrant.configure("2") do |config|

    config.vm.box = "hashicorp/precise64"
    
    config.vm.provision "shell", inline: "echo Hello World!"

end
{% endhighlight %}

Esse é o exemplo mais simples que mostra o processo completo, incluindo um provisionador. Estamos aqui usando a [Vagrant Cloud](https://vagrantcloud.com/) para obtermos nossa box - dessa maneira não precisamos definir também a URL onde o arquivo .box está disponível. Esse é um recurso novo da versão **1.5** do Vagrant. Você pode descobrir outras boxes, com outros sistemas operacionais, na seção **[Discover](https://vagrantcloud.com/discover/featured)** da VagrantCloud. Neste exemplo, usamos a box atualmente mais popular do Vagrant - Ubuntu 12.04 64 bits.

Como vocês podem ver, usamos o provisionador Shell, passando um comando inline. Agora, vamos rodar esse ambiente - para isso, acesse a pasta onde o Vagrantfile está localizado, pelo terminal, e execute:

{% highlight sh %}
$ vagrant up
{% endhighlight %}

Você verá um output similar a este:

![output](http://i.imgur.com/q0EqBmY.png)

Note que, ao final do processo, o provisionador Shell é executado, e você verá o output "Hello World!". Esse comando está sendo executado dentro da máquina virtual, a máquina **Guest**. 

#### Nota: Executando os Provisionadores

Por padrão, os provisionadores só são executados na primeira vez que você roda um `vagrant up`, quando o ambiente é criado. Nas próximas vezes que você for usar o ambiente, ele já estará pronto, por isso o Vagrant não irá executar por padrão os provisionadores novamente - isso economiza bastante tempo no dia a dia. Mas há ocasiões em que precisamos executar os provisionadores novamente - principalmente quando estamos criando e ajustando os scripts de provisionamento.

Para executar novamente os provisionadores numa VM que já foi criada, mas está desligada, use `vagrant up --provision`. Se a máquina já está ligada, você pode usar `vagrant provision` para executar os provisionadores diretamente, ou `vagrant reload --provision` para reiniciar a máquina e então executar os provisionadores.

## Usando Ferramentas de Automação

Apesar de parecer a opção mais simples e fácil, Shell script não é a melhor forma de provisionar o seu ambiente de desenvolvimento. Existem ferramentas que foram criadas especificamente para a finalidade de automatizar tarefas em servidores, e elas possuem muitos recursos que você teria de implementar por conta própria caso estivesse preparando seu provisionamento com Shell script - como por exemplo a utilização de templates, comportamento [idempotente](http://pt.wikipedia.org/wiki/Idempot%C3%AAncia), modularização, dentre outros. 

O Vagrant suporta várias ferramentas de automação. As mais populares são: Puppet, Chef e Ansible, nesta ordem. Não existe uma ferramenta melhor que a outra, mas cada uma tem vantagens e características específicas que podem se adequar melhor para o que você pretende fazer; de uma maneira geral, tudo que pode ser feito em uma ferramenta poderá também ser implementado em outra, mas o nível de complexidade pode variar bastante entre elas.

### Comparação entre ferramentas

Segue um resumo das principais diferenças entre as ferramentas de automações mais usadas como provisionadores do Vagrant, de maneira que você possa compará-las entre si e escolher aquela com a qual você se identifica mais.

#### Puppet

- **Syntaxe usada** - linguagem customizada baseada no Ruby
- **Ordem de execução** - **não sequencial** - você precisa definir dependências entre as tarefas
- **Popularidade** - a mais popular, exceto para desenvolvedores Ruby.
- **Documentação** - um pouco confusa
- **Curva de aprendizado** - média
- **Dependências (Vagrant)** - não é preciso instalar nenhum pacote adicional para usar Puppet como provisionador

Exemplo de definição de tarefas:

{% highlight ruby %}
exec { 'apt-get update':
  command => 'apt-get update'
}

package { 'nginx':
  ensure => 'installed'
  require => Exec['apt-get update']
}
{% endhighlight %}

Repare que precisamos usar um **require** na instalação do pacote _Nginx_, para termos certeza de que a primeira tarefa, que roda `apt-get update`, seja executada **antes**. Se não usarmos o _require_, não há nenhuma garantia sobre a ordem de execução das tarefas.

#### Chef

- **Syntaxe usada** - Ruby 
- **Ordem de execução** - sequencial
- **Popularidade** - segunda mais popular, primeira entre desenvolvedores Ruby. 
- **Documentação** - caótica!
- **Curva de aprendizado** - alta, você precisa aprender um pouco de Ruby para escrever os scripts
- **Dependências (Vagrant)** - não é preciso instalar nenhum pacote adicional para usar Chef como provisionador

Exemplo de definição de tarefas:

{% highlight ruby %}
execute "apt-get update" do
  command "apt-get update"
end

apt_package "nginx" do
  action :install
end
{% endhighlight %}

#### Ansible

- **Syntaxe usada** - YAML
- **Ordem de execução** - sequencial
- **Popularidade** - terceira mais popular
- **Documentação** - clara e objetiva
- **Curva de aprendizado** - pequena
- **Dependências (Vagrant)** - você precisará instalar o Ansible na máquina Host para usá-lo como provisionador

Exemplo de definição de tarefas:

{% highlight yaml %}
- name: Update apt-cache
  apt: update_cache=yes

- name: Install Nginx
  apt: pkg=nginx state=latest
{% endhighlight %}


### Recursos para Iniciantes

Para uma visão mais detalhada e prática sobre as diferenças entre estes três provisionadores, você pode checar [este repositório no GitHub](https://github.com/erikaheidi/nomad-vagrant). Ele contém um exemplo prático de provisionamento de um servidor PHP com Nginx+PHP5-FPM, em Ansible, Puppet e Chef. 

Para ter um ponto de partida prático e fácil, você também pode usar uma ferramenta web que gera provisionamentos de ambientes PHP. Temos duas ferramentas atualmente com essa finalidade: 

- [PuPHPet](https://puphpet.com) - usa Puppet como provisionador. Suporta múltiplos provedores e possui uma grande quantidade de recursos, incluindo bancos de dados.
- [Phansible](http://phansible.com) -  inspirado pelo PuPHPet, usa Ansible como provisionador. Lançado há poucos meses, possui recursos básicos mas já é possível criar um provisionamento de diferentes web servers com PHP, incluindo HHVM.

O Phansible é um projeto open source criado por mim como uma alternativa ao já popular PuPHPet. Estamos trabalhando na implementação de novos recursos, e aceitamos [contribuições](https://github.com/Phansible/phansible) :)

Se você quer conhecer mais recursos do Vagrant, incluindo as novidades lançadas nas últimas versões, fique de olho na versão em português do [Vagrant Cookbook](https://leanpub.com/vagrantcookbook-ptbr), prevista para lançamento no final de junho. Você pode baixar um [preview gratuito aqui](http://samples.leanpub.com/vagrantcookbook-ptbr-sample.pdf).

### Considerações Finais

O Vagrant pode ajudar bastante no seu processo de desenvolvimento, especialmente em duas situações: quando você está trabalhando em um projeto com outros colaboradores, para evitar problemas na diferença dos ambientes de desenvolvimento usados; e quando seu projeto possui dependências que podem "bagunçar" o seu sistema operacional principal. Pessoalmente, só uso o Vagrant nessas duas situações, mas elas representam 80% dos projetos em que me envolvo. Quando tenho algo muito simples que não usa banco de dados, opto por usar um servidor web local, pois como minha máquina host é Ubuntu, não vejo a necessidade de criar um provisionamento para rodar um simples _Nginx_ com PHP. Mesmo nesses casos, se o projeto possui colaboradores, já é uma razão para se fornecer um setup Vagrant. 

A escolha do provisionador vai depender bastante do seu background como desenvolvedor e com o que você se sente mais confortável. Apesar de requerer a instalação de um software adicional, Ansible pra mim é o mais simples, e por isso o que mais uso atualmente. A syntaxe em YAML é bastante intuitiva. Mas se você precisa realizar tarefas complexas que exigem mais programação em seus scripts de provisionamento, Chef pode ser uma ótima solução - você pode usar praticamente qualquer coisa do Ruby dentro dos scripts. Puppet, por outro lado, é bastante popular por ser uma das primeiras ferramentas desse tipo, e por isso você pode encontrar mais recursos (tutoriais, módulos) em Puppet do que em outras ferramentas.
