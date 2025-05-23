<x-filament-widgets::widget>
    <x-filament::section heading="Informasi Pengguna" heading-class="text-xl font-bold" icon="heroicon-s-user-circle"
        icon-color="text-primary-500" icon-size="h-6 w-6" class="!p-6">
        <div class="space-y-5">
            <!-- Nama -->
            <div class="flex items-start gap-4 mb-5">
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-primary-50 text-primary-600 dark:bg-primary-500/10 dark:text-primary-400">
                    <x-heroicon-s-user class="h-5 w-5" />
                </div>
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Nama Lengkap</p>
                    <p class="text-base font-medium">{{ $name }}</p>
                </div>
            </div>

            <!-- Email -->
            <div class="flex items-start gap-4 mb-5">
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-blue-50 text-blue-600 dark:bg-blue-500/10 dark:text-blue-400">
                    <x-heroicon-s-at-symbol class="h-5 w-5" />
                </div>
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Email/Username</p>
                    <p class="text-base font-medium">{{ $email }}</p>
                </div>
            </div>

            {{-- Khusus Siswa --}}
            @if (Filament\Facades\Filament::auth()->user()->isSiswa())
                {{-- Class --}}
                <div class="flex items-start gap-4 mb-5">
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                        <x-heroicon-s-rectangle-group class="h-5 w-5" />
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Kelas</p>
                        <p class="text-base font-medium">
                            {{ ucwords($classroom) }}</p>
                    </div>
                </div>
                {{-- Gender --}}
                <div class="flex items-start gap-4 mb-5">
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                        <x-heroicon-s-shield-check class="h-5 w-5" />
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Jenis Kelamin</p>
                        <p class="text-base font-medium">
                            {{ $gender }}</p>
                    </div>
                </div>
                {{-- Birthdate --}}
                <div class="flex items-start gap-4 mb-5">
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                        <x-heroicon-s-calendar class="h-5 w-5" />
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Tanggal Lahir</p>
                        <p class="text-base font-medium">
                            {{ $birthdate }}</p>
                    </div>
                </div>
                <!-- Address -->
                <div class="flex items-start gap-4 mb-5">
                    <div
                        class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                        <x-heroicon-s-calendar class="h-5 w-5" />
                    </div>
                    <div class="space-y-1">
                        <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Alamat</p>
                        <p class="text-base font-medium">
                            {{ \Illuminate\Support\Str::words($address, 5, '...') }}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Role -->
            <div class="flex items-start gap-4 mb-5">
                <div
                    class="flex h-9 w-9 items-center justify-center rounded-lg bg-amber-50 text-amber-600 dark:bg-amber-500/10 dark:text-amber-400">
                    <x-heroicon-s-shield-exclamation class="h-5 w-5" />
                </div>
                <div class="space-y-1">
                    <p class="text-sm font-medium text-gray-500 dark:text-gray-400">Role/Peran</p>
                    <p class="text-base font-medium">{{ ucfirst($role) }}</p>
                </div>
            </div>

        </div>
    </x-filament::section>
</x-filament-widgets::widget>
