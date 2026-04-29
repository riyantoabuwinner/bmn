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
        // Set environment variable to prevent git from prompting for input
        putenv('GIT_TERMINAL_PROMPT=0');
        
        // Git Fetch with a 10 second timeout
        $process = \Illuminate\Support\Facades\Process::timeout(10)->run('git fetch origin main');
        
        if ($process->failed()) {
            \Log::error("Git Fetch Failed: " . $process->errorOutput());
        }
        
        $status = $this->getGitStatus();
        $logs = $this->getGitLogs();
        $hasMigrations = $this->checkForNewMigrations();

        return response()->json([
            'success' => true,
            'status' => $status,
            'logs' => $logs,
            'has_migrations' => $hasMigrations,
            'output' => $process->output() ?: $process->errorOutput()
        ]);
    }

    public function apply(Request $request)
    {
        putenv('GIT_TERMINAL_PROMPT=0');
        
        // Perform Git Pull with 30s timeout
        $process = \Illuminate\Support\Facades\Process::timeout(30)->run('git pull origin main');
        
        $success = $process->successful();
        
        // Post-update: Clear cache
        if ($success) {
            \Artisan::call('cache:clear');
            \Artisan::call('view:clear');
            \Artisan::call('config:clear');
        }

        return response()->json([
            'success' => $success,
            'output' => $process->output() ?: $process->errorOutput(),
            'message' => $success ? 'Sistem berhasil diperbarui.' : 'Gagal memperbarui sistem. Cek output untuk detailnya.'
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
