---
layout: post
title: Microframeworks
date: 2014-04-29 00:29:00
author: Ítalo Lelis de Vietro
categories: 
- frameworks
- tutorial
tags: 
- github
- slim 
- silex
- microframeworks
- frameworks
---

Voxê já deve ter ouvido falar em microframeworks, mas qual o propósito deles? Qual a diferença entre eles e os full-stack frameworks que estamos acostumados (Symfony, Zend, CodeIgniter....)? Eles resolvem todos os problemas? 

Nesse artigo iremos *mergulhar* em um universo que irá desvendar esses mistérios....
Então vamos lá :D

O que são?
---

Os microframeworks vieram com um propósito totalmente diferente dos full-stack. Muitas pessoas pensam que eles foram feitos para projetos pequenos (o que iremos ver que não é verdade). Eles foram projetados para diferentes arquiteturas.... Mas como assim?

Os full-stack frameworks muitas vezes nos prendem a uma determinada arquitetura ou estrutura da aplicação que temos uma grande dificuldade quando queremos modifica-la, mesmo que hoje a moda seja frameworks modulares, eles ainda definem a estrutura dos módulos, classes, e outras partes específicas. Isso não é ruim, mas em determinados problemas eles podem não ajudar muito.

Já os microframeworks trabalham de forma independente de arquiteturas ou restrições de estruturas de pastas, isso não quer dizer que não tenha organização, mas sim que você pode criar sua estrutura. Isso é possível porque eles foram feitos para não resolver todos os problemas existentes, existe um foco, eles foram criados para resolver problemas específicos (ou quebra-los em problemas menores). Umas das aplicações mais famosas para os microframeworks é a criação de webservices em cima da arquitetura REST, que iremos abordar mais a frente.

*Definição Pessoal*: Os microframeworks permitem a definição de vários componentes onde podemos anexa-los a uma arquitetura flexível, ou seja, podemos criar uma arquitetura (REST, RESTfull, MVC, Camadas, Modular, etc...) e utilizar os componentes que desejamos (ORM, Log, OAuth, etc...) como *"plugins"* para criarmos uma solução robusta, mas ao mesmo tempo simples de implementar.

Como funcionam?
---

Basicamente quase todos funcionam da maneira mais simples possível. Vamos ver um exemplo escrito em Silex (não se preocupe iremos abordar outros também):

**Silex**
```php
<?php
//Carregamos o silex via composer
require_once __DIR__.'/../vendor/autoload.php'; 

//Criamos uma instância da aplicação
$app = new Silex\Application(); 

//Criamos uma rota chamada /hello com um paramento para ser passado {name}
$app->get('/hello/{name}', function($name) use($app) { 
    return 'Hello '.$app->escape($name); 
}); 

//Rodamos a aplicação
$app->run(); 
```

**Slim**
```php
<?php
//Criamos uma instância da aplicação
$app = new \Slim\Slim();

//Criamos uma rota chamada /hello com um paramento para ser passado :name
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

//Rodamos a aplicação
$app->run();
```

**Limonade**
```php
<?php

require_once 'vendors/limonade.php';

//Criamos uma rota chamada /hello
dispatch('/', 'hello');


function hello()
{
  return 'Hello world!';
}

//Rodamos a aplicação 
run();
```

Notem que os comportamentos são muito parecidos entre eles. 
