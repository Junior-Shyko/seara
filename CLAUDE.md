# CLAUDE.md

This file provides guidance to Claude Code (claude.ai/code) when working with code in this repository.

## Project Overview

Seara is a financial management system built with Laravel 5.5 and the Gentelella admin template. It manages company financial entries, accounts, receipts, payments, and receivables with multi-company support.

**Key Technologies:**
- Laravel 5.5 (PHP 7.0+)
- MySQL 5.7
- Node.js 6 with Gulp 3.x and Laravel Elixir 6.x
- Bower for frontend dependencies
- Docker Compose for containerization
- Bootstrap 3 with Gentelella template

**Namespace:** All application code uses the `Seara\` namespace (not `App\`), configured via `composer.json` PSR-4 autoloading.

## Development Environment

### Docker Setup

The application runs in Docker containers:
- **php**: Laravel application (PHP-FPM)
- **nginx**: Web server (exposed on port 8080)
- **mysql**: Database (MySQL 5.7, exposed on port 4242)
- **node**: Asset compilation (Node 6)

### Initial Setup

```bash
# Quick setup (if make is available)
make setup

# Manual setup
cp .env.example .env
docker-compose up -d
docker-compose exec php composer install
docker-compose exec node npm install gulp@3.x laravel-elixir
docker-compose exec node bower install --allow-root
docker-compose exec php php artisan key:generate
docker-compose exec php php artisan migrate
docker-compose exec node gulp
sudo chmod -R 777 storage
```

### Common Commands

**Asset compilation:**
```bash
# Build assets once
docker-compose exec node gulp

# Watch for changes (development)
make watch
# or: docker-compose exec node npm run dev

# Production build
docker-compose exec node npm run prod
```

**Database:**
```bash
# Run migrations
docker-compose exec php php artisan migrate

# Run specific migration command
docker-compose exec php php artisan entries:migrate

# Migrate specific company
docker-compose exec php php artisan entries:migrate --company=47

# Rollback entries migration
docker-compose exec php php artisan entries:migrate --rollback
```

**Testing:**
```bash
# All tests
make tests
# or: docker-compose exec php vendor/bin/phpunit

# Unit tests only
make unit

# Integration tests only
make integration

# Feature tests only
make feature

# E2E tests (Cypress)
make e2e
# or: npm run cy:dry-run
```

**IDE Helpers (development only):**
```bash
docker-compose exec php php artisan ide-helper:generate
docker-compose exec php php artisan ide-helper:meta
```

## Architecture

### Service Layer Pattern

The application uses a service layer architecture with dependency injection configured in `AppServiceProvider.php`. Services are organized by domain:

**Core Services (`app/Service/Core/`):**
- `Transactor`: Handles database transactions (interface: `Transactor`, implementation: `EloquentTransactor`)
- `DataTable`: DataTables integration utilities
- `Csv`: CSV import/export functionality
- `Transformation`: Data transformation utilities
- `Util`: General utilities

**Domain Services (`app/Service/`):**
- `Company`: Company data import/management (integrates with Receita WS API)
- `Financing`: Accounts, income categories, receivables, payments
- `Financial`: Financial accounts and entries
- `Launch`: Entry launches and account launches
- `Receipt`: Receipt generation and management
- `Report`: Financial reports (debt reports, monthly financial reports)
- `AccountBank`: Bank account management
- `TypeAccountBank`: Bank account type management

**Repository Pattern:**
The application uses repositories (both in `app/Repository/` and within service directories) for data access abstraction. Service provider binds interfaces to implementations.

### Models

Models are in the `app/` root directory (e.g., `Entry.php`, `Transaction.php`, `FinancialAccount.php`, `FinancialEntry.php`). Key models:

- **FinancialAccount**: Represents bank/financial accounts
- **Transaction**: Core transaction model with `type` field (income, expense, transfer)
- **FinancialEntry**: Financial entry details
- **TransferDetail**: Details for transfer transactions
- **Entry**: Legacy entry model (being migrated from)
- **AccountLaunch**, **AccountBank**: Account management
- **Receivable**, **Payment**, **IncomeCategory**: Financing module
- **Box**, **SettingsBox**: Cash box settings

### Controllers

Controllers are organized in `app/Http/Controllers/`:
- Authentication controllers in `Auth/` subdirectory
- Domain controllers (e.g., `EntryController`, `TransactionController`, `FinancialAccountController`)
- `AuthenticatedController`: Base controller for authenticated routes
- `Financing/` subdirectory for financing module (PaymentController, IncomeCategoryController, ReceivableController)
- `Report/` subdirectory for reports

### Frontend Assets

Assets are managed by Laravel Elixir (Gulp 3.x) via `gulpfile.js`:

**Sources:**
- `resources/assets/css/`: Custom stylesheets
- `resources/assets/js/`: Custom JavaScript
- `vendor/bower_components/`: Bower dependencies (Gentelella, libraries)

**Output (public/):**
- `public/css/gentelella.min.css`: Main stylesheet bundle
- `public/js/gentelella.min.js`: Main JavaScript bundle
- Specialized bundles: `receipt.min.js`, `company.min.js`, `financing/*.min.js`, etc.

**Important:** After changing assets, always run `docker-compose exec node gulp` to rebuild.

### Views

Blade templates in `resources/views/`:
- `layouts/`: Layout templates
- `auth/`: Authentication views
- `modals/`: Modal components
- Domain-specific directories: `entry/`, `financial/`, `financing/`, `receipt-*`, `report/`
- `includes/`: Reusable partials

### Routes

- `routes/web.php`: Web routes (grouped by authentication and domain)
- `routes/api.php`: API routes

### Database Migrations

Migrations in `database/migrations/`. Notable migration command: `entries:migrate` migrates data from old `entries` table to new transaction structure (`financial_entries`, `transactions`, `transfer_details`).

### Custom Artisan Commands

Located in `app/Console/Commands/`:
- `entries:migrate`: Migrate old entries to new structure (supports `--company=ID`, `--dry-run`, `--rollback`)
- `MigrateViews`: Migrate database views
- `RecalculateBalances`: Recalculate account balances
- `ValidateMigration`: Validate migration integrity
- `ImportCustomer`: Import customer data
- `DropTables`: Utility to drop tables

### Permissions & Roles

Uses `spatie/laravel-permission` package. Models: `Permission`, `Role` in `app/`.

## Testing

Test suites configured in `phpunit.xml`:
- **Unit**: `tests/Unit/`
- **Feature**: `tests/Feature/`
- **Integration**: `tests/Integration/`

Tests use dedicated MySQL container `dbtest` (database: `seara`, user/password: `root`).

E2E tests use Cypress 3.4.1 (`cypress/` directory).

## Key Patterns

### Multi-Company Support

The system supports multiple companies. Many operations can be scoped by company ID (e.g., `entries:migrate --company=47`).

### Legacy Migration

The system is migrating from an old `entries` table structure to a new transaction-based structure:
- Old: `entries` table with `entries_bank`
- New: `financial_entries`, `transactions`, `transfer_details`, `financial_accounts`

### Data Transfer Objects

Uses `spatie/data-transfer-object` package. Base class: `DataTransferObject` in `app/`.

## Common Development Tasks

### Adding a New Financial Module Feature

1. Create service in `app/Service/{Module}/`
2. Create repository interface and implementation
3. Register binding in `AppServiceProvider`
4. Create controller in `app/Http/Controllers/`
5. Add routes in `routes/web.php`
6. Create views in `resources/views/{module}/`
7. Add JavaScript in `resources/assets/js/{module}.js`
8. Update `gulpfile.js` to include new JS/CSS
9. Run `docker-compose exec node gulp`

### Working with DataTables

The application heavily uses DataTables with server-side processing (`yajra/laravel-datatables-oracle`). Controllers often have separate datatable methods/controllers (e.g., `ReceiptDatatablesController`).

### PDF Generation

Uses `barryvdh/laravel-dompdf` for PDF generation (e.g., receipts).

### File Uploads

File uploads for entries use Dropzone.js and are stored with the `FileLaunch` model.

## Environment Configuration

`.env` file requires:
- Database connection (`DB_*` variables pointing to `mysql` container)
- `APP_KEY` (generated via `php artisan key:generate`)
- `APP_ENV` (local/production)
- Mail configuration for notifications

## Production Build

```bash
# Build Docker image
docker build --no-cache -t junioroliveira/seara:1.0.5 -f docker/php/Dockerfile .
```

## Important Notes

- Composer v2 is used (upgrade via `composer self-update --2`)
- NPM version discrepancy: container uses 5.6.0, local development may use 8.19.4
- Storage directory requires write permissions: `sudo chmod -R 777 storage`
- Production environment forces HTTPS via `AppServiceProvider`
- IDE helper is only registered in non-production environments