---
layout: post
title: Como criar uma extensão PHP
date: 2017-03-26 22:00:00
author: Joel Tavares
categories:
  - internals
  - tutorial
tags:
  - php
  - internals
---

Você deve tá se perguntando: “Porquê raios eu iria querer aprender a fazer isto?” Se você gosta de fuçar sobre programação já é um bom motivo para continuar lendo. Agora, se você é um daqueles leitores que precisam de mais para prosseguir, segue abaixo alguns motivos retirados do [Zend Developer Zone](https://devzone.zend.com/303/extension-writing-part-i-introduction-to-php-and-zend/):

> You have a particularly clever bit of code you want to sell, and it’s important that the party you sell it to be able to execute it, but not view the source.

> You’ve already got some PHP code written, but you know it could be faster, smaller, and consume less memory while running.

> There is some library or OS specific call which cannot be made from PHP directly because of the degree of abstraction inherent in the language.


## Qual será o nosso projeto?

Para fugir um pouco da mesmice, ao invés de criamos o famoso “Olá Mundo”, iremos iniciar o desenvolvimento de uma extensão de automação de desktop. Esse projeto foi inspirado na biblioteca RobotJS.

## Do que vamos precisar?

Primeiro, é preciso que o leitor tenha noções basicas da linguagem C e familiaridade com a linha de comandos para tirar melhor proveito desse passo a passo. Segundo, vamos precisar instalar algumas dependências para nos auxiliar durante processo.

Para instalar as dependências no Debian ou Ubuntu:
{% highlight sh %}
$ sudo apt-get install build-essential automake libtool libx11-dev libxtst-dev bison autoconf php7.0-dev
{% endhighlight %}

No Arch Linux:
{% highlight sh %}
$ sudo pacman -S base-devel libx11 libxtst
{% endhighlight %}

## Colocando a mão na massa

Baixe o código fonte do PHP:
{% highlight sh %}
$ git clone https://github.com/php/php-src.git
{% endhighlight %}

Esse comando irá gerar o diretório php-src; Em seguida, acesse o diretório de extensões dentro dele (segue abaixo o exemplo):

{% highlight sh %}
$ cd php-src/ext
{% endhighlight %}

Agora vamos criar e acessar o diretório da nossa extensão:
{% highlight sh %}
$ mkdir phpbot
$ cd phpbot
{% endhighlight %}

Feito isso, crie o config.m4 (é um arquivo de configuração) com o seu editor favorito e insira as seguintes linhas:
{% highlight sh %}
PHP_ARG_ENABLE(phpbot, whether to disable phpbot support,
[  --disable-phpbot           Disable phpbot support], yes)

if test "$PHP_PHPBOT" != "no"; then
  x11_flags="-lX11 -lXtst"
  LDFLAGS="$x11_flags $LDFLAGS"
  PHP_NEW_EXTENSION(phpbot, phpbot.c, $ext_shared,, -DZEND_ENABLE_STATIC_TSRMLS_CACHE=1)
  AC_DEFINE(PHP_PHPBOT, 1, [ ])
fi
{% endhighlight %}

Depois crie o php_phpbot.h e insira:
{% highlight c %}
#ifndef PHP_PHPBOT_H
#define PHP_PHPBOT_H

#include <X11/Xlib.h> //

extern zend_module_entry phpbot_module_entry;
#define phpext_phpbot_ptr &phpbot_module_entry

#define PHP_PHPBOT_VERSION "0.1.0"

#ifdef PHP_WIN32
#	define PHP_PHPBOT_API __declspec(dllexport)
#elif defined(__GNUC__) && __GNUC__ >= 4
#	define PHP_PHPBOT_API __attribute__ ((visibility("default")))
#else
#	define PHP_PHPBOT_API
#endif

#ifdef ZTS
#include "TSRM.h"
#endif

// As variáveis globais devem ser declaradas dentro das macros BEGIN e END
ZEND_BEGIN_MODULE_GLOBALS(phpbot)
	Display *display; // estrutura com informações do servidor X. Ela é necessária para criar o nosso projeto.
ZEND_END_MODULE_GLOBALS(phpbot)

#define PHPBOT_G(v) ZEND_MODULE_GLOBALS_ACCESSOR(phpbot, v)

#if defined(ZTS) && defined(COMPILE_DL_PHPBOT)
ZEND_TSRMLS_CACHE_EXTERN()
#endif

#endif
{% endhighlight %}

Após, crie o phpbot.c com o seguinte conteúdo:
{% highlight c %}
#ifdef HAVE_CONFIG_H
#include "config.h"
#endif

#include "php.h"
#include "php_ini.h"
#include "ext/standard/info.h"
#include "php_phpbot.h"

// Biblioteca necessária para automatizar o teclado, mouse, ...
#include <X11/Xlib.h>
#include <X11/extensions/XTest.h>

ZEND_DECLARE_MODULE_GLOBALS(phpbot)

// Função responsável por simular o aperto de uma tecla
static void keyPress(char key)
{
	KeyCode keyCode = XKeysymToKeycode(PHPBOT_G(display), key);
	XTestFakeKeyEvent(PHPBOT_G(display), keyCode, True, CurrentTime);
	XTestFakeKeyEvent(PHPBOT_G(display), keyCode, False, CurrentTime);
	XFlush(PHPBOT_G(display));
}

// Função responsável por simular digitação
PHP_FUNCTION(typeString)
{
	char *arg = NULL;
	size_t arg_len, i;

	if (zend_parse_parameters(ZEND_NUM_ARGS(), "s", &arg, &arg_len) == FAILURE) {
		return;
	}

	for (i = 0; i < arg_len; i++) {
		keyPress(arg[i]);
	}
}

PHP_MINIT_FUNCTION(phpbot)
{
	PHPBOT_G(display) = XOpenDisplay(NULL);
	if (!PHPBOT_G(display)) {
		return FAILURE;
	}
	return SUCCESS;
}

//
PHP_MSHUTDOWN_FUNCTION(phpbot)
{
	XCloseDisplay(PHPBOT_G(display));
	return SUCCESS;
}

PHP_MINFO_FUNCTION(phpbot)
{
	php_info_print_table_start();
	php_info_print_table_header(2, "phpbot support", "enabled");
	php_info_print_table_end();
}

const zend_function_entry phpbot_functions[] = {
	PHP_FE(typeString,	NULL) // essa linha torna a função typeString disponível externamente
	PHP_FE_END
};

zend_module_entry phpbot_module_entry = {
	STANDARD_MODULE_HEADER,
	"phpbot",
	phpbot_functions,
	PHP_MINIT(phpbot),
	PHP_MSHUTDOWN(phpbot),
	NULL,
	NULL,
	PHP_MINFO(phpbot),
	PHP_PHPBOT_VERSION,
	STANDARD_MODULE_PROPERTIES
};

#ifdef COMPILE_DL_PHPBOT
#ifdef ZTS
ZEND_TSRMLS_CACHE_DEFINE()
#endif
ZEND_GET_MODULE(phpbot)
#endif
{% endhighlight %}

Agora, vamos preparar o ambiente para compilar a extensão:
{% highlight sh %}
$ phpize
{% endhighlight %}

Em seguida vamor garantir que temos todas as dependências para concluir o processo de compilação:
{% highlight sh %}
$ ./configure
{% endhighlight %}

Vamos compilar:
{% highlight sh %}
$ make
{% endhighlight %}

Se tudo deu certo, o arquivo phpbot.so foi gerado no diretório modules.

Copie o phpbot.so para o diretório de extensões do PHP, caso você não saiba o caminho do mesmo, verifique:

{% highlight sh %}
$ php-config | grep extension-dir
--extension-dir     [/usr/lib/php/modules]
{% endhighlight %}

No meu caso é o /usr/lib/php/modules, então:
{% highlight sh %}
$ sudo cp modules/phpbot.so /usr/lib/php/modules
{% endhighlight %}

Para ativar a extensão vamos criar o 10-phpbot.ini.
Se você não souber onde criar, digite:
{% highlight sh %}
$ php --ini
Configuration File (php.ini) Path: /etc/php
Loaded Configuration File:         /etc/php/php.ini
Scan for additional .ini files in: /etc/php/conf.d
{% endhighlight %}

Em seguida:
{% highlight sh %}
$ sudo bash -c 'echo "extension=phpbot.so" > /etc/php/conf.d/10-phpbot.ini'
{% endhighlight %}

Vamos testar:

{% highlight sh %}
$ php -r "typeString('holy moly');"
{% endhighlight %}

Com isso, conseguimos criar uma extensão PHP. Para acessar o código: [https://github.com/jooeltavares/phpbot](https://github.com/jooeltavares/phpbot).

Para aprender mais sobre, acesse os links: [https://devzone.zend.com/303/extension-writing-part-i-introduction-to-php-and-zend/](https://devzone.zend.com/303/extension-writing-part-i-introduction-to-php-and-zend/), [http://www.phpinternalsbook.com/build_system/building_php.html](http://www.phpinternalsbook.com/build_system/building_php.html), [http://php.net/manual/en/internals2.ze1.php](http://php.net/manual/en/internals2.ze1.php).

Espero que tenham gostado. Até a próxima!
