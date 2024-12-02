<?php

namespace App\Filament\Resources\UserResource\RelationManagers;

use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class AddressRelationManager extends RelationManager
{
    protected static string $relationship = 'Address';

    public function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('country_id')
                    ->relationship('Country', 'name')
                    ->reactive()
                    ->afterStateUpdated(fn (callable $set) => $set('city_id', null)),
                Forms\Components\Select::make('city_id')
                    ->relationship('City', 'name')
                    ->reactive()
                    ->options(function ($get) {
                        $countryId = $get('country_id');
                        return \App\Models\City::where('country_id', $countryId)->pluck('name', 'id');
                    })
                    ->afterStateUpdated(fn (callable $set) => $set('area_id', null))
                    ->disabled(fn ($get) => !$get('country_id')),
                Forms\Components\Select::make('area_id')
                    ->relationship('Area', 'name')
                    ->reactive()
                    ->options(function ($get) {
                        $cityId = $get('city_id');
                        return \App\Models\Area::where('city_id', $cityId)->pluck('name', 'id');
                    })
                    ->disabled(fn ($get) => !$get('city_id')),
                Forms\Components\TextInput::make('street')->required()->maxLength(255),
                Forms\Components\Select::make('building_type')->required()
                    ->options([
                        "flat" => "Flat",
                        "villa" => "Villa"
                    ]),
                Forms\Components\TextInput::make('building_number')->required()->numeric(),
                Forms\Components\TextInput::make('floor')->numeric(),
                Forms\Components\TextInput::make('apartment_number')->numeric(),
                Forms\Components\Toggle::make('is_default')
                    ->required()
                    ->default(false)
                    ->columnSpanFull(),
            ])->columns(3);
    }

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('street')
            ->columns([
                Tables\Columns\IconColumn::make('is_default')->label("Default")->boolean(),
                Tables\Columns\TextColumn::make('Country.name') ,
                Tables\Columns\TextColumn::make('City.name') ,
                Tables\Columns\TextColumn::make('Area.name') ,
                Tables\Columns\TextColumn::make('street'),
                Tables\Columns\TextColumn::make('building_type'),
                Tables\Columns\TextColumn::make('building_number'),
                Tables\Columns\TextColumn::make('floor'),
                Tables\Columns\TextColumn::make('apartment_number'),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                Tables\Actions\CreateAction::make()->createAnother(false),
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\DeleteAction::make()->iconButton(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
