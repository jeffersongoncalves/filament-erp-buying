<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;

class SupplierQuotationForm
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
                        TextInput::make('party_id')
                            ->label('Supplier ID')
                            ->numeric(),
                        DatePicker::make('transaction_date')
                            ->label('Transaction Date')
                            ->required()
                            ->default(now()),
                        DatePicker::make('valid_till')
                            ->label('Valid Till'),
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        TextInput::make('currency')
                            ->label('Currency')
                            ->default('USD')
                            ->maxLength(3),
                    ])->columns(2),
            ]);
    }
}
