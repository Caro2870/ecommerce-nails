<x-filament-panels::page>
    <div class="space-y-6">
        {{ $this->form }}

        <div>
            <x-filament::button wire:click="save">
                Guardar cambios
            </x-filament::button>
        </div>
    </div>
</x-filament-panels::page>
