<?php

namespace App\Filament\Resources;

use App\Filament\Resources\ProductResource\Pages;
use App\Filament\Resources\ProductResource\RelationManagers;
use App\Models\Product;
use App\Models\ShopCategory;
use Filament\Forms;
use Filament\Forms\Components\CheckboxList;
use Filament\Forms\Components\Radio;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Forms\Get;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Illuminate\Support\Str;
use Filament\Forms\Components\FileUpload;
use Filament\Forms\Components\Tabs;
use Filament\Resources\Concerns\Translatable;

class ProductResource extends Resource
{
    protected static ?string $model = Product::class;

    protected static ?string $navigationIcon = 'heroicon-o-squares-2x2';
    protected static ?string $navigationGroup = 'Store';
    protected static ?int $navigationSort = 2;
    use Translatable;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Group::make()->schema([
                    Forms\Components\Section::make("Product Basic Information")->schema([
                        Forms\Components\TextInput::make('name')->label("Product Name")
                            ->required()
                            ->maxLength(255)
                            ->live(onBlur: true)
                            ->afterStateUpdated(fn(string $operation, $state, Forms\Set $set) => $operation === 'create' ? $set('slug', Str::slug($state)) : null),

                        Forms\Components\TextInput::make('slug')
                            ->disabled()
                            ->dehydrated()
                            ->required()
                            ->maxLength(255)
                            ->unique(Product::class, 'slug', ignoreRecord: true),
                        Forms\Components\TextInput::make('sku')
                            ->label('SKU')
                            ->required()
                            ->maxLength(255)
                            ->unique(Product::class, 'sku', ignoreRecord: true),
                        Forms\Components\Select::make('categories')
                            ->relationship('ShopCategory', 'name')
                            ->preload()
                            ->multiple(),

                        Forms\Components\Select::make('type')
                            ->required()
                            ->options([
                                "simple" => "Simple Product",
                                "variable" => "Variable Product",
                            ])
                            ->default('simple'),
                    ]),
                    Forms\Components\Section::make("Content")->schema([
                        Forms\Components\Textarea::make('short_description')->label("Short Description")
                            ->columnSpanFull(),
                        Forms\Components\MarkdownEditor::make('description')->label("Full Description")
                            ->columnSpanFull(),

                    ]),
                    Forms\Components\Section::make("Product Images")->schema([

                        Forms\Components\FileUpload::make("image")->label("Thumbnail Image")->downloadable()->directory("products")->openable()->visibility('public'),
                        Forms\Components\FileUpload::make("gallery")->label("Gallery Images")->downloadable()->directory("products")->openable()->visibility('public')->multiple()->reorderable(),

                    ]),

                    Forms\Components\Section::make("Pricing")->schema([
                        Forms\Components\Grid::make()->schema([
                            Forms\Components\TextInput::make('price')
                                ->required()
                                ->numeric()
                                ->prefix('EGP'),
                            Forms\Components\TextInput::make('sale_price')
                                ->numeric()

                                ->rule(function (\Filament\Forms\Get $get) {
                                    return function ($attribute, $value, $fail) use ($get) {
                                        if ($value >= $get('price')) {
                                            $fail('The sale price must be lower than the regular price.');
                                        }
                                    };
                                })
                        ]),

                    ]),

                    Forms\Components\Section::make("Inventory")->schema([
                        Forms\Components\Checkbox::make('in_stock'),


                        Forms\Components\Toggle::make('manage_stock')
                            ->required()->default(false)->live(true),

                        Forms\Components\Grid::make()
                            ->hidden(fn(Get $get): bool => ! $get('manage_stock'))
                            ->schema([
                                Forms\Components\TextInput::make('stock_qtn')->label("Stock Qtn")
                                    ->required()
                                    ->numeric()

                                    ->default(0),
                                Forms\Components\TextInput::make('backorder_limit')->label("Backorder Limit")
                                    ->required()
                                    ->numeric()
                                    ->default(0),
                            ]),

                    ]),


                ])->columnSpan(["lg" => 2]),

                Forms\Components\Group::make()->schema([
                    Forms\Components\Toggle::make('is_visible')->required()->default(true),
                    Forms\Components\Section::make("Insights")->schema([
                        Forms\Components\Placeholder::make('created_at')
                            ->label('Created at')
                            ->content(fn(Product $record): ?string => $record->created_at?->diffForHumans()),

                        Forms\Components\Placeholder::make('updated_at')
                            ->label('Last modified at')
                            ->content(fn(Product $record): ?string => $record->updated_at?->diffForHumans()),
                        Forms\Components\Placeholder::make('total_sales')->content(fn(Product $record): ?string => $record->total_sales),
                    ])->hidden(fn(?Product $record) => $record === null),

                    Tabs::make("seo_tabs")->tabs([
                        Tabs\Tab::make("General")->schema([
                            TextInput::make('meta_title')->label("Page Title")->nullable(),
                            TextInput::make('meta_description')->label("Description")->nullable(),
                        ]),
                        Tabs\Tab::make("OG")->schema([
                            TextInput::make('og_title')->label(" OG Meta Title")->nullable(),
                            TextInput::make('og_description')->label("OG Meta Description")->nullable(),
                            FileUpload::make('og_image')->downloadable()->directory("products")->openable()->visibility('public'),
                        ]),
                        Tabs\Tab::make("Twitter")->schema([
                            TextInput::make('twitter_title')->nullable(),
                            TextInput::make('twitter_description')->nullable(),
                            FileUpload::make('twitter_image')->downloadable()->directory("products")->openable()->visibility('public')->nullable(),
                        ]),
                        Tabs\Tab::make("Facebook")->schema([

                            TextInput::make('facebook_title')->nullable(),
                            TextInput::make('facebook_description')->nullable(),
                            FileUpload::make('facebook_image')->downloadable()->directory("products")->openable()->visibility('public')->nullable(),
                        ]),


                    ]),



                ])->columnSpan(["lg" => 1]),


            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        $productCats = ShopCategory::select("name")->get();
        return $table
            ->paginated([10, 20, 50, 100, 200])
            ->columns([
                ImageColumn::make('image')
                    ->label(" ")
                    ->defaultImageUrl((asset('images/user.png')))
                    ->circular(),
                Tables\Columns\TextColumn::make('sku')
                    ->label('SKU')
                    ->searchable(),

                Tables\Columns\TextColumn::make('name')->label("Product Name")
                    ->searchable(),
                Tables\Columns\TextColumn::make('ShopCategory.name')->label("Product Category"),

                //                Tables\Columns\TextColumn::make('type')
                //                    ->searchable(),
                Tables\Columns\IconColumn::make('is_visible')
                    ->boolean(),
                Tables\Columns\TextColumn::make('price')
                    ->money("EGP")
                    ->sortable(),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime("M d ,Y")
                    ->sortable(),
            ])
            ->filters([
                SelectFilter::make('categories')->relationship("ShopCategory", "name")
                    ->multiple()->preload(),
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

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListProducts::route('/'),
            'create' => Pages\CreateProduct::route('/create'),
            'edit' => Pages\EditProduct::route('/{record}/edit'),
        ];
    }
}
