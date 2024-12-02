<?php

namespace App\Filament\Resources\BranchProductsResource\Pages;

use App\Filament\Resources\BranchProductsResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditBranchProducts extends EditRecord
{
    protected static string $resource = BranchProductsResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
