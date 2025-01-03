<?php

namespace App\Providers\Filament;

use Filament\Http\Middleware\Authenticate;
use Filament\Http\Middleware\DisableBladeIconComponents;
use Filament\Http\Middleware\DispatchServingFilamentEvent;
use Filament\Pages;
use Filament\Panel;
use Filament\PanelProvider;
use Filament\Support\Colors\Color;
use Filament\Navigation\NavigationItem;
use Filament\Widgets;
use Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse;
use Illuminate\Cookie\Middleware\EncryptCookies;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Routing\Middleware\SubstituteBindings;
use Illuminate\Session\Middleware\AuthenticateSession;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\View\Middleware\ShareErrorsFromSession;
use CharrafiMed\GlobalSearchModal\GlobalSearchModalPlugin;
use App\Filament\Pages\InstructorPorEstado; 
use App\Filament\Pages\Notifications; 

class AdminPanelProvider extends PanelProvider
{
    public function panel(Panel $panel): Panel
    {
        return $panel
            ->default()
            ->id('admin')
            ->path('admin')
            ->login()
            ->profile()
            ->sidebarCollapsibleOnDesktop()
            ->colors([
                'primary' => Color::hex('#39a900'),
                'secondary' => Color::hex('#00324D'),
                'tertiary' => Color::hex('#3CB5CC'),
                'warning' => Color::Orange,
                'danger' => Color::Rose,
                // 'success' => Color::Emerald,
                'contrato' => Color::hex('#FFD700'),
                
            ])  
            ->discoverResources(in: app_path('Filament/Resources'), for: 'App\\Filament\\Resources')
            ->discoverPages(in: app_path('Filament/Pages'), for: 'App\\Filament\\Pages')
            ->pages([
                Pages\Dashboard::class,
                InstructorPorEstado::class,
                Notifications::class,
            ])
            ->discoverWidgets(in: app_path('Filament/Widgets'), for: 'App\\Filament\\Widgets')
            ->widgets([
                
                
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
                GlobalSearchModalPlugin::make(),
                \BezhanSalleh\FilamentShield\FilamentShieldPlugin::make()
            ])
            ->brandName('Seguimiento - EP')
            ->brandLogo(asset('images/seguimiento-logo.svg'))
            ->darkModeBrandLogo(asset('images/seguimiento-logo-negativo.svg'))
            ->brandLogoHeight('5.9rem')
            ->spa();
            //->font('Roboto');
            
    }
}
