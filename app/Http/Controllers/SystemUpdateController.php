<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\File;

class SystemUpdateController extends Controller
{
    public function index()
    {
        $status = $this->getGitStatus();
        $logs = $this->getGitLogs();
        
        return view('system.update', compact('status', 'logs'));
    }

    public function check(Request $request)
    {
        // Git Fetch to update remote info
        exec('git fetch origin main 2>&1', $output, $returnCode);
        
        $status = $this->getGitStatus();
        $logs = $this->getGitLogs();
        $hasMigrations = $this->checkForNewMigrations();

        return response()->json([
            'success' => true,
            'status' => $status,
            'logs' => $logs,
            'has_migrations' => $hasMigrations,
            'output' => implode("\n", $output)
        ]);
    }

    public function apply(Request $request)
    {
        // Perform Git Pull
        exec('git pull origin main 2>&1', $output, $returnCode);
        
        $success = ($returnCode === 0);
        
        // Post-update: Clear cache
        if ($success) {
            \Artisan::call('cache:clear');
            \Artisan::call('view:clear');
            \Artisan::call('config:clear');
        }

        return response()->json([
            'success' => $success,
            'output' => implode("\n", $output),
            'message' => $success ? 'Sistem berhasil diperbarui.' : 'Gagal memperbarui sistem.'
        ]);
    }

    private function getGitStatus()
    {
        $branch = exec('git rev-parse --abbrev-ref HEAD');
        $hash = exec('git rev-parse --short HEAD');
        $date = exec('git log -1 --format=%cd --date=relative');
        
        // Check if we are behind origin
        exec('git rev-list HEAD..origin/main --count', $behindCount);
        $behindCount = isset($behindCount[0]) ? (int)$behindCount[0] : 0;

        return [
            'branch' => $branch,
            'hash' => $hash,
            'date' => $date,
            'behind' => $behindCount
        ];
    }

    private function getGitLogs()
    {
        exec('git log -n 10 --format="%h %s (%cr) <%an>"', $logs);
        return $logs;
    }

    private function checkForNewMigrations()
    {
        // This is a simple check comparing migration files
        // In a real git update, we could check if files in database/migrations changed
        exec('git diff --name-only HEAD origin/main | findstr "database/migrations"', $migrations);
        return !empty($migrations);
    }
}
