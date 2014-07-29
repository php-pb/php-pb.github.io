---
layout: post
title:  Composer for smart guys
date:   2014-07-29 22:50:00
author: Jefersson Nathan
categories: 
- dependências
- composer
tags: 
- github
- composer
- tips
---
Ah composer! Que ferramenta fantástica. Quem diria que em tão pouco tempo desbancaria
o pear. Ah composer ;)

Se você ainda não conhece o composer, indico fortemente que leia esses artigos,
antes de prosseguir:

- [Introdução ao composer [Documentação official]](https://getcomposer.org/doc/00-intro.md)
- [Introdução ao Composer { Parte 1 } - PHP Maranhão](http://www.phpmaranhao.com.br/introducao-ao-composer-parte-1/)
- [Introdução ao Composer { Parte 2 } - PHP Maranhão](http://www.phpmaranhao.com.br/tag/iniciando-com-o-composer/)

Para quem tiver saco de ler outro artigo meu, tive a oportunidade de escrever o artigo [Managing your project's dependencies with Composer](http://webandphp.com/Managingyourproject'sdependencieswithComposer) na [PHP Magazine](http://webandphp.com/) .


## O autoload

O `autoload.php` é um arquivo utilizado em nosso projeto para termos
acesso a todas as nossas classes e as de terceiros, sem ficar incluindo arquivos na 
**mão grande** a todo momento.

Mas, o que mais podemos fazer com esse arquivo?

Ao incluirmos esse arquivo, ele nos retorna um objeto `Loader` que pode ser usado 
para registrar um path de autoload, e o próprio sistema de autoload que o composer 
gerou, dará fallback em todas as pastas a partir de agora.

Bacana, não?

E como bexiga, pego esse objeto? `require` neles.

{% highlight php %}
<?php
$loader = require __DIR__ . '/vendor/autoload.php';
{% endhighlight %}

Assim podemos registrar uma nova namespace para o autoload a partir do 
método `void add(String $namespace, String $directoryPath)`.

{% highlight php %}
<?php
$loader = require __DIR__ . '/vendor/autoload.php';
$loader->add('PHP\\Nordeste\\', __DIR__);
{% endhighlight %}

**Como costumo usar isso?**

Supondo que temos uma aplicação de pagamento com várias versões (com nomes de arquivos e estrutura de classes idênticas),
podemos alternar facilmente entre as versão, registrando um novo loader dinamicamente, de acordo
com a versão adiquirida para cada cliente em específico.

{% highlight php %}
<?php

define('CLIENT_VERSION', '1.2.34');

$loader = require __DIR__ . '/vendor/autoload.php';
$loader->add(CLIENT_VERSION . '\\Payment\\', __DIR__);
{% endhighlight %}

Não que seja a melhor solução, mas, acho interessante.

***Nota do manual***

    Composer provides its own autoloader. If you don't want to use that one, 
    you can just include vendor/composer/autoload_*.php files, which return 
    associative arrays allowing you to configure your own autoloader.


## Update

Um dos motivos para a comunidade PHP ter adotado o composer como ferramenta principal para gerenciar as dependências de nossos projetos, é sua facilidade para gerir nosso ambiente, atualizar componentes, etc...

É sabido que, para atualizar nossas dependências a partir de um arquivo `composer.json`, basta rodarmos um `composer update` no diretório onde o arquivo se encontra. Uma coisa que pouca gente sabe, é que podemos atualizar apenas um componente, usando o nome do vendor e pacote como argumento para o composer, o que resultaria em `composer update foo/bar`

Por exemplo, se necessário adicionar mais um `author` ao `composer.json` e alguns parâmetros adicionais, observaremos que o composer nos mostra a seguinte mensagem de warning:

{% highlight sh %}
Warning: The lock file is not up to date with the latest changes in composer.json,
you may be getting outdated dependencies, run update to update them.
{% endhighlight %}

Não se preocupe, quando você modifica algo no `composer.json`, o `md5sum` do arquivo muda. Logo, o composer mostra um alerta indicando que o hash guardado no `composer.lock` é diferente do esperado em `composer.json`. E agora?

Como não mudamos nenhuma biblioteca, podemos rodar o comando `composer update --lock`, que fará o composer reescrever o arquivo `composer.lock` sem reinstalar as dependências pré-existentes descritas para nossa aplicação.


## Show

Exibe informações de todos os pacotes disponíveis, e os quais se tem instalado em seu projeto atual. 

**OBS:** *Pode demorar MUITO a depender da sua conexão.*

## create-project

Uma forma rápida de clonar um repositório e coloca-ló em um branch específico, é usando o parâmetro `create-project`. Também é uma mão na roda, quando não se sabe a URI completa do repositório que se quer clonar. 

{% highlight sh %}
composer create-project joomla/application path 1.2.1
{% endhighlight %}

## Require

Sabia que você pode adicionar uma nova biblioteca ao arquivo `composer.json` sem editar manualmente? Este é um processo muito conveniente para aqueles que já estão no terminal, pois não precisam abrir um editor para colocar uma nova linha em nossa lista de dependências.

O `require` pode fazer isso por nós.

{% highlight sh %}
$ composer require "respect/validation"
{% endhighlight %} 

O que também pode ser usado no início de um novo projeto. O comando `init` inclui a opção `--require` que pode ser usado para escrever um novo arquivo `composer.json`.

{% highlight sh %}
$ composer init --require=respect/validation:1.0.0
{% endhighlight %}

## Status

Se alguma modificação for feita em algum `vendor`, pode ser vista usando o comando `status`.

{% highlight sh %}
$ composer status -v
{% endhighlight %}

## Produção

Só para que não esqueça. Antes de fazer deploy do seu código para produção não esqueça de otimizar o autoload.

{% highlight sh %}
$ composer dump-autoload --optimizer
{% endhighlight %}



## Até breve...

Para complementar a leitura desse post, indico que leiam o [Composer Cheat Sheet for developers](http://composer.json.jolicode.com/), a [documentação do composer](https://getcomposer.org/doc/) e fiquem ligados no que tá rolando no [repositório no github](https://github.com/composer/composer).
