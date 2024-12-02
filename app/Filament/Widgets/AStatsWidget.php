<?php

namespace App\Filament\Widgets;


use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Carbon\Carbon;
use Filament\Forms\Components\DatePicker;
use Filament\Support\Enums\IconPosition;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;
use Filament\Widgets\Concerns\InteractsWithPageFilters;
use Illuminate\Support\Number;

class AStatsWidget extends BaseWidget
{
    use InteractsWithPageFilters;
    protected function getStats(): array
    {
        $startDate = ! is_null($this->filters['startDate'] ?? null) ?
            Carbon::parse($this->filters['startDate']) :
            null;

        $endDate = ! is_null($this->filters['endDate'] ?? null) ?
            Carbon::parse($this->filters['endDate']) :
            now();


        return [
            Stat::make(" Revenue" , number_format(Order::where('status', 'completed')->sum('total_amount') ) . " EGP")
                ->description("Total Revenue")
                ->descriptionIcon("heroicon-o-globe-europe-africa" , IconPosition::Before)
                ->color("success"),

            Stat::make(" Orders" , Order::count())
                ->description("Total Number Of Orders")
                ->descriptionIcon("heroicon-o-globe-europe-africa" , IconPosition::Before)
                ->color("primary"),

            Stat::make(" Products" , Product::count())
                ->description("Total Number Of Products")
                ->descriptionIcon("heroicon-o-globe-europe-africa" , IconPosition::Before)
                ->color("success"),


            Stat::make(" Customers" , User::count())
                ->description("Total Number Of Customers")
                ->descriptionIcon("heroicon-o-globe-europe-africa" , IconPosition::Before)
                ->color("info") ,
        ];
    }
}
