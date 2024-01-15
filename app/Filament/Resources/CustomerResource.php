<?php

namespace App\Filament\Resources;

use App\Filament\Resources\CustomerResource\Pages;
use App\Filament\Resources\CustomerResource\RelationManagers;
use App\Models\Customer;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Support\RawJs;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class CustomerResource extends Resource
{
    protected static ?string $model = Customer::class;

    protected static ?string $navigationIcon = 'heroicon-o-rectangle-stack';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->label('common.name')->translateLabel()
                    ->required()->maxLength(255),
                Forms\Components\TextInput::make('last_name')
                    ->label('common.last_name')->translateLabel()
                    ->required()->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()->required(),
                Forms\Components\TextInput::make('document')
                    ->label('common.document')->translateLabel()
                    ->rules(['formato_cpf_ou_cnpj'])
                    ->required()
                    ->mask(RawJs::make(<<<'JS'
                        $input.replaceAll(/\D/g, '').length <= 11 ? '999.999.999-99' : '99.999.999/9999-99'
                    JS
                    )),
                Forms\Components\TextInput::make('phone')
                    ->label('common.phone')->translateLabel()
                    ->required()
                    ->mask(RawJs::make(<<<'JS'
                        $input.replaceAll(/\D/g, '').length <= 10 ? '(99) 9999-9999' : '(99) 99999-9999'
                    JS
                    ))->columnSpanFull(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('id')
                    ->label('#'),
                Tables\Columns\TextColumn::make('document_with_mask')
                    ->label('common.document')->translateLabel()
                    ->searchable(['document'])
                    ->toggleable(),
                Tables\Columns\TextColumn::make('name')
                    ->formatStateUsing(fn($record) => sprintf("%s %s", $record->name, $record->last_name))
                    ->label('common.name')->translateLabel()
                    ->sortable()
                    ->searchable(),
                Tables\Columns\TextColumn::make('email')
                    ->searchable()->toggleable(),
                Tables\Columns\TextColumn::make('phone_with_mask')
                    ->label('Phone')
                    ->searchable(['phone'])
                    ->toggleable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->since()->sortable()->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()->sortable()->toggleable(),
                Tables\Columns\TextColumn::make('deleted_at')
                    ->dateTime()->sortable()->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                Tables\Filters\TrashedFilter::make(),
            ])
            ->actions([
                Tables\Actions\ActionGroup::make([
                    Tables\Actions\ViewAction::make(),
                    Tables\Actions\EditAction::make(),
                    Tables\Actions\DeleteAction::make(),
                    Tables\Actions\RestoreAction::make(),
                ])->label('More actions')
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                    Tables\Actions\ForceDeleteBulkAction::make(),
                    Tables\Actions\RestoreBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListCustomers::route('/'),
            'create' => Pages\CreateCustomer::route('/create'),
            'edit' => Pages\EditCustomer::route('/{record}/edit'),
        ];
    }

    public static function getEloquentQuery(): Builder
    {
        return parent::getEloquentQuery()
            ->withoutGlobalScopes([
                SoftDeletingScope::class,
            ]);
    }
}
