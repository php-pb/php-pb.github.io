---
layout: post
title: Contribuindo com artigos para o site
date: 2014-04-29 00:29:00
author: Sérgio Vilar
categories: 
- git
- tutorial
tags: 
- github
- contribuindo 
- conferência 
---

Olá pessoal, neste post irei explicar como vocês podem contribuir com o PHP-PB escrevendo artigos e submetendo via *Github*.

Se você ainda não tem uma conta no Github, pode se cadastrar [aqui](https://github.com/).

## Fazendo fork do repositório

Para submeter algum artigo, antes, é necessário que você faça um *fork* no [projeto original](https://github.com/php-pb/php-pb.github.io/) no github.

Abra o link do repositório e clique em fork:

![Fork](http://cl.ly/image/003G2N2N363H/fork.png)

Isso criará uma cópia do repositório original no seu perfil do Github.


## Instalação do Git

Antes de tudo, precisamos instalar o git para clonar o nosso repositório. 

Se você usa Mac OSX ou Windows, pode usar as versões para desktop do Github para os mesmos ([aqui](https://mac.github.com/) e [aqui](https://windows.github.com/)). Caso prefira usar a linha de comando, veja [este tutorial](https://help.github.com/articles/set-up-git) do Github que dá instruções de como instalar o git no seu sistema operacional.

Feito isso, podemos clonar nosso repositório:

    git clone git@github.com:<seu_username>/php-pb.github.io.git
    
Agora você terá uma cópia do projeto no seu computador.

## Escrevendo o artigo

No PHP-PB usamos [Jekyll](http://jekyllrb.com) para postarmos artigos, este que por sua vez exige que os posts sejam escritos usando a [syntaxe markdown](http://daringfireball.net/projects/markdown/syntax).

Para criar um novo post, crie um arquivo na pasta `_posts` seguindo a seguinte nomeclatura:

{% highlight text %}
2014-04-13-sunshine-slides-favoritos.markdown
{% endhighlight %}
<br>
Todo arquivo de posts precisa ter um cabeçalho seguindo o exemplo a seguir:

{% highlight yaml %}
---
layout: post
title: Contribuindo com artigos para o site
date: 2014-04-29 00:29:00
author: Sérgio Vilar
categories: 
- git
- tutorial
tags: 
- github
- contribuindo 
- conferência 
---
{% endhighlight %}
<br>
Com o artigo escrito, você pode visualizar o site rodando o Jekyll, mas para isso precisa antes [instalar o *Ruby*](http://www.devmedia.com.br/instalando-o-ruby-on-rails-no-windows/20472) na sua máquina e depois instalar as seguintes dependências:

{% highlight sh %}
gem install jekyll kramdown
{% endhighlight %}
<br>
*Nota do autor:* se não me engano, tanto o linux como o OSX já vêm com o ruby instalado    

Com o Ruby e as dependências instaladas, você pode rodar o Jekyll:

{% highlight sh %}
jekyll serve
{% endhighlight %}
<br>
Ok, agora que temos nosso artigo pronto, vamos enviá-lo para o nosso repositório no github:

{% highlight sh %}
git add .
git commit -m "Adicionado o artigo <titulo_do_artigo>"
git push -u origin master    
{% endhighlight %}
<br>    
    
## Enviando a solicitação de publicação (Pull Request)

Para publicarmos nosso artigo precisamos submetê-lo ao repositório original do PHP-PB, no que consiste num merge das nossas modificações com o código do repositório original.

![Pull Request](http://cl.ly/image/0D2u1d3z2a1Q/Pull%20request.png)

Agora criamos nosso Pull Request:

![Pull Request 2](http://cl.ly/image/2o2U2M2s3I0r/Pull%20Request%202.png)

Descrevemos nossa solicitação e finalmente a enviamos:

![Pull Request 3](http://cl.ly/image/2t442l3h1Q3k/Pull%20Request%203.png)

E agora temos finalmente nossa Pull Request aberta aguardando que algum colaborador do repositório a aprove:

![Issue](http://cl.ly/image/0g37163r3j1A/issue.png)