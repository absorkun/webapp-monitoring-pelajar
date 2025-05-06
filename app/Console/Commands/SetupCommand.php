<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup server out of the box';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('🚀 Menjalankan instalasi untuk mode production...');

        // Generate key jika belum ada
        if (empty(config('app.key'))) {
            $this->callSilent('key:generate', ['--force' => true]);
            $this->info('✅ APP_KEY berhasil dibuat.');
        }

        // Jalankan migrasi dan seeder secara paksa (tanpa konfirmasi)
        $this->call('migrate', ['--force' => true]);
        $this->info('✅ Migrasi database selesai.');

        $this->call('db:seed', ['--force' => true]);
        $this->info('✅ Database seeding selesai.');

        // Buat storage symlink
        $this->callSilent('storage:link');
        $this->info('✅ Symbolic link ke storage dibuat.');

        // Bersihkan dan buat cache
        $this->callSilent('config:clear');
        $this->callSilent('route:clear');
        $this->callSilent('view:clear');
        $this->callSilent('event:clear');

        $this->callSilent('config:cache');
        $this->callSilent('route:cache');
        $this->callSilent('view:cache');
        $this->callSilent('event:cache');

        $this->info('✅ Cache konfigurasi, route, view, dan event selesai.');

        $this->info('🎉 Aplikasi Laravel siap digunakan di production.');
    }
}
