<?php

namespace App\Filament\Resources\ShopCategoryResource\Pages;

use App\Filament\Resources\ShopCategoryResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;

class CreateShopCategory extends CreateRecord
{
    protected static string $resource = ShopCategoryResource::class;
    use CreateRecord\Concerns\Translatable;

    protected function getHeaderActions(): array
    {
        return [
            Actions\LocaleSwitcher::make(),
        ];
    }
}
