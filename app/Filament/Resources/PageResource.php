<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PageResource\Pages;
use App\Filament\Resources\PageResource\RelationManagers;
use App\Models\Page;
use App\PageBuilders\PageBuilderSchemaFactory;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Forms\Set;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Textarea;
use Filament\Forms\Components\Repeater;
use Filament\Forms\Components\Group;
use Filament\Resources\Concerns\Translatable;
use Illuminate\Support\Str;

class PageResource extends Resource
{
    use Translatable;
    protected static ?string $model = Page::class;

    protected static ?string $navigationIcon = 'heroicon-o-document-duplicate';
    protected static ?string $navigationGroup = 'Content';

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    TextInput::make('title')
                        ->required(),
//                        ->afterStateUpdated(fn (Set $set, ?string $state) => $set('slug', Str::slug($state))) ,
                    Forms\Components\TextInput::make('slug')
                        ->required()
                        ->maxLength(255),
                    Forms\Components\MarkdownEditor::make('content')
                        ->required()
                        ->columnSpanFull(),
                    Repeater::make('extra_fields')->label("Page Content")
                        ->schema(fn (callable $get) => PageBuilderSchemaFactory::create($get('slug') ?? "default")->getSchema())
                    ->maxItems(1)->addable(true)->reorderable(false)->deletable(false),
                ])->columnSpan(['lg'=>2]),
                Group::make()->schema([
                    Repeater::make("seo")->schema([
                        TextInput::make('seo_title')->nullable(),
                        TextInput::make('seo_description')->nullable(),
                        TextInput::make('seo_keywords')->nullable(),
                    ]) ->maxItems(1) ->addable(true)->reorderable(false)->deletable(false) ,
                ])->columnSpan(['lg'=>1]),



            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('slug')
                    ->searchable(),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPages::route('/'),
            'create' => Pages\CreatePage::route('/create'),
            'edit' => Pages\EditPage::route('/{record}/edit'),
        ];
    }
}
