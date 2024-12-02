<?php
// app/PageBuilders/PageBuilderSchemaFactory.php
namespace App\PageBuilders;

use App\PageBuilders\Factories\ContactUsSchemaBuilder;
use App\PageBuilders\Factories\EducationPageBuilderSchemaFactory;
use App\PageBuilders\Factories\DefaultPageBuilderSchemaFactory;

class PageBuilderSchemaFactory
{
    public static function create(string $slug): PageBuilderSchemaFactoryInterface
    {
        switch ($slug) {
            case 'education':
                return new EducationPageBuilderSchemaFactory();
            case 'contact-us':
                return new ContactUsSchemaBuilder();
            default:
                return new DefaultPageBuilderSchemaFactory();
        }
    }
}
