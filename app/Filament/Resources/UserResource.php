<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Filament\Resources\UserResource\RelationManagers;
use App\Filament\Resources\UserResource\RelationManagers\AddressRelationManager;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user';
    protected static ?string $navigationLabel = 'Customers';
    protected static ?string $navigationGroup = 'Store';
    protected static ?int $navigationSort = 4;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Info')->schema([
                    Forms\Components\TextInput::make('name')
                        ->required()
                        ->label('First Name')
                        ->maxLength(255),
                    Forms\Components\TextInput::make('last_name')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\TextInput::make('email')
                        ->email()
                        ->required()
                        ->maxLength(255)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('phone')
                        ->required()
                        ->maxLength(11)
                        ->columnSpanFull(),
                    Forms\Components\TextInput::make('role')
                        ->required()
                        ->columnSpanFull(),
                ])->columnSpan(2)->columns(2),

                Section::make('Insights')->schema([
                    Placeholder::make('created_at')
                        ->label('Signed Up')
                        ->content(fn($record): ?string => $record->created_at),
                    Placeholder::make('orders_count')
                        ->label('Orders')
                        ->content(fn($record): ?string => $record->order()->count()),
                    Placeholder::make('total_amount')
                        ->label('Total')
                        ->content(fn($record): ?string => number_format($record->order()->sum('total_amount'),2)),
                    Placeholder::make('last_order')
                        ->label('Last Order Info')
                        ->content(fn($record): ?string => '# ' . $record->order()->latest()->first()->id . ' - ' . ' Total : ' . $record->order()->latest()->first()->total_amount . ' - ' . $record->order()->latest()->first()->status),
                ])->columnSpan(1),

            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->label('Full Name')
                    ->searchable()
                    ->formatStateUsing(fn ($record) => $record->name . ' ' . $record->last_name),
                Tables\Columns\TextColumn::make('email')
                    ->searchable(),
                Tables\Columns\TextColumn::make('phone')
                    ->searchable(),
                Tables\Columns\TextColumn::make('address')
                    ->searchable()
                    ->formatStateUsing(fn ($record) => 
                        $record->address->first()->country->name . ', ' . 
                        $record->address->first()->city->name . ', ' . 
                        $record->address->first()->area->name . '<br/>' .
                        $record->address->first()->street
                    )->html(),
                Tables\Columns\TextColumn::make('role')
                    ->label('Type')
                    ->searchable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->label('Total Orders')
                    ->formatStateUsing(fn($record): ?string => $record->order()->count()),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ])
            ->paginated([25,50,75,100]);
    }

    public static function getRelations(): array
    {
        return [
            AddressRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }
}
