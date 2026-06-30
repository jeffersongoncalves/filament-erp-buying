<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Components\Section;
use Filament\Schemas\Schema;

class SupplierQuotationForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->columns(null)
            ->components([
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
