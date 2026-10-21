# Contribuindo com o PHP-PB

Obrigado por considerar contribuir com o site da comunidade PHP-PB! 🎉

## 📋 Sumário

- [Código de Conduta](#código-de-conduta)
- [Como Contribuir](#como-contribuir)
- [Configurando o Ambiente](#configurando-o-ambiente)
- [Padrões de Código](#padrões-de-código)
- [Commits](#commits)
- [Pull Requests](#pull-requests)
- [Reportando Bugs](#reportando-bugs)
- [Sugerindo Funcionalidades](#sugerindo-funcionalidades)

## 📜 Código de Conduta

Este projeto adota um código de conduta que esperamos que todos os participantes sigam. Por favor, seja respeitoso e inclusivo em todas as interações.

- Seja respeitoso com diferentes pontos de vista e experiências
- Aceite críticas construtivas com graça
- Foque no que é melhor para a comunidade
- Mostre empatia com outros membros da comunidade

## 🚀 Como Contribuir

### 1. Fork o repositório

Clique no botão "Fork" no canto superior direito da página do repositório.

### 2. Clone seu fork

```bash
git clone https://github.com/SEU_USUARIO/php-pb.github.io.git
cd php-pb.github.io
```

### 3. Crie uma branch

```bash
git checkout -b feature/minha-contribuicao
```

### 4. Faça suas alterações

Implemente sua feature ou correção.

### 5. Commit e Push

```bash
git add .
git commit -m "feat: adiciona nova funcionalidade X"
git push origin feature/minha-contribuicao
```

### 6. Abra um Pull Request

Vá até o repositório original e clique em "New Pull Request".

## ⚙️ Configurando o Ambiente

### Requisitos

- PHP 8.2+
- Composer
- Node.js 18+
- Docker (opcional, mas recomendado)

### Com Docker

```bash
# Subir os containers
docker-compose up -d

# Instalar dependências
docker-compose exec app composer install
docker-compose exec app npm install

# Configurar ambiente
docker-compose exec app php artisan key:generate
docker-compose exec app php artisan migrate

# Build dos assets
docker-compose exec app npm run dev
```

### Sem Docker

```bash
cd site_novo

# Instalar dependências
composer install
npm install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Banco de dados
php artisan migrate

# Iniciar servidores
php artisan serve
npm run dev
```

## 📝 Padrões de Código

### PHP

- Seguimos as PSR-12
- Use type hints sempre que possível
- Docblocks para métodos públicos

```php
/**
 * Retorna os posts publicados.
 *
 * @param int $limit
 * @return Collection<Post>
 */
public function getPublishedPosts(int $limit = 10): Collection
{
    return Post::published()->limit($limit)->get();
}
```

### Blade/Livewire

- Componentes Livewire v4 usam arquivos únicos com `⚡`
- Use classes Tailwind, evite CSS customizado
- Mantenha componentes pequenos e focados

### JavaScript

- Prefira Alpine.js para interatividade simples
- Use camelCase para variáveis e funções

## 💬 Commits

Usamos [Conventional Commits](https://www.conventionalcommits.org/):

| Tipo | Descrição |
|------|-----------|
| `feat` | Nova funcionalidade |
| `fix` | Correção de bug |
| `docs` | Documentação |
| `style` | Formatação (não altera código) |
| `refactor` | Refatoração |
| `test` | Testes |
| `chore` | Tarefas de manutenção |

### Exemplos

```bash
feat: adiciona página de eventos
fix: corrige layout do header no mobile
docs: atualiza README com instruções de instalação
style: formata arquivos blade
refactor: extrai lógica de posts para service
```

## 🔀 Pull Requests

### Checklist

- [ ] Código segue os padrões do projeto
- [ ] Testes passando (se aplicável)
- [ ] Documentação atualizada (se necessário)
- [ ] Commits seguem o padrão conventional commits
- [ ] Branch está atualizada com a main

### Template

```markdown
## Descrição

Breve descrição das alterações.

## Tipo de mudança

- [ ] Bug fix
- [ ] Nova feature
- [ ] Breaking change
- [ ] Documentação

## Como testar

1. Passo 1
2. Passo 2
3. ...

## Screenshots (se aplicável)

```

## 🐛 Reportando Bugs

Ao reportar um bug, inclua:

1. **Descrição clara** do problema
2. **Passos para reproduzir**
3. **Comportamento esperado** vs **comportamento atual**
4. **Screenshots** se aplicável
5. **Ambiente** (navegador, OS, versão PHP)

Use o template de issue do GitHub.

## 💡 Sugerindo Funcionalidades

Adoramos novas ideias! Ao sugerir:

1. Verifique se já não existe uma issue similar
2. Descreva o problema que a feature resolve
3. Proponha uma solução
4. Considere alternativas

## 🎨 Contribuindo com Artigos

Quer escrever para o blog da comunidade?

1. Crie uma issue com o tema proposto
2. Aguarde aprovação
3. Escreva o artigo em Markdown
4. Envie um PR para a pasta de posts

### Estrutura do artigo

```markdown
---
title: Título do Artigo
author: Seu Nome
date: 2026-02-05
tags: [php, laravel, tutorial]
---

Conteúdo do artigo...
```

## ❓ Dúvidas

Tem alguma dúvida? Entre em contato:

- 💬 [Telegram](https://t.me/phppb)
- 🐙 [GitHub Issues](https://github.com/php-pb/php-pb.github.io/issues)

---

Obrigado por contribuir! 🚀
