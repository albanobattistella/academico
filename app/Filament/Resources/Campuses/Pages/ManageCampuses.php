<?php

namespace App\Filament\Resources\Campuses\Pages;

use App\Filament\Pages\Concerns\HasTranslatableContent;
use App\Filament\Resources\Campuses\CampusResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageCampuses extends ManageRecords
{
    use HasTranslatableContent;

    protected static string $resource = CampusResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
