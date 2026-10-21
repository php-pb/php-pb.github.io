---
layout: post
title: Mongo, Mongolão
date: 2014-05-26 16:00:00
author: Ítalo Queiroz
categories: 
- mongodb
- nosql
tags: 
- mongo
- nosql
- meanio
- bson
---

### O que é esse MongoDB?

É um banco de dados orientado a documentos, classificado como NoSQL e foi escrito em C++.

Ok!? Mas o que é um banco de dados orientado a documentos? É uma estrutura que tenta fugir do modelo relacional (MySQL, Postgress, Oracle) que durante muito tempo foi utilizado como bala de prata. Creio que o grande aumento das startups e suas constantes mudanças em seus produtos (App's) fez com que essa estrutura relacional fosse deixada de lado e a opção por um modelo mais adaptável e flexivél colocada em pauta. :D

O MongoDB possui **Collections** que no modelo relacional seriam as **Tabelas**, possui **Documents** que no modelo relacional seriam as **Row**. Mas a grande diferença entre estes modelos é que a Collection não influencia em nada na estrutura de seus Documents.

Ex:
Se você tivesse uma gaveta com o nome "Gaveta de contratos" nela teriamos apenas contratos guardados, pois você definiu um padrão para aquela gaveta e se assemelha com o modelo relacional. Agora pensando no modelo orientado a documentos nós teriamos uma "Gaveta" e dentro dela poderiamos guardar contratos, donuts, remédios e revólver :D. Fica critério do desenvolvedor sua forma de organização. E que pode ser muito bem alterada depois sem grande complicações, algo que no modelo relacional gera uma leve dor de cabeça.

Os **Documents** são representados por um conjunto de dados em formato JSON, mas estes documentos quando inseridos são convertidos para um formato mais rico chamado BSON (serialização, junção de Binário com JSON) que dá muito mais performace aos seus dados e as operações que os afetam (Find, Update, Delete, etc.).
   
O nome Mongo vem de "humongous" que significa gigantesco (ou grande, enorme, monstruoso). MongoDB é livre e de código aberto.   

### Quem usa?
 
Empresas como: Mailbox, LinkedIn, Parse, SourceForge, eBay, GitHub e [mais](http://www.mongodb.org/about/production-deployments/)
<center>
<iframe src="https://giphy.com/embed/Xh1vgIUkJbPKo" width="500" height="271" frameBorder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
</center>
 
### Instalação
  
Este post não tem o foco na instalação do MongoDB, [este link](http://docs.mongodb.org/manual/installation/) vai ajudar nesta tarefa. Lembrando que o time do MongoDB sugere que seja usada a versão 64-bit.

<center>
<iframe src="https://giphy.com/embed/DVTv8Jk7cCn60" width="500" height="281" frameBorder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
</center>
 
### Como criar uma Database?
     
Então, o MongoDB tem uma característica muito interessante, para usar uma Database não é necessário criá-la anteriormente, o método "use" já faz isso, claro, caso a Database não exista.

{% highlight sh %}
show dbs
{% endhighlight %}
     
{% highlight sh %}
use mongol
{% endhighlight %}
 
### Como criar uma Collection?
     
Assim como as Databases nossas collections (tabelas) não precisam ser criadas com um comando específico, na hora do insert o MongoDB já verifica a existência da collection e cria se não encontrar (coisa linda de GOD).

### Insert
    
Podemos inserir nossos dados assim:

{% highlight sh %}
db.usuarios.insert({"nome": "Lloyd Christmas", "filme": "Dumb & Dumber", "ator": "Jim Carrey", "idade": 52});
{% endhighlight %}

Como podemos também criar variáveis e referenciá-las no insert
{% highlight sh %}
usuario = {"nome": "Harry Débi Dunne", "filme": "Dumb & Dumber", "ator": "Jeff Daniels", "idade": 59};
db.usuarios.insert(usuario);
{% endhighlight %}

Note que não criamos nossa collection de "usuarios". Ao rodar este insert o MongoDB irá verificar se a coleção de "usuarios" existe, criará se necessário e adicionará os documentos passados para inserção.

### Find

{% highlight sh %}
#busca todos os registros de users
db.users.find(); 

#busca todos os registros de users 
#e retorna o json formatado
db.users.find().pretty(); 

#busca todos os registros onde
#ator seja igual a Jim Carrey
db.users.find({ator: "Jim Carrey"});

#busca todos os registros que
#tenham  no nome, parecido com o like no SQL
db.users.find({nome: /Débi*/i});

#busca todos os registros que
#tenham Débi no nome, parecido com o like no SQL
db.users.find({nome: /Débi*/i});
#definindo um objeto regex
db.users.find({nome: {$regex: 'Débi*', $options: 'i'}});

#busca todos os registros de users
#filtrando as colunas que serão retornadas
db.users.find(null, {nome: 1});

{% endhighlight %}

Olhando o código acima você pode perceber que temos um elemento chamado "$regex", que são operadores de avaliação. Assim como o "$regex" existem outros operadores entre eles: $where e $text. Para conhecer mais sobre estes operadores de avaliação [clique aqui](http://docs.mongodb.org/manual/reference/operator/query-evaluation/).

Existem também operadores de comparação que nos permite realizar buscas com definições mais detalhadas. Ex: ">", ">=", "<" e "<=".

{% highlight sh %}
db.usuarios.find({idade: {$gte: 50}});
db.usuarios.find({idade: {$gte: 54}});
{% endhighlight %}

No site do MongoDB tem uma lista com todos os operadores de query, [clique aqui](http://docs.mongodb.org/manual/reference/operator/query/) e veja como melhorar suas consultas usando esta excelente ferramenta (momento jabá hehehehe)

### Update

{% highlight sh %}
#atualiza todos os usuários com 
#idade >= 54 anos para 50 anos
db.usuarios.update({idade: {$gte: 54}}, {$set: {idade: 50}});

#atualiza todos os usuários com 
#idade >= 50 anos para 20 anos
db.usuarios.update({idade: {$gte: 50}}, {$set: {idade: 20}}, {multi: true});
{% endhighlight %}

No primeiro exemplo acima de update ele altera a idade para 50 no primeiro documento que ele encontrar onde idade seja maior igual a 54. Já no segundo ele altera todos os documentos onde a idade seja maior igual a 50. 

### Deletar

{% highlight sh %}
#remove os documentos onde ator seja igual a Jim Carrey
db.usuarios.remove({ator: "Jim Carrey"});
#remove todos os documentos da coleção
db.usuarios.remove();
{% endhighlight %}

Acho que ficou claro o papel do remove nas linhas acima neh? O papel dele é te dar um frio na barriga quando for executá-lo. :D


### Mean IO
 
Para galera que está afim de desenvolver uma aplicação média de forma rápida e robusta existe o [Mean IO](http://mean.io/) que é uma solução full-stack para ajudar nesse desenvolvimento. Ela é formada por MongoDB, Express, AngularJS e Node.js. No mínimo, ao final desta implementação, terá conhecido ferramentas maravilhosas e ampliado seus conhecimentos.
<center>
<iframe src="https://giphy.com/embed/P40Gkig2OTlLy" width="500" height="375" frameBorder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
</center>

### App's para gerenciar sua base MongoDB
 
- [http://www.mongovue.com/](http://www.mongovue.com/)
- [https://www.mongohq.com/](https://www.mongohq.com/)     
- [http://www.robomongo.org/](http://www.robomongo.org/)     
- [http://mongohub.todayclose.com/](http://mongohub.todayclose.com/)
 
### Considerações
 
 Atualmente tenho usado em minha startup serviços NoSQL conhecidos como BaaS, eles ajudam bastante na hora de fornecer SDK's e abstrair trabalhos rotineiros como ACL, Confirmação de email, Cadastro de usuário [clique aqui](http://italoqueiroz.github.io/blog/2013/07/15/baas-backend-as-a-service/) para saber mais. 
 
 Sei que existem várias ferramentas para definirmos nossa arquitetura e não acho que o MongoDB deva ser implementado em todos os seus projetos, mas com certeza você deverá levá-lo em consideração. 
 
 Pretendo montar um exemplo em PHP, quando estiver diponível deixo o link aqui abaixo.
 
<center> 
<iframe src="https://giphy.com/embed/AeWoyE3ZT90YM" width="500" height="210" frameBorder="0" webkitAllowFullScreen mozallowfullscreen allowFullScreen></iframe>
</center> 
