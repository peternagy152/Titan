<?php
namespace App\PageBuilders\Factories;

use App\PageBuilders\PageBuilderSchemaFactoryInterface;
use Filament\Forms\Components\TextInput;

class DefaultPageBuilderSchemaFactory implements PageBuilderSchemaFactoryInterface
{
    public function getSchema(): array
    {
        return [
            TextInput::make('title'),
            TextInput::make('content'),
        ];
    }
}
