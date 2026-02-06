<?php

namespace App\Filament\Resources\SkillScales;

use App\Filament\Resources\Concerns\Translatable;
use App\Filament\Resources\SkillScales\Pages\ManageSkillScales;
use App\Models\Skills\SkillScale;
use BackedEnum;
use Filament\Actions\BulkActionGroup;
use Filament\Actions\DeleteAction;
use Filament\Actions\DeleteBulkAction;
use Filament\Actions\EditAction;
use Filament\Forms\Components\TextInput;
use Filament\Resources\Resource;
use Filament\Schemas\Schema;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use UnitEnum;

class SkillScaleResource extends Resource
{
    use Translatable;

    protected static ?string $model = SkillScale::class;

    protected static string|BackedEnum|null $navigationIcon = Heroicon::OutlinedScale;

    protected static string|UnitEnum|null $navigationGroup = 'Academic';

    public static function form(Schema $schema): Schema
    {
        return $schema
            ->components([
                TextInput::make('shortname')
                    ->required()
                    ->maxLength(8)
                    ->unique(table: 'skill_scales', ignoreRecord: true),
                TextInput::make('name')
                    ->required()
                    ->minLength(1)
                    ->maxLength(40)
                    ->unique(ignoreRecord: true),
                TextInput::make('value')
                    ->required()
                    ->numeric()
                    ->minValue(0)
                    ->maxValue(1)
                    ->step(0.01),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('shortname')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('value')
                    ->sortable(),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                EditAction::make(),
                DeleteAction::make(),
            ])
            ->toolbarActions([
                BulkActionGroup::make([
                    DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => ManageSkillScales::route('/'),
        ];
    }
}
