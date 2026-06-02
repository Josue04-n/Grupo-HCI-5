<x-filament-panels::page>
    <x-filament::section>
        @if($feedbackMessage)
            <div class="mb-4 rounded-lg border px-4 py-3 text-sm @if($feedbackType === 'success') border-success-500/30 bg-success-500/10 text-success-700 dark:text-success-400 @elseif($feedbackType === 'warning') border-warning-500/30 bg-warning-500/10 text-warning-700 dark:text-warning-400 @elseif($feedbackType === 'danger') border-danger-500/30 bg-danger-500/10 text-danger-700 dark:text-danger-400 @else border-gray-500/30 bg-gray-500/10 text-gray-700 dark:text-gray-300 @endif">
                {{ $feedbackMessage }}
            </div>
        @endif

        <form wire:submit="generate">
            {{ $this->form }}
            
            <div class="mt-4 flex justify-end">
                <x-filament::button 
                    type="submit" 
                    icon="heroicon-m-sparkles"
                    wire:loading.attr="disabled"
                    wire:target="generate"
                >
                    <span wire:loading.remove wire:target="generate">Generar Backlog Global con IA</span>
                    <span wire:loading wire:target="generate">Analizando datos...</span>
                </x-filament::button>
            </div>
        </form>
    </x-filament::section>

    @if($backlogContent)
        <x-filament::section class="mt-6">
            <x-slot name="heading">
                Borrador del Sprint Backlog
            </x-slot>

            <x-slot name="headerEnd">
                <div class="flex gap-2">
                    <x-filament::button 
                        color="gray" 
                        icon="heroicon-m-document-arrow-down"
                        wire:click="exportMd"
                    >
                        Exportar .MD
                    </x-filament::button>
                    
                    <x-filament::button 
                        color="danger" 
                        icon="heroicon-m-document-text"
                        wire:click="exportPdf"
                    >
                        Exportar .PDF
                    </x-filament::button>
                </div>
            </x-slot>

            {{ $this->backlogForm }}
        </x-filament::section>
    @endif
</x-filament-panels::page>
