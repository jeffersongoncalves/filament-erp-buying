<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\RequestForQuotations\RelationManagers;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class ItemsRelationManager extends RelationManager
{
    protected static string $relationship = 'items';

    protected static ?string $title = 'Items';

    public function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                TextInput::make('item_code')
                    ->label('Item Code')
                    ->required()
                    ->maxLength(255),
                TextInput::make('item_name')
                    ->label('Item Name')
                    ->maxLength(255),
                TextInput::make('qty')
                    ->label('Qty')
                    ->numeric()
                    ->default(1),
                Select::make('warehouse_id')
                    ->label('Warehouse')
                    ->relationship('warehouse', 'name')
                    ->searchable()
                    ->preload()
                    ->nullable(),
                DatePicker::make('schedule_date')
                    ->label('Required By'),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('item_code')
            ->columns([
                TextColumn::make('item_code')
                    ->label('Item Code')
                    ->searchable(),
                TextColumn::make('item_name')
                    ->label('Item Name')
                    ->toggleable(),
                TextColumn::make('qty')
                    ->numeric(),
                TextColumn::make('warehouse.name')
                    ->label('Warehouse')
                    ->toggleable(),
                TextColumn::make('schedule_date')
                    ->label('Required By')
                    ->date()
                    ->toggleable(),
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
