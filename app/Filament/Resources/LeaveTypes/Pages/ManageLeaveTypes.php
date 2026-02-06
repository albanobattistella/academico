<?php

namespace App\Filament\Resources\LeaveTypes\Pages;

use App\Filament\Pages\Concerns\HasTranslatableContent;
use App\Filament\Resources\LeaveTypes\LeaveTypeResource;
use Filament\Actions\CreateAction;
use Filament\Resources\Pages\ManageRecords;

class ManageLeaveTypes extends ManageRecords
{
    use HasTranslatableContent;

    protected static string $resource = LeaveTypeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            CreateAction::make(),
        ];
    }
}
