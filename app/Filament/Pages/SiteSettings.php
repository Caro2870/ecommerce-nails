<?php

namespace App\Filament\Pages;

use App\Models\SiteSetting;
use Filament\Forms;
use Filament\Forms\Concerns\InteractsWithForms;
use Filament\Forms\Contracts\HasForms;
use Filament\Notifications\Notification;
use Filament\Pages\Page;

class SiteSettings extends Page implements HasForms
{
    use InteractsWithForms;

    protected static ?string $navigationIcon = 'heroicon-o-cog-6-tooth';

    protected static ?string $navigationLabel = 'Configuracion';

    protected static ?string $title = 'Configuracion del sitio';

    protected static ?string $navigationGroup = 'Administracion';

    protected static ?int $navigationSort = 90;

    protected static string $view = 'filament.pages.site-settings';

    public ?array $data = [];

    public function mount(): void
    {
        $this->form->fill([
            'site_name' => site_setting('site_name', 'Jessica Nails Studio'),
            'whatsapp_number' => site_setting('whatsapp_number', '920236307'),
            'address' => site_setting('address', 'Lima, Perú'),
        ]);
    }

    public function form(Forms\Form $form): Forms\Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('site_name')
                    ->label('Nombre del estudio')
                    ->required()
                    ->maxLength(120),
                Forms\Components\TextInput::make('whatsapp_number')
                    ->label('Numero de WhatsApp')
                    ->required()
                    ->helperText('Ejemplo: 920236307')
                    ->maxLength(20),
                Forms\Components\TextInput::make('address')
                    ->label('Direccion')
                    ->maxLength(140),
            ])
            ->statePath('data');
    }

    public function save(): void
    {
        $state = $this->form->getState();

        foreach ($state as $key => $value) {
            SiteSetting::query()->updateOrCreate(
                ['key' => $key],
                ['value' => $value],
            );
        }

        Notification::make()
            ->title('Configuracion actualizada')
            ->success()
            ->send();
    }
}
