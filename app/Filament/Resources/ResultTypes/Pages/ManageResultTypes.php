<?php

namespace App\Filament\Resources\ResultTypes\Pages;

use App\Filament\Pages\Concerns\HasTranslatableContent;
use App\Filament\Resources\ResultTypes\ResultTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageResultTypes extends ManageRecords
{
    use HasTranslatableContent;

    protected static string $resource = ResultTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
