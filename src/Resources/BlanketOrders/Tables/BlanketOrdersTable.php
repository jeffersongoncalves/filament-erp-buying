<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\BlanketOrders\Tables;

use Filament\Tables\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Buying\Enums\BlanketOrderType;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\FilamentErp\Core\Concerns\SubmittableRecordActions;

class BlanketOrdersTable
{
    use SubmittableRecordActions;

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('order_type')
                    ->label('Order Type')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof BlanketOrderType ? $state->value : $state)
                    ->color(fn ($state) => match ($state) {
                        BlanketOrderType::Purchasing => 'info',
                        BlanketOrderType::Selling => 'warning',
                        default => 'gray',
                    }),
                TextColumn::make('party_type')
                    ->label('Party Type')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('from_date')
                    ->label('From Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('to_date')
                    ->label('To Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('company.name')
                    ->label('Company')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('docstatus')
                    ->label('Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof DocStatus ? $state->name : $state)
                    ->color(fn ($state) => match ($state) {
                        DocStatus::Draft => 'gray',
                        DocStatus::Submitted => 'success',
                        DocStatus::Cancelled => 'danger',
                        default => 'gray',
                    }),
            ])
            ->defaultSort('from_date', 'desc')
            ->filters([
                SelectFilter::make('order_type')
                    ->label('Order Type')
                    ->options([
                        BlanketOrderType::Purchasing->value => 'Purchasing',
                        BlanketOrderType::Selling->value => 'Selling',
                    ]),
                SelectFilter::make('docstatus')
                    ->label('Status')
                    ->options([
                        0 => 'Draft',
                        1 => 'Submitted',
                        2 => 'Cancelled',
                    ]),
            ])
            ->actions([
                Actions\EditAction::make()
                    ->visible(fn ($record): bool => $record->docstatus === DocStatus::Draft),
                ...self::submittableRecordActions(),
                Actions\DeleteAction::make()
                    ->visible(fn ($record): bool => $record->docstatus === DocStatus::Draft),
            ]);
    }
}
