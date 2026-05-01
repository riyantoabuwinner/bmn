<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;

class SystemUpdateController extends Controller
{
    private $gitCmd = null;

    public function index()
    {
        $status = $this->getLocalStatus();
        $logs = $this->getGitLogs();
        
        return view('system.update', compact('status', 'logs'));
    }

    public function check(Request $request)
    {
        putenv('GIT_TERMINAL_PROMPT=0');
        
        $git = $this->getGitCommand();
        $basePath = base_path();
        
        // Git Fetch with a 10 second timeout
        $process = Process::path($basePath)->timeout(10)->run("$git fetch origin main");
        
        if ($process->failed()) {
            Log::error("Git Fetch Failed: " . $process->errorOutput());
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data dari repository (git fetch). Pastikan koneksi internet stabil dan git terinstal di server.',
                'output' => $process->errorOutput()
            ]);
        }
        
        $status = $this->getRemoteStatus();
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
        $basePath = base_path();
        
        // Perform Git Pull with 30s timeout
        $process = Process::path($basePath)->timeout(30)->run("$git pull origin main");
        
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

    /**
     * Find the git executable path. Cached per request.
     */
    private function getGitCommand()
    {
        if ($this->gitCmd !== null) {
            return $this->gitCmd;
        }

        // Check common absolute paths first (fastest)
        $knownPaths = [
            'C:\Program Files\Git\cmd\git.exe',
            'C:\Program Files\Git\bin\git.exe',
            'C:\Program Files (x86)\Git\cmd\git.exe',
            '/usr/bin/git',
            '/usr/local/bin/git',
        ];

        foreach ($knownPaths as $path) {
            if (file_exists($path)) {
                $this->gitCmd = '"' . $path . '"';
                Log::info("Git resolved to: " . $this->gitCmd);
                return $this->gitCmd;
            }
        }

        // Try 'where' command on Windows
        $whereOutput = @shell_exec('where git 2>NUL');
        if (!empty($whereOutput)) {
            $lines = explode("\n", trim($whereOutput));
            foreach ($lines as $line) {
                $line = trim($line);
                if (!empty($line) && file_exists($line)) {
                    $this->gitCmd = '"' . $line . '"';
                    Log::info("Git resolved via 'where': " . $this->gitCmd);
                    return $this->gitCmd;
                }
            }
        }

        // Try 'which' command on Linux
        $whichOutput = @shell_exec('which git 2>/dev/null');
        if (!empty($whichOutput)) {
            $line = trim($whichOutput);
            if (!empty($line) && file_exists($line)) {
                $this->gitCmd = $line;
                return $this->gitCmd;
            }
        }

        // Last resort: just try 'git'
        $this->gitCmd = 'git';
        return $this->gitCmd;
    }

    /**
     * Get local-only git status (no remote check). Used for initial page load.
     */
    private function getLocalStatus()
    {
        $basePath = base_path();
        $git = $this->getGitCommand();
        
        try {
            $branch = trim(Process::path($basePath)->run("$git rev-parse --abbrev-ref HEAD")->output() ?: 'unknown');
            $hash = trim(Process::path($basePath)->run("$git rev-parse --short HEAD")->output() ?: 'unknown');
            $date = trim(Process::path($basePath)->run("$git log -1 --format=%cd --date=relative")->output() ?: 'unknown');

            return [
                'branch' => $branch,
                'hash' => $hash,
                'date' => $date,
                'behind' => 0
            ];
        } catch (\Exception $e) {
            Log::error("Git Local Status Error: " . $e->getMessage());
            return [
                'branch' => 'Error',
                'hash' => 'Error',
                'date' => 'Error',
                'behind' => 0
            ];
        }
    }

    /**
     * Get status including remote comparison. Used after git fetch.
     */
    private function getRemoteStatus()
    {
        $basePath = base_path();
        $git = $this->getGitCommand();
        
        try {
            $branch = trim(Process::path($basePath)->run("$git rev-parse --abbrev-ref HEAD")->output() ?: 'unknown');
            $hash = trim(Process::path($basePath)->run("$git rev-parse --short HEAD")->output() ?: 'unknown');
            $date = trim(Process::path($basePath)->run("$git log -1 --format=%cd --date=relative")->output() ?: 'unknown');
            $behindCount = trim(Process::path($basePath)->run("$git rev-list HEAD..origin/main --count")->output() ?: '0');

            return [
                'branch' => $branch,
                'hash' => $hash,
                'date' => $date,
                'behind' => (int)$behindCount
            ];
        } catch (\Exception $e) {
            Log::error("Git Remote Status Error: " . $e->getMessage());
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
        $basePath = base_path();
        $process = Process::path($basePath)->run("$git log -n 10 --format=\"%h %s (%cr) <%an>\"");
        $output = trim($process->output());
        return $output ? explode("\n", $output) : [];
    }

    private function checkForNewMigrations()
    {
        $git = $this->getGitCommand();
        $basePath = base_path();
        $process = Process::path($basePath)->run("$git diff --name-only HEAD origin/main");
        $files = explode("\n", $process->output());
        
        foreach ($files as $file) {
            if (str_contains(trim($file), 'database/migrations')) {
                return true;
            }
        }
        
        return false;
    }
}
