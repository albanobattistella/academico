<?php

namespace App\Filament\Resources\SkillTypes\Pages;

use App\Filament\Resources\SkillTypes\SkillTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageSkillTypes extends ManageRecords
{
    protected static string $resource = SkillTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
