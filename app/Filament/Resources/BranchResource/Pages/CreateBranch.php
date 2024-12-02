<?php

namespace App\Filament\Resources\BranchResource\Pages;

use App\Filament\Resources\BranchResource;
use App\Models\Product;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Support\Facades\DB;

class CreateBranch extends CreateRecord
{
    protected static string $resource = BranchResource::class;
    protected static ?string $title = 'New Branch';

    protected function getFormActions() : array{
        return [
            $this->getCreateFormAction(),
            $this->getCancelFormAction()
        ];
    }

    protected function afterCreate() : void {
        // Get the newly created branch
        $branch = $this->record;

        // Fetch all product IDs
        $products = Product::all('id');

        // Prepare data for batch insert
        $data = $products->map(function ($product) use ($branch) {
            return [
                'branch_id' => $branch->id,
                'product_id' => $product->id,
                'is_available' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        })->toArray();

        // Insert all products into branch_products table with is_available=true
        DB::table('branch_products')->insert($data);
    }
}
