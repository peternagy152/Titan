<?php

namespace App\Filament\Resources\BranchProductsResource\Pages;

use App\Filament\Resources\BranchProductsResource;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Columns\TextColumn;
use Illuminate\Database\Eloquent\Builder;
use App\Models\Branch;
use App\Models\Order;
// use Filament\Forms\Components\Actions\Action;
use Filament\Tables\Actions\Action;


class StockController extends Page implements Tables\Contracts\HasTable
{
    use Tables\Concerns\InteractsWithTable;

    protected static string $resource = BranchProductsResource::class;
    protected static ?string $title = "Stock Controller";

    protected static string $view = 'filament.resources.branch-products-resource.pages.stock-controller';

    protected function getTableQuery(): Builder
    {
        // Fetch branches and aggregate order data
        return Branch::query()
            ->withCount([
                'orders',  // Total orders
                'orders as completed_orders_count' => function (Builder $query) {
                    $query->where('status', 'completed');  // Completed orders
                },
                'orders as cancelled_orders_count' => function (Builder $query) {
                    $query->where('status', 'cancelled');  // Cancelled orders
                },
                'orders as cancellation_ratio' => function (Builder $query) {
                    $query->where('status', 'cancelled')->where('status','completed');  // Cancelled orders
                }
            ]);
    }

    protected function getTableColumns(): array
    {
        return [
            TextColumn::make('id')->label('#'),
            TextColumn::make('name')->label('Branch Name'),
            TextColumn::make('orders_count')->label('Orders Number')->sortable(),
            TextColumn::make('completed_orders_count')->label('Completed Orders')->sortable(),
            TextColumn::make('cancelled_orders_count')->label('Cancelled Orders')->sortable(),
            TextColumn::make('cancellation_ratio')
                ->label('Cancellation Ratio')
                ->formatStateUsing(fn ($record): ?string => 
                    $record->orders_count > 0 
                        ? number_format(($record->cancelled_orders_count / $record->orders_count) * 100, 2) . '%' 
                        : '0%'
                ),
        ];
    }

    protected function getTableActions(): array
    {
        return [
            Action::make('edit')
                ->label('Manage')
                ->icon('heroicon-o-pencil')
                ->url(fn ($record) => 'branch-products/'.$record->id.'/manage?tableFilters[branch_id][value]='.$record->id)
                ->color('primary')
        ];
    }
}
