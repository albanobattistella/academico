<?php

namespace App\Filament\Resources\Paymentmethods\Pages;

use App\Filament\Resources\Paymentmethods\PaymentmethodResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManagePaymentmethods extends ManageRecords
{
    protected static string $resource = PaymentmethodResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
