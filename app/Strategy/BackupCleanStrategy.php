<?php

namespace App\Strategy;

use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Backup\Tasks\Cleanup\Period;
use Spatie\Backup\BackupDestination\Backup;
use Spatie\Backup\Tasks\Cleanup\CleanupStrategy;
use Spatie\Backup\BackupDestination\BackupCollection;

class BackupCleanStrategy extends CleanupStrategy
{
    /** @var \Spatie\Backup\BackupDestination\Backup */
    protected $newestBackup;

    public function deleteOldBackups(BackupCollection $backups)
    {
        // Don't ever delete the newest backup.
        $this->newestBackup = $backups->shift();

//        $dateRanges = $this->calculateDateRanges();

//        $this->removeOldBackupsUntilUsingLessThanMaximumStorage($backups);
        $this->removeBackupByMaxFileCount($backups);
    }

    protected function calculateDateRanges(): Collection
    {
        $config = $this->config->get('laravel-backup.cleanup.defaultStrategy');

        $daily = new Period(
            Carbon::now()->subDays($config['keepAllBackupsForDays']),
            Carbon::now()
                ->subDays($config['keepAllBackupsForDays'])
                ->subDays($config['keepDailyBackupsForDays'])
        );

        $weekly = new Period(
            $daily->endDate(),
            $daily->endDate()
                ->subWeeks($config['keepWeeklyBackupsForWeeks'])
        );

        $monthly = new Period(
            $weekly->endDate(),
            $weekly->endDate()
                ->subMonths($config['keepMonthlyBackupsForMonths'])
        );

        $yearly = new Period(
            $monthly->endDate(),
            $monthly->endDate()
                ->subYears($config['keepYearlyBackupsForYears'])
        );

        return collect(compact('daily', 'weekly', 'monthly', 'yearly'));
    }

    protected function removeOldBackupsUntilUsingLessThanMaximumStorage(BackupCollection $backups)
    {
        $maximumSize = $this->config->get('laravel-backup.cleanup.defaultStrategy.deleteOldestBackupsWhenUsingMoreMegabytesThan')
            * 1024 * 1024;

        if ($backups->isEmpty()) {
            return;
        }

        if (($backups->size() + $this->newestBackup->size()) <= $maximumSize) {
            return;
        }

        $backups->oldest()->delete();

        $this->removeOldBackupsUntilUsingLessThanMaximumStorage($backups);
    }

    protected function removeBackupByMaxFileCount(BackupCollection $backups){

        $maximumFile = $this->config->get('laravel-backup.cleanup.defaultStrategy.maximumFileBackupAllocated');

        if ($backups->isEmpty()) {
            return;
        } else {
            $backup_delete = $backups->count() - $maximumFile;
            for ($i = 0; $i < $backup_delete; $i++){
                $backups->oldest()->delete();
            }
        }






    }
}
