<?php

namespace App\Providers\Filament;

use App\Filament\Pages\Auth\Login;
use App\Filament\Widgets\LogoWidget;
use App\Filament\Widgets\SchoolBiography;
use App\Filament\Widgets\SchoolProfileWidget;
use Filament\Facades\Filament;
use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\AuthenticateSession;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Navigation\MenuItem;
use Filament\Navigation\NavigationGroup;
use Filament\Navigation\NavigationItem;
use Filament\Pages;
use Filament\Pages\Auth\EditProfile;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use Saade\FilamentFullCalendar\FilamentFullCalendarPlugin;

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->theme(asset('css/filament/admin/theme.css'))
            ->brandName('MTSS Ikhlas Jawilan')
            ->brandLogo(fn() => view('components.brand-logo'))
            ->login(Login::class)
            ->profile(isSimple: false)
            ->userMenuItems([
                'profile' => MenuItem::make()->label(fn() => Filament::auth()->user()->name),
            ])
            ->navigationItems([
                NavigationItem::make()
                    ->label('Profil Pengguna')
                    ->url(fn() => EditProfile::getUrl())
                    ->icon('heroicon-o-user-circle')
                    ->group('Pengaturan')
                    ->sort(22)
                    ->isActiveWhen(fn(): bool => request()->routeIs(EditProfile::getRouteName())),
            ])
            ->navigationGroups([
                NavigationGroup::make()
                    ->label('Master Data')
                    ->collapsed(false),
                NavigationGroup::make()
                    ->label('Laporan')
                    ->collapsed(false),
                NavigationGroup::make()
                    ->label('Pengaturan')
                    ->collapsed(false),
            ])
            ->databaseNotifications()
            ->colors([
                'primary' => Color::Sky,
            ])
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                LogoWidget::class,
                SchoolBiography::class,
                SchoolProfileWidget::class,
            ])
            ->plugins([
                FilamentFullCalendarPlugin::make()
                    ->selectable()
                    ->editable()
                    ->locale('id')
                    ->timezone('Asia/Jakarta'),
            ])
            ->middleware([
                EncryptCookies::class,
                AddQueuedCookiesToResponse::class,
                StartSession::class,
                AuthenticateSession::class,
                ShareErrorsFromSession::class,
                VerifyCsrfToken::class,
                SubstituteBindings::class,
                DisableBladeIconComponents::class,
                DispatchServingFilamentEvent::class,
            ])
            ->authMiddleware([
                Authenticate::class,
            ]);
    }
}
