# Segurança — obrigatório em todo código novo e ao tocar em código existente

Aplicar sempre em código novo e ao tocar em código existente. Referência para auditorias futuras.

## 1. Sanitizar e validar todas as entradas (XSS)

- Toda entrada de usuário (formulário, query string, header, upload) passa por `FormRequest`/`$request->validate()` — nunca confiar em dado bruto do request.
- Blade: usar sempre `{{ $var }}` (auto-escape). `{!! $var !!}` só para HTML confiável gerado pelo próprio sistema — nunca para dado de usuário anônimo.
  - **Exceção já documentada neste projeto**: `resources/views/components/blocks/paragraph.blade.php` renderiza `{!! $text !!}` com o HTML vindo do `RichEditor` do bloco "Parágrafo" (`app/Filament/Blocks/Paragraph.php`). Isso é aceitável porque o conteúdo só é escrito por autores autenticados no painel Filament (não é input público), mas qualquer novo bloco de conteúdo que aceite HTML livre precisa da mesma justificativa explícita aqui — ou de sanitização (`strip_tags`/Purifier) se o autor não for confiável.
- Uploads (imagens de post, avatar de autor, uploads do Filament): validar mime/extensão real, nunca servir upload de usuário como executável.

## 2. Implementar CSP (Content-Security-Policy)

- Definir header `Content-Security-Policy` restritivo (`script-src`/`style-src` limitados a `'self'` + domínios explicitamente necessários, sem `'unsafe-inline'`/`'unsafe-eval'` quando evitável).
- Rodar em modo `Content-Security-Policy-Report-Only` antes de aplicar em modo bloqueante, para não quebrar Livewire/Filament sem perceber.

## 3. Proteção contra CSRF

- Manter `VerifyCsrfToken` ativo em todas as rotas `web` que alteram estado (inclui as ações do Livewire e do painel Filament).
- Se algum webhook externo for adicionado no futuro (ex.: newsletter, analytics), a exceção de CSRF só vale se a rota validar assinatura/segredo do provedor no lugar do CSRF.

## 4. Rate limiting (força bruta / DDoS)

- O login do painel Filament (`/admin`) precisa de `throttle`.
- Qualquer endpoint público sem autenticação que aceite escrita (ex.: futuro formulário de contato/newsletter) também precisa de rate limit.

## 5. Manter frameworks e dependências atualizados

- Rodar `composer outdated` e `composer audit` (e `npm audit`) periodicamente, principalmente antes de releases.
- Atualizar Laravel/Filament em janelas dedicadas, não misturado com feature — rodar a suíte de testes antes de subir em produção.

## 6. Auditar bibliotecas de terceiros

- Antes de adicionar uma dependência nova: checar manutenção ativa, nº de downloads/estrelas, issues de segurança abertas.
- Evitar pacotes abandonados; preferir alternativas oficiais/mantidas pela comunidade Laravel/Filament.

## 7. Evitar iFrames desnecessários

- Não usar `<iframe>` para embutir conteúdo do próprio sistema. Se for inevitável (ex.: embed de vídeo de terceiro confiável num post do blog), usar `sandbox` e `X-Frame-Options`/`frame-ancestors` restritivo pro resto do site.

## 8. Configurar Permissions-Policy

- Header `Permissions-Policy` desabilitando por padrão APIs sensíveis não usadas pelo site (câmera, microfone, geolocalização, USB, etc.), liberando só o que for de fato usado.

## 9. SRI (Subresource Integrity) para recursos externos

- Qualquer `<script>`/`<link>` carregado de CDN externo precisa de atributo `integrity` + `crossorigin`.
- Preferir sempre empacotar/servir localmente via Vite em vez de CDN quando possível — elimina a necessidade de SRI e de confiar em disponibilidade/integridade de terceiro.

## Escopo

Aplica-se a `app/**`, `routes/**`, `config/**`, `resources/**` — ou seja, todo o backend Laravel deste projeto (`site_novo/`).
