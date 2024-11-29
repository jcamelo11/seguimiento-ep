<?php

namespace App\Filament\Pages;

use Filament\Pages\Page;
use Illuminate\Support\Facades\Auth;
use Filament\Forms\Components\Card;
use Filament\Forms\Components\Placeholder;
use Illuminate\Notifications\DatabaseNotification;
use Filament\Notifications\Notification as FilamentNotification;


class Notifications extends Page
{
    public $notifications;

    protected static ?string $navigationIcon = 'heroicon-o-bell-alert';
    protected static string $view = 'filament.pages.notifications';
    protected static ?string $navigationLabel = 'Notificaciones';
    protected static ?string $title = 'Notificaciones';

    public function mount(): void
    {
        // Obtén todas las notificaciones, ordenadas por fecha
        $this->notifications = DatabaseNotification::latest()->get();
    }

    public function markAsRead(string $notificationId): void
    {
        $notification = DatabaseNotification::find($notificationId);
        if ($notification) {
            $notification->markAsRead();
            $this->refreshNotifications();
        }
    }

    public function delete(string $notificationId): void
    {
        $notification = DatabaseNotification::find($notificationId);
        if ($notification) {
            $notification->delete();
            $this->refreshNotifications();
        }
    }

    private function refreshNotifications(): void
    {
        $this->notifications = DatabaseNotification::latest()->get();
    }
}

