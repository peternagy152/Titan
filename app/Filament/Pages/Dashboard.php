<?php

namespace App\Filament\Pages;

use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Grid;
use Filament\Forms\Components\Section;
use Filament\Forms\Form;
use Filament\Pages\Dashboard\Concerns\HasFiltersForm;
use Filament\Forms\Get;

class Dashboard extends \Filament\Pages\Dashboard
{
    use HasFiltersForm ;
    public function filtersForm(Form $form): Form
    {
        return $form->schema([
            Section::make(" ")->schema([
                Grid::make()->schema([
                    DatePicker::make('startDate')
                        ->maxDate(fn (Get $get) => $get('endDate') ?: now())
                        ->native(false),
                    DatePicker::make('endDate')
                        ->minDate(fn (Get $get) => $get('startDate') ?: now())
                        ->maxDate(now())->native(false),
                ]),

            ]),

        ]);
    }
}
