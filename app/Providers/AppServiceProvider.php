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
use Illuminate\Contracts\Container\Container;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{

    protected $defer = true;
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
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
        }

        $this->app->bind(CompanyDataProvider::class, ReceitaWsCompanyDataProvider::class);
        $this->app->bind(CompanyImporter::class, function (Container $app) {
            return $app->make(CompanyImporterFactory::class)
                ->make();
        });
    }
}
