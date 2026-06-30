<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\RelationManagers;

use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class SuppliersRelationManager extends RelationManager
{
    protected static string $relationship = 'suppliers';

    protected static ?string $title = 'Suppliers';

    public function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                Select::make('supplier_id')
                    ->label('Supplier')
                    ->relationship('supplier', 'supplier_name')
                    ->searchable()
                    ->preload()
                    ->required(),
                TextInput::make('quote_status')
                    ->label('Quote Status')
                    ->default('Pending')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('supplier_id')
            ->columns([
                TextColumn::make('supplier.supplier_name')
                    ->label('Supplier')
                    ->searchable(),
                TextColumn::make('quote_status')
                    ->label('Quote Status')
                    ->badge(),
            ])
            ->headerActions([
                Actions\CreateAction::make(),
            ])
            ->actions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
