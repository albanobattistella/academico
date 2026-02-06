<?php

namespace App\Providers;

use App\Interfaces\CertificatesInterface;
use App\Interfaces\EnrollmentSheetInterface;
use App\Interfaces\InvoicingInterface;
use App\Interfaces\MailingSystemInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(InvoicingInterface::class, function () {
            return new (config('invoicing.invoicing_system'));
        });

        $this->app->bind(CertificatesInterface::class, function () {
            return new (config('certificates-generation.style'));
        });

        $this->app->bind(EnrollmentSheetInterface::class, function () {
            return new (config('enrollment-sheet.style'));
        });

        $this->app->bind(MailingSystemInterface::class, function () {
            return new (config('mailing-system.mailing_system'));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
