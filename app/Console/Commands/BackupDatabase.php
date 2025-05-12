<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BackupDatabase extends Command
{

    protected $signature = 'backup:run';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Automating Backups';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $backupFileName = 'backup_' . date('Y_m_d_His') . '.sql';
        $backupPath = public_path('upload/database/' . config('app.name'));
        $backupFilePath = $backupPath . '/' . $backupFileName;

        // Ensure the backup directory exists
        if (!is_dir($backupPath)) {
            mkdir($backupPath, 0755, true);
        }

        // Dump the MySQL database to a SQL file
        $mysqldumpCommand = sprintf(
            'mysqldump --user=%s --password=%s --host=%s %s > %s',
            config('database.connections.mysql.username'),
            config('database.connections.mysql.password'),
            config('database.connections.mysql.host'),
            config('database.connections.mysql.database'),
            $backupFilePath
        );
        shell_exec($mysqldumpCommand);

        $this->info('Database backup stored at: ' . $backupPath . '/' . $backupFileName);
    }

}
