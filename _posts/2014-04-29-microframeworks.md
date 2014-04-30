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

*Definição Pessoal*: Os microframeworks permitem a definição de vários componentes onde podemos anexa-los a uma arquitetura flexível, ou seja, podemos criar uma arquitetura (REST, Restful, MVC, Camadas, Modular, etc...) e utilizar os componentes que desejamos (ORM, Log, OAuth, etc...) como *"plugins"* para criarmos uma solução robusta, mas ao mesmo tempo simples de implementar.

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

Notem que os comportamentos são muito parecidos entre eles. Com poucas linhas de código já temos um resultado na tela, mas claro que vale lembrar que com essas poucas linhas temos uma gama de funcionalidades que eles disponibilizam para nós. Vamos utilizar o Silex para os exemplos a seguir.

A maioria dos microframeworks disponibilizam componentes que encapsulam as soluções e provem uma série de métodos para utilizarmos, por exemplo:

Para utilizarmos ORM em nossa aplicação:
```json
//no composer.json
"dflydev/doctrine-orm-service-provider": "v1.0.3"
```

Para utilizarmos ORM em nossa aplicação:
```php
//Carregamos o silex via composer
require_once __DIR__.'/../vendor/autoload.php'; 

//Criamos uma instância da aplicação
$app = new Silex\Application(); 

//Registramos nosso provedor de serviços
$app->register(new \Silex\Provider\DoctrineServiceProvider());
$app->register(new \Dflydev\Silex\Provider\DoctrineOrm\DoctrineOrmServiceProvider(), array(
    'connection' => 'default',
    "orm.auto_generate_proxies" => true,
    "mappings" => array(
        array(
            "type" => "annotation",
            'use_simple_annotation_reader' => false,
            "namespace" => "Entity",
            "path" => __DIR__ . "/Entity"
        )
    )
);

//Criamos uma rota chamada /hello com um paramento para ser passado {name}
$app->get('/hello/{name}', function($name) use($app) { 
    $user = $app['orm.em']->getRepository('User')->findBy(array('name' => $name));
    
    return 'Hello '. $user->getUsername(); 
}); 

//Rodamos a aplicação
$app->run(); 
```    

É muito elegante a forma que podemos trabalhar com acesso ao banco e suporte a ORM com poucas linhas escritas. O silex vem com diversos *build-in* Providers para você poder utilizar, [confira aqui quais são](http://silex.sensiolabs.org/documentation).

Criando uma API Restful
---

Para não extendermos muito esse artigo, vou mostrar como podemos criar uma API Restful para o Silex.

Vamos criar nossa estrutura de pastas:

* config/
* src/
* test/
* web/
* composer.json

Na pasta config, crie dois arquivos:

* dev.php
* prod.php

Eles serão responsáveis pelas configurações da nossa aplicação:

Na pasta src, crie dois arquivos:

* app.php
* controllers.php

O arquivo app.php é responsável por registrar nossos providers e o controllers.php por conter nossa lógica.

E por fim na pasta web criamos dois arquivos também:

* index.php
* index_dev.php

No arquivo composer.json insira as seguintes linhas:

```json
{
    "name": "phppb/silex-restful-exemple",
    "description": "Exemplo de uma API restful simples para o silex",
    "type": "application",
    "license": "MIT",
    "keywords": ["restful", "silex", "api"],
    "authors": [
        {
            "name": "Ítalo Lelis de Vietro",
            "email": "italolelis@lellysinformatica.com"
        }
    ],
    "require": {
        "php": ">=5.3.3",
        "silex/silex": "~1.0",
        "silex/web-profiler": "~1.0"
    },
    "require-dev": {
        "phpunit/phpunit": "3.7.*"
    },
    "autoload": {
        "psr-0": {
            "": "src/"
        }
    }
}
```

Nós estamos declarando as dependências do silex. Vamos rodar o comando **composer install** para instalarmos nossas dependências. Agora temos tudo pronto para desenvolvermos nossa API.


