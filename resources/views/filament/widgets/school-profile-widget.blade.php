<x-filament-widgets::widget>
    <x-filament::section heading="Profil Sekolah" heading-class="text-xl font-bold"
        icon="heroicon-o-academic-cap" icon-color="text-primary-500" icon-size="h-6 w-6" class="!p-6">
        <div class="space-y-5">
            <!-- Data -->
            @foreach ($data as $label => $value)
                <div class="flex items-start gap-4 mb-5">
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">{{ $label }}</p>
                        <p class="text-base font-medium text-gray-900 dark:text-white">{{ $value }}</p>
                    </div>
                </div>
            @endforeach
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
