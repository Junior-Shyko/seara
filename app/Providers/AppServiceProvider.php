<?php

namespace Seara\Providers;

use Seara\Service\Company\CompanyDataProvider;
use Seara\Service\Company\CompanyImporter;
use Seara\Service\Company\CompanyImporterFactory;
use Seara\Service\Company\CompanyRepository;
use Seara\Service\Company\CsvCompanyExtractor;
use Seara\Service\Company\DelayedCompanyDataProvider;
use Seara\Service\Company\EloquentCompanyRepository;
use Illuminate\Support\Facades\URL;
use Seara\Service\Company\ReceitaWsCompanyDataProvider;
use Seara\Service\Core\Transactor\EloquentTransactor;
use Seara\Service\Core\Transactor\Transactor;
use Seara\Service\Financing\Account\AccountRepository;
use Seara\Service\Financing\Account\EloquentAccountRepository;
use Seara\Service\Financing\IncomeCategory\EloquentIncomeCategoryRepository;
use Seara\Service\Financing\IncomeCategory\IncomeCategoryRepository;
use Seara\Service\Financing\Receivable\EloquentReceivableRepository;
use Seara\Service\Financing\Receivable\PendingReceivable\EloquentPendingReceivable;
use Seara\Service\Financing\Receivable\PendingReceivable\PendingReceivableQuery;
use Seara\Service\Financing\Receivable\ReceivableRepository;
use Seara\Service\Report\DebtReport\DebtReportFormatter;
use Seara\Service\Report\DebtReport\DebtReportProvider;
use Seara\Service\Report\DebtReport\EloquentDebtReportProvider;
use Seara\Service\Report\DebtReport\ExcelReportFormatter;
use Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider;
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        // Força HTTPS se APP_URL estiver configurado com https
        if (starts_with(config('app.url'), 'https://')) {
            URL::forceScheme('https');
        }
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->environment() !== 'production') {
            $this->app->register(IdeHelperServiceProvider::class);
        }

        $this->app->bind(CompanyDataProvider::class, ReceitaWsCompanyDataProvider::class);
        $this->app->bind(CompanyImporter::class, function (Container $app) {
            return $app->make(CompanyImporterFactory::class)
                ->make();
        });
        $this->app->bind(AccountRepository::class, EloquentAccountRepository::class);
        $this->app->bind(IncomeCategoryRepository::class, EloquentIncomeCategoryRepository::class);
        $this->app->bind(Transactor::class, EloquentTransactor::class);
        $this->app->bind(ReceivableRepository::class, EloquentReceivableRepository::class);
        $this->app->bind(PendingReceivableQuery::class, EloquentPendingReceivable::class);

        $this->app->bind(DebtReportProvider::class, EloquentDebtReportProvider::class);
        $this->app->bind(DebtReportFormatter::class, ExcelReportFormatter::class);
    }
}
