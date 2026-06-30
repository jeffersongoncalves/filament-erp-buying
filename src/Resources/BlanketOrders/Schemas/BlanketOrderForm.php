<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\Schemas;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use JeffersonGoncalves\Erp\Buying\Enums\BlanketOrderType;

class BlanketOrderForm
{
    public static function configure(Form $form): Form
    {
        return $form
            ->columns(null)
            ->schema([
                Section::make('Details')
                    ->schema([
                        Select::make('order_type')
                            ->label('Order Type')
                            ->options([
                                BlanketOrderType::Purchasing->value => 'Purchasing',
                                BlanketOrderType::Selling->value => 'Selling',
                            ])
                            ->default(BlanketOrderType::Purchasing->value)
                            ->required(),
                        TextInput::make('party_type')
                            ->label('Party Type')
                            ->default('Supplier')
                            ->required()
                            ->maxLength(255),
                        TextInput::make('party_id')
                            ->label('Party ID')
                            ->numeric(),
                        Select::make('company_id')
                            ->label('Company')
                            ->relationship('company', 'name')
                            ->searchable()
                            ->preload()
                            ->nullable(),
                        DatePicker::make('from_date')
                            ->label('From Date')
                            ->required()
                            ->default(now()),
                        DatePicker::make('to_date')
                            ->label('To Date')
                            ->required()
                            ->default(now()->addYear()),
                    ])->columns(2),
            ]);
    }
}
