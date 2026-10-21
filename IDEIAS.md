# Ideias para desenvolvimento

Backlog de funcionalidades cogitadas pro site novo (`site_novo/`). Nada aqui está confirmado ou priorizado — é só um lugar pra não perder as ideias enquanto discutimos.

## 📅 Calendário de eventos

Meetups, encontros mensais, palestras e workshops da comunidade.

- Resource novo (`Event`), parecido com `Post`: título, data/hora, local, presencial/online, descrição, banner, link externo (Meetup/Sympla)
- CRUD no painel admin
- Possível `EventResource` restrito no painel do membro — organizador cadastra, admin aprova (mesmo padrão de aprovação que já existe pros artigos)
- Baixo risco/esforço — reaproveita bastante do que já foi construído pro blog

## 🎨 Artes pro Instagram

Ideia original: salvar artes e gerar imagens com layout pronto pra divulgação nas redes.

Duas abordagens possíveis, com custo bem diferente:

1. **Galeria simples** — só organizar/guardar arquivos de imagem já prontos (feitos em Canva/Figma fora do sistema). Baixo esforço, é praticamente um media library.
2. **Gerador de verdade** — templates com texto/dados dinâmicos (nome do evento, data, palestrante) renderizados em imagem automaticamente. Precisa de algo como `Intervention Image` (composição simples) ou `spatie/browsershot` (renderiza HTML/Blade e tira screenshot via Chrome headless) pra algo mais visual. Esforço bem maior — vale decidir se compensa fazer isso no Laravel ou só integrar com uma ferramenta externa.

## 💼 Vagas

Quadro de vagas PHP pra comunidade — comum em comunidades de Slack/Discord (tipo PHP Rio, PHP-BR).

## 🤝 Patrocinadores

Vitrine de logos de empresas que apoiam a comunidade (o PHP Belém tem algo assim).

## 🎤 Palestrantes

Histórico de quem já palestrou em eventos da comunidade — dá pra linkar com o calendário de eventos quando ele existir.
