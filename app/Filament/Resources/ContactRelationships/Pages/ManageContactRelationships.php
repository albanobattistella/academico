<?php

namespace App\Filament\Resources\ContactRelationships\Pages;

use App\Filament\Pages\Concerns\HasTranslatableContent;
use App\Filament\Resources\ContactRelationships\ContactRelationshipResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageContactRelationships extends ManageRecords
{
    use HasTranslatableContent;

    protected static string $resource = ContactRelationshipResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
