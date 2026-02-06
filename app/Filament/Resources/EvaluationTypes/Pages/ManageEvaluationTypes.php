<?php

namespace App\Filament\Resources\EvaluationTypes\Pages;

use App\Filament\Resources\EvaluationTypes\EvaluationTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageEvaluationTypes extends ManageRecords
{
    protected static string $resource = EvaluationTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
