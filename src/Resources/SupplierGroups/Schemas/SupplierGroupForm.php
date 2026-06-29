<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\Schemas;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SupplierGroupForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
                Section::make('Details')
                    ->schema([
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),
                        Select::make('parent_supplier_group_id')
                            ->label('Parent Group')
                            ->relationship('parent', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Toggle::make('is_group')
                            ->label('Is Group')
                            ->default(false),
                    ])->columns(2),
            ]);
    }
}
