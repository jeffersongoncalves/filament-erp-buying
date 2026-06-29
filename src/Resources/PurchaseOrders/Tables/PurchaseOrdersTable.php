<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\PurchaseOrders\Tables;

use Filament\Notifications\Notification;
use Filament\Tables\Actions;
use Filament\Tables\Actions\Action;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\Erp\Buying\Enums\PurchaseOrderStatus;
use JeffersonGoncalves\Erp\Buying\Models\PurchaseOrder;
use JeffersonGoncalves\Erp\Buying\Services\PurchaseOrderService;
use JeffersonGoncalves\Erp\Core\Enums\DocStatus;
use JeffersonGoncalves\FilamentErp\Core\Concerns\SubmittableRecordActions;

class PurchaseOrdersTable
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
                TextColumn::make('schedule_date')
                    ->label('Required By')
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
                TextColumn::make('status')
                    ->label('Order Status')
                    ->badge()
                    ->formatStateUsing(fn ($state) => $state instanceof PurchaseOrderStatus ? $state->value : $state)
                    ->color(fn ($state) => match ($state) {
                        PurchaseOrderStatus::Completed => 'success',
                        PurchaseOrderStatus::Cancelled, PurchaseOrderStatus::Closed => 'danger',
                        PurchaseOrderStatus::Draft => 'gray',
                        default => 'warning',
                    }),
                TextColumn::make('per_received')
                    ->label('% Received')
                    ->numeric()
                    ->toggleable(),
                TextColumn::make('per_billed')
                    ->label('% Billed')
                    ->numeric()
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
            ->actions([
                Actions\EditAction::make()
                    ->visible(fn ($record): bool => $record->docstatus === DocStatus::Draft),
                ...self::submittableRecordActions(),
                self::createPurchaseReceiptAction(),
                self::createPurchaseInvoiceAction(),
                Actions\DeleteAction::make()
                    ->visible(fn ($record): bool => $record->docstatus === DocStatus::Draft),
            ]);
    }

    protected static function createPurchaseReceiptAction(): Action
    {
        return Action::make('createPurchaseReceipt')
            ->label('Create Purchase Receipt')
            ->icon('heroicon-o-inbox-arrow-down')
            ->color('info')
            ->requiresConfirmation()
            ->visible(fn (Model $record): bool => $record->getAttribute('docstatus') === DocStatus::Submitted)
            ->action(function (Model $record): void {
                if (! $record instanceof PurchaseOrder) {
                    return;
                }

                try {
                    $receipt = app(PurchaseOrderService::class)->createPurchaseReceipt($record);

                    Notification::make()
                        ->title('Purchase receipt created')
                        ->body('Draft purchase receipt #'.$receipt->getKey().' created.')
                        ->success()
                        ->send();
                } catch (\Throwable $exception) {
                    Notification::make()
                        ->title('Unable to create purchase receipt')
                        ->body($exception->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }

    protected static function createPurchaseInvoiceAction(): Action
    {
        return Action::make('createPurchaseInvoice')
            ->label('Create Purchase Invoice')
            ->icon('heroicon-o-document-text')
            ->color('info')
            ->requiresConfirmation()
            ->visible(fn (Model $record): bool => $record->getAttribute('docstatus') === DocStatus::Submitted)
            ->action(function (Model $record): void {
                if (! $record instanceof PurchaseOrder) {
                    return;
                }

                try {
                    $invoice = app(PurchaseOrderService::class)->createPurchaseInvoice($record);

                    Notification::make()
                        ->title('Purchase invoice created')
                        ->body('Draft purchase invoice #'.$invoice->getKey().' created.')
                        ->success()
                        ->send();
                } catch (\Throwable $exception) {
                    Notification::make()
                        ->title('Unable to create purchase invoice')
                        ->body($exception->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
}
