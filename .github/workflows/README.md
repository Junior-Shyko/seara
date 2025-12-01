# GitHub Actions Workflows

Este diretório contém os workflows do GitHub Actions para o projeto Seara.

## Workflows Disponíveis

### 1. CI (Integração Contínua) - `ci.yml`

**Quando executa:**
- Push para branches `master` ou `develop`
- Pull requests para `master` ou `develop`

**O que faz:**
- **Tests**: Executa testes PHPUnit com PHP 7.2, 7.3 e 7.4
  - Configura MySQL
  - Instala dependências
  - Roda migrações
  - Executa testes

- **Assets**: Faz build dos assets frontend
  - Instala dependências npm e bower
  - Executa `npm run prod`
  - Faz upload dos assets como artifact

- **Code Quality**: Verifica qualidade do código
  - Valida sintaxe PHP em todos os arquivos

### 2. Deploy - `deploy.yml`

**Quando executa:**
- Push para branch `master`

**O que faz:**
- Instala dependências de produção
- Faz build dos assets
- Deploy usando Deployer (deploy.php)

**Configuração necessária:**

Adicione os seguintes secrets no GitHub (Settings → Secrets and variables → Actions):

```
DEPLOY_HOST - Servidor de destino
DEPLOY_USER - Usuário SSH
DEPLOY_KEY - Chave SSH privada (se usar rsync)
DEPLOY_PATH - Caminho no servidor (se usar rsync)
```

**Para habilitar:**
1. Configure os secrets acima
2. Ajuste o arquivo `deploy.php` se necessário
3. Descomente a linha `environment: production` se usar GitHub Environments

### 3. E2E Tests - `e2e.yml`

**Quando executa:**
- Manualmente via GitHub Actions UI
- (Opcional) Em pull requests - descomentar no arquivo
- (Opcional) Agendado diariamente - descomentar no arquivo

**O que faz:**
- Configura ambiente completo (PHP + MySQL + Node.js)
- Roda migrações e seeds
- Inicia servidor Laravel
- Executa testes Cypress
- Faz upload de screenshots (em caso de falha) e vídeos

**Para executar manualmente:**
1. Vá para Actions → E2E Tests
2. Clique em "Run workflow"

## Estrutura dos Workflows

```
.github/
└── workflows/
    ├── ci.yml          # CI principal (testes + build)
    ├── deploy.yml      # Deploy automático
    ├── e2e.yml         # Testes E2E com Cypress
    └── README.md       # Esta documentação
```

## Como Testar Localmente

### Testes PHPUnit
```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
vendor/bin/phpunit
```

### Build de Assets
```bash
npm install
npx bower install
npm run prod
```

### Testes Cypress
```bash
npm install
php artisan serve &
npm run cy:run
```

## Personalizações Comuns

### Adicionar mais versões do PHP
Edite `ci.yml` na matriz:
```yaml
matrix:
  php-version: ['7.2', '7.3', '7.4', '8.0']
```

### Mudar branches de CI
Edite os triggers em `ci.yml`:
```yaml
on:
  push:
    branches: [ master, develop, staging ]
```

### Adicionar notificações
Você pode adicionar steps de notificação (Slack, Discord, Email) nos workflows.

Exemplo para Slack:
```yaml
- name: Slack Notification
  uses: 8398a7/action-slack@v3
  with:
    status: ${{ job.status }}
    webhook_url: ${{ secrets.SLACK_WEBHOOK }}
  if: always()
```

## Status Badge

Adicione ao README.md do projeto:

```markdown
![CI](https://github.com/SEU_USUARIO/seara/workflows/CI/badge.svg)
```

## Troubleshooting

### Falhas no MySQL
Se os testes falharem por problemas de conexão MySQL, verifique:
- A porta 3306 está disponível
- As credenciais estão corretas
- O health check está funcionando

### Falhas no Build de Assets
- Verifique se `bower.json` e `package.json` estão corretos
- Confirme que `gulpfile.js` está configurado corretamente

### Timeouts no Cypress
Ajuste o timeout em `.github/workflows/e2e.yml`:
```yaml
run: npx wait-on http://localhost:8000 --timeout 120000
```

## Próximos Passos

1. Teste os workflows fazendo um push
2. Configure os secrets para deploy
3. Personalize conforme necessário
4. Adicione mais jobs se necessário (code coverage, security scan, etc.)
