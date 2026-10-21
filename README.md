# PHP-PB - Comunidade PHP da Paraíba

![PHP-PB Hero](assets/site.png)

<p align="center">
  <a href="https://php-pb.net"><img src="https://img.shields.io/badge/site-php--pb.net-blue?style=flat-square" alt="Site"></a>
  <a href="https://chat.whatsapp.com/JaWCta8t2DF9Af0zgIb8LB?mode=gi_t"><img src="https://img.shields.io/badge/whatsapp-entrar-25D366?style=flat-square&logo=whatsapp&logoColor=white" alt="WhatsApp"></a>
  <a href="https://github.com/php-pb/php-pb.github.io/blob/master/LICENSE"><img src="https://img.shields.io/badge/license-MIT-green?style=flat-square" alt="License"></a>
  <img src="https://img.shields.io/badge/Laravel-12-FF2D20?style=flat-square&logo=laravel" alt="Laravel">
  <img src="https://img.shields.io/badge/Livewire-4-FB70A9?style=flat-square" alt="Livewire">
  <img src="https://img.shields.io/badge/Filament-5-FDAE4B?style=flat-square" alt="Filament">
  <img src="https://img.shields.io/badge/Tailwind-4-06B6D4?style=flat-square&logo=tailwindcss" alt="Tailwind">
</p>

<p align="center">
  <strong>Conectando desenvolvedores PHP na Paraíba desde 2012</strong>
</p>

---

## Sobre

A **PHP-PB** é uma comunidade de desenvolvedores PHP do estado da Paraíba, Brasil. Nossa missão é promover a interatividade entre pessoas interessadas na linguagem de programação PHP, compartilhando conhecimento através de meetups, hangouts, artigos e eventos.

### O que fazemos

- **Grupo no WhatsApp** - Discussões diárias sobre PHP, Laravel, dúvidas técnicas
- **Meetups & Hangouts** - Encontros presenciais e online com palestras
- **Blog** - Artigos técnicos escritos pela comunidade
- **Vagas** - Oportunidades de emprego compartilhadas
- **PHPeste** - Organizamos junto com outras comunidades a maior conferência PHP do Nordeste

## Stack

| Tecnologia | Versão | Descrição |
|------------|--------|-----------|
| **Laravel** | 12 | Framework PHP |
| **Livewire** | 4 | Componentes reativos full-stack |
| **Tailwind CSS** | 4 | Framework CSS utility-first |
| **Alpine.js** | 3 | Interatividade (incluso no Livewire) |
| **MySQL** | 8 | Banco de dados |
| **FilamentPHP** | 5 | Painel administrativo e área de membro |
| **Phosphor Icons** | - | Ícones do design system |
| **Pest** | - | Testes automatizados |

## Estrutura do Projeto

```
php-pb.github.io/
├── site_novo/           # Projeto Laravel (TALL Stack)
│   ├── app/
│   ├── resources/
│   │   └── views/
│   │       └── components/
│   │           └── landing/    # Componentes Livewire da landing
│   ├── routes/
│   └── ...
├── site_antigo/         # Site Jekyll original (backup/referência)
├── docker-compose.yml   # Configuração Docker
├── README.md
└── CONTRIBUTING.md
```

## Instalação

### Com Docker (Recomendado)

```bash
# Subir os containers
docker-compose up -d

# Instalar dependências PHP
docker-compose exec app composer install

# Instalar dependências Node
docker-compose exec app npm install

# Gerar key da aplicação
docker-compose exec app php artisan key:generate

# Rodar migrations
docker-compose exec app php artisan migrate

# Build dos assets
docker-compose exec app npm run build
```

Acesse: http://localhost:8080

### Sem Docker

```bash
cd site_novo

# Instalar dependências
composer install
npm install

# Configurar ambiente
cp .env.example .env
php artisan key:generate

# Banco de dados (SQLite para desenvolvimento)
touch database/database.sqlite
php artisan migrate

# Iniciar servidor
php artisan serve
npm run dev
```

Acesse: http://localhost:8000

## Comandos Docker

```bash
# Subir containers
docker-compose up -d

# Parar containers
docker-compose down

# Ver logs
docker-compose logs -f app

# Acessar container
docker-compose exec app bash

# Rodar Artisan
docker-compose exec app php artisan <comando>

# Rodar NPM
docker-compose exec app npm run <comando>
```

Acesse: http://localhost:8080

## Desenvolvimento

```bash
# Criar componente Livewire (v4 usa arquivos únicos)
php artisan make:livewire NomeComponente

# Criar Model com Migration
php artisan make:model NomeModel -m

# Rodar testes
php artisan test

# Build para produção
npm run build

# Modo desenvolvimento (com hot reload)
npm run dev
```

## CI/CD

- **CI** (`.github/workflows/ci.yml`): roda em todo push/PR na `master` - Pint (formatação), Larastan (análise estática) e a suíte de testes Pest.
- **Deploy** (`.github/workflows/deploy.yml`): só dispara ao criar uma tag no formato `v*.*.*`. Builda os assets, empacota a aplicação e publica via SSH/SCP na Hostinger.

```bash
# Disparar um deploy em produção
git tag v1.0.0
git push origin v1.0.0
```

## Comunidades Parceiras

Fazemos parte de uma rede de comunidades PHP do Nordeste:

| Comunidade | Estado |
|------------|--------|
| **PHP-PB** | Paraíba |
| **PHP-PI** | Piauí |
| **PHP-MA** | Maranhão |
| **PHP com Rapadura** | Ceará |
| **PHP-PE** | Pernambuco |
| **PHP-RN** | Rio Grande do Norte |

Juntos organizamos o **[PHPeste](https://phpeste.dev)** - a maior conferência PHP do Nordeste brasileiro!

## Links

- [Site Oficial](https://php-pb.net)
- [WhatsApp](https://chat.whatsapp.com/JaWCta8t2DF9Af0zgIb8LB?mode=gi_t)
- [GitHub](https://github.com/php-pb)
- [Twitter/X](https://twitter.com/phppb)
- [Facebook](https://www.facebook.com/groups/php.pb)


---

<p align="center">
  Feito com amor pela comunidade PHP-PB
</p>

