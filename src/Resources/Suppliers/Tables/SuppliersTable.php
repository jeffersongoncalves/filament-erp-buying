<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\Tables;

use Filament\Tables\Actions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class SuppliersTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('supplier_name')
                    ->label('Supplier Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('supplierGroup.name')
                    ->label('Group')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('supplier_type')
                    ->label('Type')
                    ->badge()
                    ->toggleable(),
                TextColumn::make('country')
                    ->label('Country')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('default_currency')
                    ->label('Currency')
                    ->toggleable(),
                IconColumn::make('disabled')
                    ->label('Disabled')
                    ->boolean()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->defaultSort('supplier_name')
            ->filters([
                SelectFilter::make('supplier_group_id')
                    ->label('Supplier Group')
                    ->relationship('supplierGroup', 'name')
                    ->searchable()
                    ->preload(),
                SelectFilter::make('supplier_type')
                    ->label('Supplier Type')
                    ->options([
                        'Company' => 'Company',
                        'Individual' => 'Individual',
                    ]),
                TernaryFilter::make('disabled')
                    ->label('Disabled'),
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
