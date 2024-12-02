<?php

namespace App\Filament\Resources\BranchProductsResource\Pages;

use App\Filament\Resources\BranchProductsResource;
use App\Models\Branch;
use Filament\Actions;
use Filament\Actions\Action;
use Filament\Resources\Pages\ListRecords;
use Filament\Resources\Pages\Page;
use Illuminate\Database\Eloquent\Builder;

class ListBranchProducts extends ListRecords
{
    protected static string $resource = BranchProductsResource::class;

    protected static ?string $title = 'Stock Controller';
    public $record;

    // Override mount without parameters to maintain compatibility
    public function mount(): void
    {
        // Use route parameter handling here if needed
        $this->record = request()->route('record');
    }
    
    protected function getHeaderActions(): array
    {
        return [
            Action::make('back')
                ->label('All Branches')
                ->url('/admin/branch-products') // Use route name and parameter
                ->color('primary') // Optional: You can customize the button color
            // Actions\CreateAction::make(),
        ];
    }
}
