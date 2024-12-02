<?php

namespace App\Filament\Widgets;

use App\Filament\Resources\OrderResource;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;
use Filament\Widgets\TableWidget as BaseWidget;
use Predis\Pipeline\FireAndForget;

class OrderWidget extends BaseWidget
{
    public function table(Table $table): Table
    {
        return $table
            ->query(OrderResource::getEloquentQuery()->orderBy('created_at', 'desc'))
            ->paginated([5,10])
            ->columns([
                TextColumn::make('user.name')->label("First Name"),
                TextColumn::make('user.email')->label("Email"),
                TextColumn::make('total_amount'),
                TextColumn::make('status')
                    ->badge()
                    ->color(function(string $state): string{
                        return match ($state){
                            'processing' => 'info',
                            'shipped' => 'primary',
                            'completed' => 'success',
                            'cancelled' => 'danger',
                            'refunded' => 'gray',
                            'declined' => 'warning',
                        };
                    })
            ]);
    }
}
