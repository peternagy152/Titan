<?php

namespace App\PageBuilders\Factories;

use App\PageBuilders\PageBuilderSchemaFactoryInterface;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;

class ContactUsSchemaBuilder implements PageBuilderSchemaFactoryInterface
{
    function getSchema(): array
    {
        return [
            Repeater::make("contact-us")->schema([
                FileUpload::make('icon')
                    ->image()->directory('pages')->downloadable()
                    ->openable()->visibility('public')->multiple() ,
                TextInput::make("title"),
                TextInput::make("subtitle"),
            ])

        ];
    }

}
