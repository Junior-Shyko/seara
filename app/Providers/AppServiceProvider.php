<?php

namespace App\Providers;

use App\Service\Company\CompanyDataProvider;
use App\Service\Company\CompanyImporter;
use App\Service\Company\CompanyImporterFactory;
use App\Service\Company\CompanyRepository;
use App\Service\Company\CsvCompanyExtractor;
use App\Service\Company\DelayedCompanyDataProvider;
use App\Service\Company\EloquentCompanyRepository;
use App\Service\Company\Extractor;
use App\Service\Company\ReceitaWsCompanyDataProvider;
use App\Service\Core\Transactor\EloquentTransactor;
use App\Service\Core\Transactor\Transactor;
use App\Service\Financing\Account\AccountRepository;
use App\Service\Financing\Account\EloquentAccountRepository;
use App\Service\Financing\IncomeCategory\EloquentIncomeCategoryRepository;
use App\Service\Financing\IncomeCategory\IncomeCategoryRepository;
use App\Service\Financing\Receivable\EloquentReceivableRepository;
use App\Service\Financing\Receivable\ReceivableRepository;
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
        //
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
    }
}
