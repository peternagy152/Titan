<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ShopCategoryResource\Pages;
use App\Filament\Resources\ShopCategoryResource\RelationManagers;
use App\Models\ShopCategory;
use Filament\Forms;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Resources\Concerns\Translatable;

class ShopCategoryResource extends Resource
{
    protected static ?string $model = ShopCategory::class;

    protected static ?string $navigationIcon = 'heroicon-o-tag';
    protected static ?string $navigationGroup = 'Store';
    protected static ?string $navigationLabel = 'Categories';
    protected static ?int $navigationSort = 3;

    use Translatable;
    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make("Naming")->schema([
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\TextInput::make('name')
                                ->required()
                                ->maxLength(255)
                                ->live(onBlur: true)
                                ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                            Forms\Components\TextInput::make('slug')
                                ->disabled()
                                ->dehydrated()
                                ->required()
                                ->maxLength(255)
                                ->unique(ShopCategory::class, 'slug', ignoreRecord: true),
                        ]),

                        Forms\Components\Select::make('parent_id')
                            ->label('Parent')
                            ->preload()
                            ->relationship('Parent', 'name', fn(Builder $query) => $query->where('parent_id', null))
                            ->searchable(),

                    ]),
                    Forms\Components\MarkdownEditor::make("description"),

                ])->columnSpan(['lg' => 2]),
                Forms\Components\Group::make()->schema([
                    Forms\Components\Toggle::make('is_visible')
                        ->required()->default(true),
                    Forms\Components\FileUpload::make("image"),
                    Repeater::make("seo")->label("SEO")->schema([
                        TextInput::make('seo_title')->label("Title")->nullable(),
                        TextInput::make('seo_description')->label("Description")->nullable(),
                        TextInput::make('seo_keywords')->label("Keyword")->nullable(),
                    ])->maxItems(1)->addable(true)->reorderable(false)->deletable(false),


                ])->columnSpan(['lg' => 1]),


            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('Parent.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            RelationManagers\ProductRelationManager::class,
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListShopCategories::route('/'),
            'create' => Pages\CreateShopCategory::route('/create'),
            'edit' => Pages\EditShopCategory::route('/{record}/edit'),
        ];
    }
}
