<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierQuotations\Tables;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\Erp\Buying\Models\SupplierQuotation;
use JeffersonGoncalves\Erp\Buying\Services\SupplierQuotationService;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\FilamentErp\Core\Concerns\SubmittableRecordActions;

class SupplierQuotationsTable
{
    use SubmittableRecordActions;

    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('supplier_name')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('transaction_date')
                    ->label('Date')
                    ->date()
                    ->sortable(),
                TextColumn::make('valid_till')
                    ->label('Valid Till')
                    ->date()
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('company.name')
                    ->label('Company')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('currency')
                    ->label('Currency')
                    ->toggleable(),
                TextColumn::make('grand_total')
                    ->label('Grand Total')
                    ->numeric()
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
            ->defaultSort('transaction_date', 'desc')
            ->filters([
                SelectFilter::make('docstatus')
                    ->label('Status')
                    ->options([
                        0 => 'Draft',
                        1 => 'Submitted',
                        2 => 'Cancelled',
                    ]),
            ])
            ->recordActions([
                Actions\EditAction::make()
                    ->visible(fn ($record): bool => $record->docstatus === DocStatus::Draft),
                ...self::submittableRecordActions(),
                self::createPurchaseOrderAction(),
                Actions\DeleteAction::make()
                    ->visible(fn ($record): bool => $record->docstatus === DocStatus::Draft),
            ]);
    }

    protected static function createPurchaseOrderAction(): Action
    {
        return Action::make('createPurchaseOrder')
            ->label('Create Purchase Order')
            ->icon(Heroicon::OutlinedShoppingCart)
            ->color('info')
            ->requiresConfirmation()
            ->visible(fn (Model $record): bool => $record->getAttribute('docstatus') === DocStatus::Submitted)
            ->action(function (Model $record): void {
                if (! $record instanceof SupplierQuotation) {
                    return;
                }

                try {
                    $order = app(SupplierQuotationService::class)->createPurchaseOrder($record);

                    Notification::make()
                        ->title('Purchase order created')
                        ->body('Draft purchase order #'.$order->getKey().' created.')
                        ->success()
                        ->send();
                } catch (\Throwable $exception) {
                    Notification::make()
                        ->title('Unable to create purchase order')
                        ->body($exception->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
}
