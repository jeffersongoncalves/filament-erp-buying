<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierGroups\Tables;

use Filament\Actions;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class SupplierGroupsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('parent.name')
                    ->label('Parent Group')
                    ->toggleable()
                    ->sortable(),
                IconColumn::make('is_group')
                    ->label('Is Group')
                    ->boolean()
                    ->toggleable(),
            ])
            ->defaultSort('name')
            ->filters([
                TernaryFilter::make('is_group')
                    ->label('Is Group'),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
