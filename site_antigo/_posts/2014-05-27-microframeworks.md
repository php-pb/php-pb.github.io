---
layout: post
title: O que são microframeworks?
date: 2014-05-27 00:29:00
author: Ítalo Lelis de Vietro
categories: 
    - frameworks
    - tutorial
tags: 
    - github
    - slim 
    - silex
    - limonade
    - microframeworks
    - frameworks
---

Você já deve ter ouvido falar em microframeworks, mas qual o propósito deles? Qual a diferença entre eles e os full-stack frameworks que estamos acostumados (Symfony, Zend, CodeIgniter....)? Eles resolvem todos os problemas? 

Nesse artigo iremos *mergulhar* em um universo que irá desvendar esses mistérios....
Então vamos lá :D

O que são?
---

Os microframeworks vieram com um propósito totalmente diferente dos full-stack. Muitas pessoas pensam que eles foram feitos para projetos pequenos (o que iremos ver que não é verdade). Eles foram projetados para diferentes arquiteturas.... Mas como assim?

Os full-stack frameworks muitas vezes nos prendem a uma determinada arquitetura ou estrutura da aplicação onde podemos ter uma grande dificuldade quando queremos modifica-la, mesmo que hoje a moda seja frameworks modulares, eles ainda definem a estrutura dos módulos, classes, e outras partes específicas. Isso não é ruim, mas em determinados cenários eles podem não ajudar muito.

Já os microframeworks trabalham de forma independente de arquiteturas ou restrições de estruturas de pastas, isso não quer dizer que não tenham organização, mas sim que você pode criar sua estrutura. Isso é possível porque eles foram feitos para não resolver todos os problemas existentes, existe um foco, eles foram criados para resolver problemas específicos (ou quebra-los em pedaços menores). Umas das aplicações mais famosas para os microframeworks é a criação de webservices em cima da arquitetura REST, que iremos abordar mais a frente.

*Definição Pessoal*: Os microframeworks permitem a definição de vários componentes onde podemos anexa-los a uma arquitetura flexível, ou seja, podemos criar uma arquitetura (REST, Restful, MVC, Camadas, Modular, etc...) e utilizar os componentes que desejamos (ORM, Log, OAuth, etc...) como *"plugins"* para criarmos uma solução robusta, mas ao mesmo tempo simples de implementar.

Como funcionam?
---

Basicamente quase todos funcionam da maneira mais simples possível. Vamos ver um exemplo escrito em Silex (não se preocupe iremos abordar outros também):

**Silex**
{% highlight php %}
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
{% endhighlight %}

**Slim**
{% highlight php %}
<?php
//Criamos uma instância da aplicação
$app = new \Slim\Slim();

//Criamos uma rota chamada /hello com um paramento para ser passado :name
$app->get('/hello/:name', function ($name) {
    echo "Hello, $name";
});

//Rodamos a aplicação
$app->run();
{% endhighlight %}

**Limonade**
{% highlight php %}
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
{% endhighlight %}

Notem que os comportamentos são muito parecidos entre eles. Com poucas linhas de código já temos um resultado, claro que vale lembrar que com essas poucas linhas temos uma gama de funcionalidades que eles disponibilizam para nós. Vamos utilizar o Silex para os exemplos a seguir.

A maioria dos microframeworks disponibilizam componentes que encapsulam as soluções e provem uma série de métodos para utilizarmos, por exemplo:

Para utilizarmos ORM em nossa aplicação:
{% highlight json %}
//no composer.json
"dflydev/doctrine-orm-service-provider": "v1.0.3"
{% endhighlight %}

Para utilizarmos ORM em nossa aplicação:
{% highlight php %}
<?php
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
{% endhighlight %}    

É muito elegante a forma que podemos trabalhar com acesso ao banco e suporte a ORM com poucas linhas escritas. O silex vem com diversos *build-in* Providers para você poder utilizar, [confira aqui quais são](http://silex.sensiolabs.org/documentation).

Criando uma API Restful
---

Para não extendermos muito esse artigo, vou mostrar como podemos criar uma API Restful para o Silex.

Vamos criar nossa estrutura de pastas:

* config/
* src/
* var/
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

{% highlight json %}
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
        "silex/silex": "~1.2",
        "symfony/class-loader": "~2.4",
        "symfony/serializer": "~2.4",
        "symfony/browser-kit": "~2.4",
        "easyframework/collections": "2.0.0"
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
{% endhighlight %}

Nós estamos declarando as dependências do silex. Vamos rodar o comando **composer install** para instalarmos nossas dependências. Agora temos tudo pronto para desenvolvermos nossa API.

No arquivo index.php, insira:

{% highlight php %}
<?php

ini_set('display_errors', -1);

$loader = require_once __DIR__ . '/../vendor/autoload.php';

$app = require __DIR__ . '/../src/app.php';
require __DIR__ . '/../config/prod.php';
require __DIR__ . '/../src/controllers.php';
$app->run();

{% endhighlight %}

No arquivo index_dev.php, insira:

{% highlight php %}
<?php

use Symfony\Component\ClassLoader\DebugClassLoader;
use Symfony\Component\HttpKernel\Debug\ErrorHandler;
use Symfony\Component\HttpKernel\Debug\ExceptionHandler;

$loader = require_once __DIR__ . '/../vendor/autoload.php';

error_reporting(-1);
DebugClassLoader::enable();
ErrorHandler::register();
if ('cli' !== php_sapi_name()) {
    ExceptionHandler::register();
}

$app = require __DIR__ . '/../src/app.php';
require __DIR__ . '/../config/dev.php';
require __DIR__ . '/../src/controllers.php';
$app->run();
{% endhighlight %}

O próximo passo é definirmos nossas configurações iniciais. Na pasta *config/* editem o arquivo dev.php, nesse arquivo podemos definir as configurações que são de desenvolvimento.


{% highlight php %}
<?php

// include the prod configuration
require __DIR__ . '/prod.php';

$app['debug'] = true;

{% endhighlight %}

Agora no nosso arquivo prod.php:

{% highlight php %}
<?php

//Session
$app['session.storage.save_path'] = __DIR__ . '/../var/session';
$app['session.storage.options'] = array('name' => 'phppb');

{% endhighlight %}

Pronto com isso temos as configurações iniciais da nossa API. Agora precisamos registrar os providers que iremos utilizar. Para isso editamos o arquivo *src/app.php*:

{% highlight php %}
<?php

use Silex\Application;
use Silex\Provider\UrlGeneratorServiceProvider;

//Cria um aplicação Silex
$app = new Application();

//Registra o provedor de geração de URls
$app->register(new UrlGeneratorServiceProvider());

//Registra o provedor de gerenciador de sessão
$app->register(new Silex\Provider\SessionServiceProvider());

//Registra o provedor de serialização de dados
$app->register(new \Silex\Provider\SerializerServiceProvider());

return $app;

{% endhighlight %}

Notem que vamos utilizar apenas 3 providers do silex:

* **UrlGeneratorServiceProvider** - geração de URls
* **SessionServiceProvider** - gerenciador de sessão
* **SerializerServiceProvider** - serialização de dados

Finalmente vamos editar o arquivo principal que é o *src/controllers.php*. Nele iremos criar as funcionalidades de nossa API Rest.

A primeira coisa a fazermos é entendermos o fluxo do Silex:

{% highlight php %}
<?php
/**
 * É executado antes de qualquer rota definida no silex. Nessa funcionalidade especificamos que 
 * quando o content-type for igual a application/json os dados serão convertidos pelo json_decode
 **/
$app->before(function (Request $request) use ($app) {
    if (0 === strpos($request->headers->get('Content-Type'), 'application/json')) {
        $data = json_decode($request->getContent(), true);
        $request->request->replace(is_array($data) ? $data : array());
    }
});

/**
 * É executado depois de qualquer rota definida no silex. Especificamos que o content-type
 * de retorno será o do tipo requisitado pelo Request.
 **/
$app->after(function (Request $request, Response $response) {
    $format = $request->attributes->get('format');
    $response->headers->set('Content-Type', $request->getMimeType($format));
});

//É executado quando ocorrer um erro na aplicação
$app->error(function (Exception $e, $code) use ($app) {
    return new Response($app->json(array('message' => $e->getMessage(), 'code' => $code)), $code);
});
{% endhighlight %}

Ótimo, agora temos nosso fluxo definido. Vamos entender como o REST funciona:


Definição da API
---

**Descrição**: Criar uma API para acessar dados de usuários.


| Method        | Uri           | Descrição                  | Retorno   |
| ------------- |:-------------:| ---------------------------| :--------:|
| GET           | /users        | Recupera todos os usuários | json-xml  |
| POST          | /user         | Cria um usuário            | json-xml  |
| GET           | /user/{id}    | Visualiza um usuário       | json-xml  |
| PUT           | /user/{id}    | Edita um usuário           | json-xml  |
| DELETE        | /user/{id}    | Exclui um usuário          | json-xml  |


Entendido oo que precisamos implementar, vamos começar pelo datasource, que será onde guardaremos os dados. Optei por utilizar a sessão para não deixar o exemplo complexo. Dessa forma no começo do arquivo colocamos:


{% highlight php %}
<?php

if (!$app['session']->has('datasource')) {
    $app['session']->set('datasource', new \Easy\Collections\ArrayList(array(
        new \PhpPb\Entity\User(1, 'Anderson'),
        new \PhpPb\Entity\User(2, 'Maria'),
        new \PhpPb\Entity\User(3, 'Anabella'),
        new \PhpPb\Entity\User(4, 'Lindsey'),
        new \PhpPb\Entity\User(5, 'Rose')
            ))
    );
}

$datasource = $app['session']->get('datasource');
{% endhighlight %}

Esses serão os dados iniciais utilizados, isso sumulará um Banco de dados. Com isso feito vamos criar a funcionalidade de listar os usuários, que irá responder a url */users*

{% highlight php %}
<?php

$app->get('/users', function(Silex\Application $app, Request $request) use($datasource) {
    //Setamos o tipo do formato que vem do request
    $format = $request->getContentType();
    $request->attributes->set('format', $format);
    
    //Retornamos um Response serializando a collection
    return new Response($app['serializer']->serialize($datasource->toArray(), $format));
});

{% endhighlight %}

Para consumirmos esse serviço, no seu terminal faça um curl:

{% highlight sh %}
curl --include --request GET 'https://localhost/silex-restful-exemple/web/index_dev.php/users' --header "Content-Type: application/json"
{% endhighlight %}
Resultado:

{% highlight json %}
[{"id":1,"name":"Anderson"},{"id":2,"name":"Maria"},{"id":3,"name":"Anabella"},{"id":4,"name":"Lindsey"},{"id":5,"name":"Rose"}
{% endhighlight %}

Para criarmos um novo usuário:

{% highlight php %}
<?php
$app->post('/user', function(Silex\Application $app, Request $request) use($datasource) {
    //Decodificamos os dados que vem do request
    $json = json_decode($request->getContent());

    //Criamos um novo usuário e adicionamos no datasource
    $user = new \PhpPb\Entity\User((int) $json->id, $json->name);
    $datasource->add($user);

    //Atualizamos a sessão com o datasource
    $app['session']->set('datasource', $datasource);
    
    //Setamos o tipo do formato que vem do request
    $format = $request->getContentType();
    $request->attributes->set('format', $format);

    //Serializamos o usuário criado e retornamos
    return new Response($app['serializer']->serialize($user, $format));
})
;
{% endhighlight %}

Para recuperar um usuário:

{% highlight php %}
<?php
$app->get('/user/{user}', function(Silex\Application $app, Request $request, \PhpPb\Entity\User $user) use($datasource) {
            //Setamos o tipo do formato que vem do request
            $format = $request->getContentType();
            $request->attributes->set('format', $format);
            
            //Serializamos o usuário encontrado no datasource
            return new Response($app['serializer']->serialize($user, $format));
        })
        ->convert('user', 'converter.user:convert')
;
{% endhighlight %}

Notem que existe um método a mais chamado convert, ele é responsável por pegar o id do usuário e encontra-lo no datasource. Dessa forma podemos receber como parâmetro da nossa função anônima *\PhpPb\Entity\User $user*.

Para atualizar um usuário:

{% highlight php %}
<?php
$app->put('/user/{user}', function(Silex\Application $app, Request $request, \PhpPb\Entity\User $user) use($datasource) {
            //Decodificamos os dados que vem do request
            $json = json_decode($request->getContent());
            
            //Setamos os dados atualizados
            $user->setName($json->name);

            //Atualizamos a sessão com o datasource
            $app['session']->set('datasource', $datasource);
            
            //Setamos o tipo do formato que vem do request
            $format = $request->getContentType();
            $request->attributes->set('format', $format);

            //Serializamos o usuário criado e retornamos
            return new Response($app['serializer']->serialize($user, $format));
        })
        ->convert('user', 'converter.user:convert')
;
{% endhighlight %}

Para excluir um usuário:

{% highlight php %}
<?php
$app->delete('/user/{user}', function(Silex\Application $app, Request $request, \PhpPb\Entity\User $user) use($datasource) {
            //Remove o usuário do datasource
            $datasource->removeValue($user);
            
            //Atualizamos a sessão com o datasource
            $app['session']->set('datasource', $datasource);
            
            //Setamos o tipo do formato que vem do request
            $format = $request->getContentType();
            $request->attributes->set('format', $format);

            //Retornamos o código 204 que significa No content, do padrão do Rest
            return new Response('', 204);
        })
        ->convert('user', 'converter.user:convert')
;
{% endhighlight %}

Com isso temos uma API Restfull completamente funcional e simples. A medida que a aplicação vai crescendo vamos sentir a necessidade de separar mais as coisas. Em um artigo futuro irei mostrar como melhorarmos esse exemplo simples.

Para acessar o código completo com os testes e os converters completos, acessem: https://github.com/italolelis/silex-restful-example
Qualquer melhoria é aceita e será legal colaboramos para melhoramos esse código.

Agradeço a todos por terem acompanhado esse artigo. Até a próxima.
