<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\SupplierScorecards\RelationManagers;

use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables\Actions;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class CriteriaRelationManager extends RelationManager
{
    protected static string $relationship = 'criteria';

    protected static ?string $title = 'Criteria';

    public function form(Form $form): Form
    {
        return $form
            ->columns(2)
            ->schema([
                TextInput::make('criteria_name')
                    ->label('Criteria Name')
                    ->required()
                    ->maxLength(255),
                TextInput::make('weight')
                    ->label('Weight')
                    ->numeric()
                    ->default(0),
                TextInput::make('max_score')
                    ->label('Max Score')
                    ->numeric()
                    ->default(100),
                TextInput::make('score')
                    ->label('Score')
                    ->numeric()
                    ->default(0),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('criteria_name')
            ->columns([
                TextColumn::make('criteria_name')
                    ->label('Criteria Name')
                    ->searchable(),
                TextColumn::make('weight')
                    ->numeric(),
                TextColumn::make('max_score')
                    ->label('Max Score')
                    ->numeric(),
                TextColumn::make('score')
                    ->numeric(),
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
