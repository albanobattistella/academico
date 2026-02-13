<?php

namespace App\Filament\Resources\Settings\LeadTypes\Pages;

use App\Filament\Resources\Settings\LeadTypes\LeadTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageLeadTypes extends ManageRecords
{
    protected static string $resource = LeadTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
