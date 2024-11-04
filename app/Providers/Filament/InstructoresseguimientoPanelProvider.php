<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;

class InstructoresseguimientoPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->id('instructoresseguimiento')
            ->path('instructorseguimiento')
            ->login()
            ->profile()
            ->colors([
                'primary' => Color::hex('#3CB5CC'),
            ])
            ->discoverResources(in: app_path('Filament/Instructoresseguimiento/Resources'), for: 'App\\Filament\\Instructoresseguimiento\\Resources')
            ->discoverPages(in: app_path('Filament/Instructoresseguimiento/Pages'), for: 'App\\Filament\\Instructoresseguimiento\\Pages')
            ->pages([
                Pages\Dashboard::class,
            ])
            ->resources([
                \App\Filament\Resources\AprendizResource::class,
                // otros resources para el panel del instructor
            ])
            ->discoverWidgets(in: app_path('Filament/Instructoresseguimiento/Widgets'), for: 'App\\Filament\\Instructoresseguimiento\\Widgets')
            ->widgets([
                Widgets\AccountWidget::class,
                Widgets\FilamentInfoWidget::class,
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
            ])
            ->plugins([
                GlobalSearchModalPlugin::make()
            ])
            ->brandName('Seguimiento - EP')
            ->brandLogo(asset('images/seguimiento-logo.svg'))
            ->darkModeBrandLogo(asset('images/seguimiento-logo-negativo.svg'))
            ->brandLogoHeight('5.9rem')
            ->spa();
    }
}
