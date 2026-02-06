<?php

namespace App\Filament\Resources\Rhythms\Pages;

use App\Filament\Resources\Rhythms\RhythmResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageRhythms extends ManageRecords
{
    protected static string $resource = RhythmResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
