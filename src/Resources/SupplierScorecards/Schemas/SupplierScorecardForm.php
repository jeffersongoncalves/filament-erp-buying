<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;

class SupplierScorecardForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->columns(null)
            ->schema([
                Section::make('Details')
                    ->schema([
                        Select::make('supplier_id')
                            ->label('Supplier')
                            ->relationship('supplier', 'supplier_name')
                            ->searchable()
                            ->preload()
                            ->required(),
                        TextInput::make('name')
                            ->label('Name')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('weighting_function')
                            ->label('Weighting Function')
                            ->maxLength(255),
                        TextInput::make('standing')
                            ->label('Standing')
                            ->disabled()
                            ->dehydrated(false),
                        TextInput::make('score')
                            ->label('Score')
                            ->numeric()
                            ->disabled()
                            ->dehydrated(false),
                        Toggle::make('disabled')
                            ->label('Disabled')
                            ->default(false),
                    ])->columns(2),
            ]);
    }
}
