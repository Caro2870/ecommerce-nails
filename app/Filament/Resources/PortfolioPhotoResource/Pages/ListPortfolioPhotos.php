<?php

namespace App\Filament\Resources\PortfolioPhotoResource\Pages;

use App\Filament\Resources\PortfolioPhotoResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPortfolioPhotos extends ListRecords
{
    protected static string $resource = PortfolioPhotoResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
