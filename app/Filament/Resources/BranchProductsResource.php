<?php

namespace App\Filament\Resources;

use App\Filament\Resources\BranchProductsResource\Pages;
use App\Filament\Resources\BranchProductsResource\RelationManagers;
use App\Models\BranchProducts;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class BranchProductsResource extends Resource
{
    protected static ?string $model = BranchProducts::class;
    protected static ?string $navigationIcon = 'heroicon-o-archive-box-x-mark';
    protected static ?string $navigationLabel = "Stock Controller";
    protected static ?string $navigationGroup = 'Settings';
    protected static ?int $navigationSort = 3 ;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Select::make('branch_id')
                    ->relationship('branch', 'name')
                    ->required(),
    
                Select::make('product_id')
                    ->relationship('product', 'name')
                    ->required(),
    
                Toggle::make('is_available')
                    ->label('Available')
                    ->default(true),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('branch.name')
                    ->label('Branch')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('product.name')
                    ->label('Product')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('product.ShopCategory.name')
                    ->label('Category')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('product.sku')
                    ->label('SKU')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('product.price')
                    ->label('Price')
                    ->sortable()
                    ->money("EGP")
                    ->searchable(),
                ToggleColumn::make('is_available')
                    ->label('Availability'),
            ])
            ->filters([
                SelectFilter::make('branch_id')
                    ->relationship('branch','name'),
            ])
            ->actions([
                // Tables\Actions\EditAction::make(),
            ])
            ->paginated([100,125,150,175,200])
            ->bulkActions([
                // Tables\Actions\BulkActionGroup::make([
                //     Tables\Actions\DeleteBulkAction::make(),
                // ]),
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
            'index' => Pages\StockController::route('/'),
            'manage' => Pages\ListBranchProducts::route('/{record}/manage'),
            'create' => Pages\CreateBranchProducts::route('/create'),
            // 'edit' => Pages\EditBranchProducts::route('/{record}/edit'),
        ];
    }
}
