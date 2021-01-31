<?php

namespace App\Notifications;

use Spatie\Backup\Notifications\Notifiable;

class BackupNotifiable extends Notifiable {

    public function routeNotificationForAnotherNotificationChannel() {
//        return config('laravel-backup.notifications.another_notification_channel.property');
    }
}

// Keterangan :
// This is just a dummy class to disable laravel-backup annoying notification.