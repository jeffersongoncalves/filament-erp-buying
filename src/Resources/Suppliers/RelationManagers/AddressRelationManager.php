<?php

namespace JeffersonGoncalves\FilamentErp\Buying\Resources\Suppliers\RelationManagers;

use Filament\Actions;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Schemas\Schema;
use Filament\Tables\Columns\IconColumn;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use JeffersonGoncalves\Erp\Core\Enums\AddressType;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'addresses';

    protected static ?string $title = 'Addresses';

    public function form(Schema $schema): Schema
    {
        return $schema
            ->columns(2)
            ->components([
                Select::make('address_type')
                    ->label('Type')
                    ->options(self::addressTypeOptions())
                    ->default(AddressType::Billing->value)
                    ->required(),
                Toggle::make('is_primary')
                    ->label('Primary'),
                TextInput::make('address_line1')
                    ->label('Address Line 1')
                    ->required()
                    ->maxLength(255),
                TextInput::make('address_line2')
                    ->label('Address Line 2')
                    ->maxLength(255),
                TextInput::make('city')
                    ->required()
                    ->maxLength(255),
                TextInput::make('state')
                    ->maxLength(255),
                TextInput::make('country')
                    ->required()
                    ->maxLength(255),
                TextInput::make('pincode')
                    ->label('Postal Code')
                    ->maxLength(255),
            ]);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('address_line1')
            ->columns([
                TextColumn::make('address_type')
                    ->label('Type')
                    ->badge(),
                TextColumn::make('address_line1')
                    ->label('Address')
                    ->searchable(),
                TextColumn::make('city')
                    ->searchable(),
                TextColumn::make('country')
                    ->searchable(),
                IconColumn::make('is_primary')
                    ->label('Primary')
                    ->boolean(),
            ])
            ->headerActions([
                Actions\CreateAction::make(),
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

    /** @return array<string, string> */
    protected static function addressTypeOptions(): array
    {
        $options = [];

        foreach (AddressType::cases() as $case) {
            $options[$case->value] = $case->label();
        }

        return $options;
    }
}
