<?php
namespace App\PageBuilders\Factories;

use App\PageBuilders\PageBuilderSchemaFactoryInterface;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\FileUpload;


class EducationPageBuilderSchemaFactory implements PageBuilderSchemaFactoryInterface
{
    public function getSchema(): array
    {
        return [
            Repeater::make('hero')->schema([
                FileUpload::make('image_1')
                    ->image()->directory('pages')->downloadable()
                    ->openable()->visibility('public')->multiple(),
                FileUpload::make('image_2')
                    ->image()->directory('pages')->downloadable()
                    ->openable()->visibility('public')->multiple(),
                TextInput::make('title'),
                Textarea::make("description"),
            ])
            ->addable(true)->reorderable(false)->deletable(false)->maxItems(1),
            Repeater::make("info")->schema([
                FileUpload::make('image')
                    ->image()->directory('pages')->downloadable()
                    ->openable()->visibility('public')->multiple(),
                TextInput::make('title'),
                Textarea::make("subtitle")
            ]),
        ];
    }
}
