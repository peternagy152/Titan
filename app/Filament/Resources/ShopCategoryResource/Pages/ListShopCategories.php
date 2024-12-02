<?php

namespace App\Filament\Resources\ShopCategoryResource\Pages;

use App\Filament\Resources\ShopCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListShopCategories extends ListRecords
{
    protected static string $resource = ShopCategoryResource::class;

    use ListRecords\Concerns\Translatable;
    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Actions\LocaleSwitcher::make(),
        ];
    }
}
