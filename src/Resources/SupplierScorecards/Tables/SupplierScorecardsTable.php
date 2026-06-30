<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\Tables;

use Filament\Actions;
use Filament\Actions\Action;
use Filament\Notifications\Notification;
use Filament\Support\Icons\Heroicon;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Model;
use JeffersonGoncalves\Erp\Buying\Models\SupplierScorecard;
use JeffersonGoncalves\Erp\Buying\Services\SupplierScorecardService;

class SupplierScorecardsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('name')
                    ->label('Name')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('supplier.supplier_name')
                    ->label('Supplier')
                    ->searchable()
                    ->sortable(),
                TextColumn::make('score')
                    ->label('Score')
                    ->numeric()
                    ->sortable(),
                TextColumn::make('standing')
                    ->label('Standing')
                    ->badge()
                    ->color(fn ($state) => match ($state) {
                        'A' => 'success',
                        'B' => 'info',
                        'C' => 'warning',
                        'D' => 'danger',
                        default => 'gray',
                    })
                    ->toggleable(),
                IconColumn::make('disabled')
                    ->label('Disabled')
                    ->boolean()
                    ->toggleable(),
            ])
            ->defaultSort('name')
            ->filters([
                TernaryFilter::make('disabled')
                    ->label('Disabled'),
            ])
            ->recordActions([
                Actions\EditAction::make(),
                self::refreshScoreAction(),
                Actions\DeleteAction::make(),
            ])
            ->toolbarActions([
                Actions\BulkActionGroup::make([
                    Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    protected static function refreshScoreAction(): Action
    {
        return Action::make('refreshScore')
            ->label('Refresh score')
            ->icon(Heroicon::OutlinedArrowPath)
            ->color('info')
            ->requiresConfirmation()
            ->action(function (Model $record): void {
                if (! $record instanceof SupplierScorecard) {
                    return;
                }

                try {
                    app(SupplierScorecardService::class)->refresh($record);

                    Notification::make()
                        ->title('Scorecard refreshed')
                        ->body('Score '.number_format((float) $record->score, 2).' — standing '.$record->standing.'.')
                        ->success()
                        ->send();
                } catch (\Throwable $exception) {
                    Notification::make()
                        ->title('Unable to refresh scorecard')
                        ->body($exception->getMessage())
                        ->danger()
                        ->send();
                }
            });
    }
}
