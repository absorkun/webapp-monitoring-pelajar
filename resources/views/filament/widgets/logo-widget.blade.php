<x-filament-widgets::widget>
    <x-filament::section>
        <div
            class="flex flex-col md:flex-row justify-between items-start md:items-center gap-4 p-4 shadow-md rounded-xl">
            <div class="shrink-0">
                {{ view('components.brand-logo') }}
            </div>
            <div class="text-left">
                <h1 class="text-xl font-bold text-gray-800 mb-1">📢 Sekilas Info</h1>
                <p class="text-justify">
                    {{ config('app.berita') }}
                </p>
            </div>
        </div>
    </x-filament::section>
</x-filament-widgets::widget>
