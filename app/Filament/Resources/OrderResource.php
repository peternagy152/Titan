<?php

namespace App\Filament\Resources;

use App\Filament\Resources\OrderResource\Pages;
use App\Filament\Resources\OrderResource\RelationManagers\OrderItemsRelationManager;
use App\Models\Order;
use Filament\Forms\Components\DatePicker;
use Filament\Forms\Components\Group;
use Filament\Forms\Components\MarkdownEditor;
use Filament\Forms\Components\Placeholder;
use Filament\Forms\Components\Section;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Components\Toggle;
use Filament\Forms\Form;
use Illuminate\Database\Eloquent\Collection;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\BulkAction;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Columns\ToggleColumn;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Filters\TernaryFilter;
use Filament\Tables\Table;

class OrderResource extends Resource
{
    protected static ?string $model = Order::class;

    protected static ?string $navigationIcon = 'heroicon-o-shopping-cart';
    protected static ?string $navigationGroup = 'Store';
    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Section::make('Basic Data')->schema([
                    Placeholder::make('id')
                        ->label('Order Number')
                        ->content(fn($record): ?string => $record->id),
                    Placeholder::make('created_at')
                        ->label('Created At')
                        ->content(fn($record): ?string => $record->created_at),
                    Placeholder::make('total_amount')
                        ->label('Total')
                        ->content(fn($record): ?string => number_format($record->total_amount,2)),
                    Placeholder::make('user_id')
                        ->label('Customer')
                        ->content(fn($record): ?string => $record->user->name),
                    Placeholder::make('address_id')
                        ->label('Address')
                        ->content(fn($record): ?string => $record->address->country->name . ', ' . $record->address->city->name . ', ' . $record->address->area->name . ", " . $record->address->street),
                    Placeholder::make('shipping_method_id')
                        ->label('Shipping Method')
                        ->content(fn($record): ?string => $record->paymentMethod->name),
                    Select::make('status')
                        ->options([
                            'processing' => 'Processing',
                            'shipped'    => 'Shipped',
                            'completed'  => 'Completed',
                            'cancelled'  => 'Cancelled',
                            'refunded'   => 'Refunded',
                            'declined'   => 'Declined',
                        ])
                        ->label('Status')
                        ->required(),
                    Placeholder::make('coupon_id')
                        ->label('Coupon')
                        ->content(fn($record): ?string => $record->coupon->code),
                    MarkdownEditor::make('notes')->columnSpanFull(),
                ])->columnSpan(2)->columns(3),

                Group::make()->schema([
                    Section::make('Insights')->schema([
                        Placeholder::make('order_items')
                            ->label('Items Count')
                            ->content(fn($record): ?string => $record->orderItems()->sum('quantity')),
                    ])->collapsible(),
    
                    Section::make('Gift Section')->schema([
                        Toggle::make('is_gift')
                            ->columnSpanFull()
                            ->reactive(),
                        TextInput::make('gift_recipient_name')
                            ->disabled(fn ($get) => !$get('is_gift'))
                            ->required(fn ($get) => $get('is_gift')),
                        TextInput::make('gift_recipient_address')
                            ->disabled(fn ($get) => !$get('is_gift'))
                            ->required(fn ($get) => $get('is_gift')),
                    ])->collapsible()
                ])->columnSpan(1),
            ])->columns(3);
    }

    public static function table(Table $table): Table
    {
        return $table
        ->columns([
                TextColumn::make('id')
                    ->toggleable()
                    ->label('Order NO.')
                    ->sortable(),
                TextColumn::make('user.name')
                    ->toggleable()
                    ->label('Customer')
                    ->sortable()
                    ->searchable(),
                TextColumn::make('user.email')
                    ->toggleable()
                    ->label('Email')
                    ->sortable(),
                TextColumn::make('total_amount')
                    ->toggleable()
                    ->label('Total')
                    ->sortable()
                    ->formatStateUsing(fn ($state) => number_format($state, 2)),
                TextColumn::make('status')
                    ->toggleable()
                    ->badge()
                    ->color(function(string $state): string{
                        return match ($state){
                            'processing' => 'info',
                            'shipped' => 'primary',
                            'completed' => 'success',
                            'cancelled' => 'danger',
                            'refunded' => 'gray',
                            'declined' => 'warning',
                        };
                    })
                    ->sortable(),
                ToggleColumn::make('is_gift')
                    ->disabled()
                    ->label('Is Gift')
                    ->toggleable()
                    ->sortable(),
                TextColumn::make('created_at')
                    ->date()
                    ->label('Created At')
                    ->toggleable()
                    ->sortable(),
            ])->paginated([25,50,75,100])
            ->filters([
                SelectFilter::make('status')
                    ->options([
                            'processing' => 'Processing',
                            'shipped' => 'Shipped',
                            'completed' => 'Completed',
                            'cancelled' => 'Cancelled',
                            'refunded' => 'Refunded',
                            'declined' => 'Declined',
                        ])
                    ->label('Status')
                    ->multiple(),
                    TernaryFilter::make('is_gift')
            ])
            ->actions([
                Tables\Actions\EditAction::make()->iconButton(),
                Tables\Actions\ViewAction::make()->iconButton(),
            ])
            ->bulkActions([
                BulkAction::make('Change Status')
                    ->action(function (Collection $records, array $data) {
                        $status = $data['status']; // Extract the selected status from the form data

                        foreach ($records as $record) {
                            $record->update(['status' => $status]); // Update the status for each record
                        }
                    })->form([
                        Select::make('status')
                            ->options([
                                'processing' => 'Processing',
                                'shipped' => 'Shipped',
                                'completed' => 'Completed',
                                'cancelled' => 'Cancelled',
                                'refunded' => 'Refunded',
                                'declined' => 'Declined',
                            ])
                            ->required()
                            ->label('New Status'),
                    ]),
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            OrderItemsRelationManager::class
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListOrders::route('/'),
            // 'create' => Pages\CreateOrder::route('/create'),
            'edit' => Pages\EditOrder::route('/{record}/edit'),
        ];
    }
}
