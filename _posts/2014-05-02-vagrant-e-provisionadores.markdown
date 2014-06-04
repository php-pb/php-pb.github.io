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

### Por que usar Vagrant
Que atire a primeira pedra quem nunca usou a desculpa "funciona na minha máquina". Muitas vezes nem lembramos que pacotes temos instalados no nosso ambiente de desenvolvimento, é bastante comum que tudo funcione perfeito na nossa máquina e quando fazemos deploy, BOOM...

E quando surge um projeto novo, com dependências bem específicas, um banco de dados diferente, ou pacotes que não parecem muito estáveis? Instalar tudo isso na sua máquina é sempre bastante arriscado, principalmente se você não vai mais usar tais dependências no futuro - o que acontece com certa frequência. Sem contar projetos legados, usando versões antigas do PHP - um simples, pequeno bugfix, pode se tornar uma dor de cabeça enorme.

O Vagrant surgiu para dar um basta a esses problemas. Vagrant (traduzido como "Vagabundo", porém no sentido de não ter casa fixa) gerencia a criação de ambientes de desenvolvimento, normalmente utilizando máquinas virtuais. Você pode usar ferramentas de automação para criar o servidor do jeito que quiser, definindo tudo em arquivos que irão fazer parte da árvore do seu projeto. Dessa maneira, qualquer pessoa que clonar o seu repositório poderá rodar uma instância desse ambiente de desenvolvimento, que será exatamente igual para todo mundo, reduzindo ao máximo os problemas que surgem por causa das diferenças entre sistemas operacionais e configurações de sistema. Projetos Open Source vêm popularizando cada vez mais o Vagrant, porque fica bem mais fácil para outras pessoas contribuirem: com apenas um comando - vagrant up  - o projeto estará rodando e pronto para ser trabalhado.

### Como o Vagrant funciona

Existem 2 "atores" que executam papéis distintos e muito importantes no Vagrant: o _provedor_ (provider) e o _provisionador_ (provisioner). O **provedor** é responsável por criar uma instância de um ambiente, geralmente uma máquina virtual, com um sistema operacional básico instalado. Para ter seu ambiente de desenvolvimento pronto, você precisará executar uma série de tarefas, como instalação de pacotes e configuração do sistema - isso tudo é feito pelo **provisionador**. O provisionador é responsável por configurar o ambiente de maneira automatizada, assim temos um ambiente de desenvolvimento totalmente reproduzível e portátil.

A imagem abaixo exemplifica como o processo é administrado pelo Vagrant:



### Terminologia do Vagrant
- **Vagrantfile** - arquivo qu
- e contém as definições para criar a máquina virtual 
- **Box** - Uma Box (caixa) é um pacote que contém o esqueleto da sua máquina. É basicamente uma imagem de sistema operacional, mas pode já conter pacotes instalados / outras configurações 
- **Máquina Host** - a máquina que irá rodar o Vagrant e levantar o servidor definido através dos arquivos de configuração
- **Máquina Guest** - o servidor que foi levantado pelo Vagrant, a máquina virtual que irá rodar o seu projeto
- **Provedor (Provider)** - software de virtualização que irá levantar as máquinas virtuais. O padrão é VirtualBox, por ser gratuito e Open Source, mas existem outras opções como Vmware
- **Provisionador (Provisioner)** - software de automação que irá preparar a sua máquina, instalando pacotes e executando tarefas. As opções mais comuns são: Shell Script, Puppet, Chef, Ansible.


### Principais Comandos

- **vagrant up**  - faz o boot na máquina virtual. Na primeira vez que é executado, executa os provisionadores para cofigurar o ambiente
- **vagrant ssh**  - faz login na máquina virtual, não precisa de login ou senha
- **vagrant reload**  - reinicia a máquina virtual. Útil principalmente quando há mudanças no Vagrantfile
- **vagrant provision**  - roda apenas os provisionadores, sem reiniciar a máquina. Útil após fazer modificações no provisionamento
- **vagrant destroy**  - destrói a máquina virtual. Use quando quiser começar do zero com um `vagrant up` 
- **vagrant halt**  - "desliga" a máquina, equivalente a um shutdown
- **vagrant suspend**  - suspende a execução da máquina virtual salvando seu estado (ideal para o dia-a-dia quando desenvolvendo)
- **vagrant resume**  - retoma uma máquina virtual previamente suspensa

### Instalação

Para um setup básico, você precisará instalar o Vagrant e o VirtualBox em sua máquina. A melhor maneira de fazer isso é buscar os pacotes mais atualizados diretamente na [página do Vagrant](http://www.vagrantup.com/downloads.html) e na [página do VirtualBox](https://www.virtualbox.org/wiki/Downloads). Ambos estão disponíveis para os principais sistemas operacionais.

### Primeiros Passos

Vamos começar com um exemplo bem básico utilizando um simples shell script como provisionador, só para que você entenda como o processo todo funciona. A primeira coisa que precisamos fazer é criar um arquivo Vagrantfile. O Vagrantfile é o arquivo de configuração do seu ambiente de desenvolvimento.

Abaixo, um exemplo de um Vagrantfile super básico:

~~~~~~~~
Vagrant.configure("2") do |config|

    config.vm.box = "hashicorp/precise64"
    
    config.vm.provision "shell", inline: "echo Hello World!"

end
~~~~~~~~

Esse é o exemplo mais simples que mostra o processo completo, incluindo um provisionador. Estamos aqui usando a [Vagrant Cloud](https://vagrantcloud.com/) para obtermos nossa box - dessa maneira não precisamos definir também a URL onde o arquivo .box está disponível. Esse é um recurso novo da versão **1.5** do Vagrant. Você pode descobrir outras boxes, com outros sistemas operacionais, na seção "[Discover](https://vagrantcloud.com/discover/featured)" da VagrantCloud. Neste exemplo, usamos a box atualmente mais popular do Vagrant - Ubuntu 12.04 64 bits.

Como vocês podem ver, usamos o provisionador Shell, passando um comando inline. Agora, vamos rodar esse ambiente - para isso, acesse a pasta onde o Vagrantfile está localizado, pelo terminal, e execute:

~~~~~~~~
$ vagrant up
~~~~~~~~

Você verá um output similar a este:

(image)

Note que, ao final do processo, o provisionador Shell é executado, e você verá o output "Hello World!". Esse comando está sendo executado dentro da máquina virtual, a máquina **Guest**. 

#### Nota: Executando os Provisionadores

Por padrão, os provisionadores só são executados na primeira vez que você roda um `vagrant up`, quando o ambiente é criado. Nas próximas vezes que você for usar o ambiente, ele já estará pronto, por isso o Vagrant não irá executar por padrão os provisionadores novamente - isso economiza bastante tempo no dia a dia. Mas há ocasiões em que precisamos executar os provisionadores novamente - principalmente quando estamos criando e ajustando os scripts de provisionamento.

Para executar novamente os provisionadores numa VM que já foi criada, mas está desligada, use `vagrant up --provision`. Se a máquina já está ligada, você pode usar `vagrant provision` para executar os provisionadores diretamente, ou `vagrant reload --provision` para reiniciar a máquina e então executar os provisionadores.




