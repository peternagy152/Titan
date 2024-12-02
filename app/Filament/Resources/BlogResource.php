<?php
namespace App\Filament\Resources;

use App\Filament\Resources\BlogResource\Pages;
use App\Models\Blog;
use Filament\Forms;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Set;
use Filament\Resources\Concerns\Translatable;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class BlogResource extends Resource
{
    use Translatable;

    protected static ?string $model = Blog::class;
    protected static ?string $navigationIcon = 'heroicon-o-newspaper';
    protected static ?string $navigationGroup = 'Content';

    public static function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Group::make()->schema([
                    TextInput::make('title')
                        ->live()
                        ->afterStateUpdated(function (Set $set, ?string $state) {
                            $set('slug', Str::slug($state));
                        }),
                    TextInput::make('slug')
                        ->required()
                        ->maxLength(255)
                        ->unique(Blog::class, 'slug', ignoreRecord: true),
                    Forms\Components\RichEditor::make('content')
                        ->columnSpanFull(),
                    Forms\Components\RichEditor::make('desc')
                        ->columnSpanFull(),
                ])->columnSpan(['lg' => 2]),

                Group::make()->schema([
                    Forms\Components\Toggle::make('is_published')
                        ->required()
                        ->reactive(),
                    Forms\Components\Toggle::make('is_scheduled')
                        ->required()
                        ->reactive(),
                    Forms\Components\DateTimePicker::make('scheduled_publish_date')
                        ->label('Scheduled Publish Date')
                        ->nullable()
                        ->requiredWith('is_scheduled')
                        ->minDate(now()),
                    Forms\Components\FileUpload::make('featured_image')
                        ->image()->directory('blogs')->downloadable()
                        ->openable()->visibility('public'),
                    Forms\Components\TextInput::make('seo_title')
                        ->label('SEO Title')
                        ->nullable(),
                    Forms\Components\Textarea::make('seo_description')
                        ->label('SEO Description')
                        ->nullable(),
                    Forms\Components\TextInput::make('seo_keywords')
                        ->label('SEO Keywords')
                        ->nullable(),
                ])->columnSpan(['lg' => 1]),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\ImageColumn::make('featured_image'),
                Tables\Columns\TextColumn::make('title')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_published')
                    ->boolean(),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable(),
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
            'index' => Pages\ListBlogs::route('/'),
            'create' => Pages\CreateBlog::route('/create'),
            'edit' => Pages\EditBlog::route('/{record}/edit'),
        ];
    }
}
