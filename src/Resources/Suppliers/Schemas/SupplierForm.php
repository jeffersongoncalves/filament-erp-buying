<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\Schemas;

use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;

class SupplierForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->columns(null)
            ->schema([
                Section::make('Details')
                    ->schema([
                        TextInput::make('supplier_name')
                            ->label('Supplier Name')
                            ->required()
                            ->maxLength(255),
                        Select::make('supplier_group_id')
                            ->label('Supplier Group')
                            ->relationship('supplierGroup', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        Select::make('supplier_type')
                            ->label('Supplier Type')
                            ->options([
                                'Company' => 'Company',
                                'Individual' => 'Individual',
                            ])
                            ->default('Company')
                            ->required(),
                        TextInput::make('country')
                            ->label('Country')
                            ->maxLength(255),
                        TextInput::make('default_currency')
                            ->label('Default Currency')
                            ->default('USD')
                            ->maxLength(3),
                        TextInput::make('tax_id')
                            ->label('Tax ID')
                            ->maxLength(255),
                        Toggle::make('disabled')
                            ->label('Disabled')
                            ->default(false),
                    ])->columns(2),
            ]);
    }
}
