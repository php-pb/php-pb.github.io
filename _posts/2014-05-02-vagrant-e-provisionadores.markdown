---
layout: post
status: publish
published: true
title: Vagrant e Provisionadores - um guia basico
author: Erika Heidi
date: '2014-05-02 10:41:27 -0300'
date_gmt: '2014-05-02 10:41:27 -0300'
categories:
- devops
tags:
- Vagrant
- Puppet
- Ansible
- VM
---

### Terminologia
- Vagrantfile - arquivo que contém as definições para criar a máquina virtual 
- Box - Uma Box (caixa) é um pacote que contém o esqueleto da sua máquina. É basicamente uma imagem de sistema operacional, mas pode já conter pacotes instalados / outras configurações 
- Host Machine - a máquina que irá rodar o Vagrant e levantar o servidor definido através dos arquivos de configuração
- Guest Machine - o servidor que foi levantado pelo Vagrant, a máquina virtual que irá rodar o seu projeto
- Provider - software de virtualização que irá levantar as máquinas virtuais. O padrão é VirtualBox, por ser gratuito e Open Source, mas existem outras opções como Vmware
- Provisioner - software de automação que irá preparar a sua máquina, instalando pacotes e executando tarefas. As opções mais comuns são: Shell Script, Puppet, Chef, Ansible.
