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
        
        $git = $this->getGitCommand();
        // Git Fetch with a 10 second timeout
        $process = \Illuminate\Support\Facades\Process::path(base_path())->timeout(10)->run("$git fetch origin main");
        
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
        
        $git = $this->getGitCommand();
        // Perform Git Pull with 30s timeout
        $process = \Illuminate\Support\Facades\Process::path(base_path())->timeout(30)->run("$git pull origin main");
        
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

    private function getGitCommand()
    {
        // Try common paths for Windows if 'git' isn't found in PATH
        $commonPaths = [
            'git', // Default in PATH
            'C:\Program Files\Git\cmd\git.exe',
            'C:\Program Files\Git\bin\git.exe',
            '/usr/bin/git',
            '/usr/local/bin/git'
        ];

        foreach ($commonPaths as $path) {
            $process = \Illuminate\Support\Facades\Process::run("$path --version");
            if ($process->successful()) {
                return $path;
            }
        }

        return 'git'; // Fallback to default
    }

    private function getLocalStatus()
    {
        $basePath = base_path();
        $git = $this->getGitCommand();
        
        try {
            $branchProcess = \Illuminate\Support\Facades\Process::path($basePath)->run("$git rev-parse --abbrev-ref HEAD");
            $hashProcess = \Illuminate\Support\Facades\Process::path($basePath)->run("$git rev-parse --short HEAD");
            $dateProcess = \Illuminate\Support\Facades\Process::path($basePath)->run("$git log -1 --format=%cd --date=relative");
            
            if ($branchProcess->failed()) {
                \Log::warning("Git Status Failed. Command: $git. Error: " . $branchProcess->errorOutput());
            }

            $branch = trim($branchProcess->output() ?: 'unknown');
            $hash = trim($hashProcess->output() ?: 'unknown');
            $date = trim($dateProcess->output() ?: 'unknown');
            
            return [
                'branch' => $branch,
                'hash' => $hash,
                'date' => $date,
                'behind' => 0
            ];
        } catch (\Exception $e) {
            \Log::error("Git Local Status Exception: " . $e->getMessage());
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
        $basePath = base_path();
        $git = $this->getGitCommand();
        
        try {
            $status = $this->getLocalStatus();
            
            // Check if we are behind origin
            $behindCount = trim(\Illuminate\Support\Facades\Process::path($basePath)->run("$git rev-list HEAD..origin/main --count")->output() ?: '0');
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
        $git = $this->getGitCommand();
        $process = \Illuminate\Support\Facades\Process::run("$git log -n 10 --format=\"%h %s (%cr) <%an>\"");
        $output = trim($process->output());
        return $output ? explode("\n", $output) : [];
    }

    private function checkForNewMigrations()
    {
        $git = $this->getGitCommand();
        // Cross-platform check for migrations
        $process = \Illuminate\Support\Facades\Process::run("$git diff --name-only HEAD origin/main");
        $files = explode("\n", $process->output());
        
        foreach ($files as $file) {
            if (str_contains($file, 'database/migrations')) {
                return true;
            }
        }
        
        return false;
    }
}
