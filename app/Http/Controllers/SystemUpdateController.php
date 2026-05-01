<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\File;

class SystemUpdateController extends Controller
{
    public function index()
    {
        $status = $this->getLocalStatus();
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
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari repository (git fetch). Pastikan koneksi internet stabil dan git terinstal di server.',
                'output' => $process->errorOutput()
            ]);
        }
        
        $status = $this->getGitStatus();
        $logs = $this->getGitLogs();
        $hasMigrations = $this->checkForNewMigrations();

        return response()->json([
            'success' => true,
            'status' => $status,
            'logs' => $logs,
            'has_migrations' => $hasMigrations,
            'output' => $process->output() ?: 'Fetch berhasil. Tidak ada output tambahan.'
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

    private function getLocalStatus()
    {
        try {
            $branch = trim(\Illuminate\Support\Facades\Process::run('git rev-parse --abbrev-ref HEAD')->output() ?: 'unknown');
            $hash = trim(\Illuminate\Support\Facades\Process::run('git rev-parse --short HEAD')->output() ?: 'unknown');
            $date = trim(\Illuminate\Support\Facades\Process::run('git log -1 --format=%cd --date=relative')->output() ?: 'unknown');
            
            return [
                'branch' => $branch,
                'hash' => $hash,
                'date' => $date,
                'behind' => 0 // Always 0 on initial load to avoid accidental triggers
            ];
        } catch (\Exception $e) {
            return [
                'branch' => 'Error',
                'hash' => 'Error',
                'date' => 'Error',
                'behind' => 0
            ];
        }
    }

    private function getGitStatus()
    {
        try {
            $status = $this->getLocalStatus();
            
            // Check if we are behind origin
            $behindCount = trim(\Illuminate\Support\Facades\Process::run('git rev-list HEAD..origin/main --count')->output() ?: '0');
            $status['behind'] = (int)$behindCount;

            return $status;
        } catch (\Exception $e) {
            \Log::error("Git Status Error: " . $e->getMessage());
            return [
                'branch' => 'Error',
                'hash' => 'Error',
                'date' => 'Error',
                'behind' => 0
            ];
        }
    }

    private function getGitLogs()
    {
        $process = \Illuminate\Support\Facades\Process::run('git log -n 10 --format="%h %s (%cr) <%an>"');
        $output = trim($process->output());
        return $output ? explode("\n", $output) : [];
    }

    private function checkForNewMigrations()
    {
        // Cross-platform check for migrations
        $process = \Illuminate\Support\Facades\Process::run('git diff --name-only HEAD origin/main');
        $files = explode("\n", $process->output());
        
        foreach ($files as $file) {
            if (str_contains($file, 'database/migrations')) {
                return true;
            }
        }
        
        return false;
    }
}
