<?php

namespace App\Filament\Resources;

use App\Filament\Resources\PortfolioPhotoResource\Pages;
use App\Models\Category;
use App\Models\PortfolioPhoto;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Support\Str;

class PortfolioPhotoResource extends Resource
{
    protected static ?string $model = PortfolioPhoto::class;

    protected static ?string $navigationIcon = 'heroicon-o-photo';

    protected static ?string $navigationLabel = 'Fotos';

    protected static ?string $modelLabel = 'Foto';

    protected static ?string $pluralModelLabel = 'Fotos';

    protected static ?string $navigationGroup = 'Administracion';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\FileUpload::make('image_path')
                    ->label('Imagen')
                    ->disk('public')
                    ->directory('portfolio')
                    ->image()
                    ->imageEditor()
                    ->required()
                    ->maxSize(8192)
                    ->getUploadedFileNameForStorageUsing(function ($file): string {
                        $extension = $file->getClientOriginalExtension();

                        return Str::uuid().($extension ? '.'.$extension : '');
                    }),
                Forms\Components\Select::make('category_id')
                    ->label('Categoria')
                    ->options(fn () => Category::query()->orderBy('sort_order')->pluck('name', 'id')->all())
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\TextInput::make('caption')
                    ->label('Descripcion')
                    ->maxLength(140),
                Forms\Components\TextInput::make('tags')
                    ->label('Tags')
                    ->helperText('Ej: acrilico, gel, french')
                    ->maxLength(255),
                Forms\Components\Toggle::make('is_featured')
                    ->label('Destacada')
                    ->default(false),
                Forms\Components\TextInput::make('sort_order')
                    ->label('Orden')
                    ->numeric()
                    ->required()
                    ->default(0),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->defaultSort('sort_order')
            ->reorderable('sort_order')
            ->columns([
                Tables\Columns\ImageColumn::make('image_path')
                    ->label('Foto')
                    ->disk('public')
                    ->square(),
                Tables\Columns\TextColumn::make('category.name')
                    ->label('Categoria')
                    ->sortable(),
                Tables\Columns\TextColumn::make('caption')
                    ->label('Descripcion')
                    ->searchable()
                    ->limit(40),
                Tables\Columns\TextColumn::make('tags')
                    ->label('Tags')
                    ->searchable()
                    ->limit(35),
                Tables\Columns\IconColumn::make('is_featured')
                    ->label('Destacada')
                    ->boolean(),
                Tables\Columns\TextColumn::make('sort_order')
                    ->label('Orden')
                    ->sortable(),
                Tables\Columns\TextColumn::make('created_at')
                    ->label('Creada')
                    ->dateTime('d/m/Y H:i')
                    ->sortable(),
            ])
            ->filters([
                Tables\Filters\SelectFilter::make('category_id')
                    ->label('Categoria')
                    ->options(fn () => Category::query()->orderBy('sort_order')->pluck('name', 'id')->all()),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPortfolioPhotos::route('/'),
            'create' => Pages\CreatePortfolioPhoto::route('/create'),
            'edit' => Pages\EditPortfolioPhoto::route('/{record}/edit'),
        ];
    }
}
