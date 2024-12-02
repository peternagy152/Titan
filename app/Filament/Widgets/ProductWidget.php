<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\ProductResource;
use Filament\Tables;
use Filament\Tables\Columns\ImageColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;

class ProductWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(ProductResource::getEloquentQuery()->orderBy('total_sales', 'desc'))
            ->paginated([5, 10])
            ->columns([
                ImageColumn::make('image')
                    ->label(' ')
                    ->defaultImageUrl((asset('images/user.png')))
                    ->circular(),
                Tables\Columns\TextColumn::make('name')->label('Product Name'),
                Tables\Columns\TextColumn::make('price')->label('Price')->money('EGP'),
                Tables\Columns\TextColumn::make('total_sales')->label('Sales'),
            ]);
    }
}
