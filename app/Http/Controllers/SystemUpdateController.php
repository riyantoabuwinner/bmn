<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Process;
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
        try {
            putenv('GIT_TERMINAL_PROMPT=0');
            putenv('GIT_ASKPASS=echo');
            
            $git = $this->getGitCommand();
            $basePath = base_path();
            
            Log::info("System Update Check: using git at '$git', basePath: '$basePath'");
            
            // Git Fetch with a SHORT 5 second timeout to prevent hanging
            $process = Process::path($basePath)
                ->timeout(5)
                ->env([
                    'GIT_TERMINAL_PROMPT' => '0',
                    'GIT_ASKPASS' => 'echo',
                ])
                ->run("$git fetch origin main 2>&1");
            
            Log::info("Git Fetch exit code: " . $process->exitCode() . ", output: " . substr($process->output(), 0, 200));
            
            if ($process->failed()) {
                $errorMsg = $process->errorOutput() ?: $process->output();
                Log::error("Git Fetch Failed: " . $errorMsg);
                return response()->json([
                    'success' => false,
                    'message' => 'Gagal mengambil data dari repository. Error: ' . substr($errorMsg, 0, 200),
                    'output' => $errorMsg
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
                'output' => 'Pengecekan berhasil.'
            ]);
        } catch (\Symfony\Component\Process\Exception\ProcessTimedOutException $e) {
            Log::error("Git Fetch Timeout: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Koneksi ke GitHub timeout (> 5 detik). Periksa koneksi internet server.',
                'output' => 'Timeout: ' . $e->getMessage()
            ]);
        } catch (\Exception $e) {
            Log::error("System Update Check Exception: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Terjadi error: ' . $e->getMessage(),
                'output' => $e->getMessage()
            ]);
        }
    }

    public function apply(Request $request)
    {
        try {
            putenv('GIT_TERMINAL_PROMPT=0');
            putenv('GIT_ASKPASS=echo');
            
            $git = $this->getGitCommand();
            $basePath = base_path();
            
            // Perform Git Pull with 30s timeout
            $process = Process::path($basePath)
                ->timeout(30)
                ->env([
                    'GIT_TERMINAL_PROMPT' => '0',
                    'GIT_ASKPASS' => 'echo',
                ])
                ->run("$git pull origin main 2>&1");
            
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
        } catch (\Exception $e) {
            Log::error("System Update Apply Exception: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'output' => $e->getMessage(),
                'message' => 'Terjadi error saat memperbarui: ' . $e->getMessage()
            ]);
        }
    }

    /**
     * Find the git executable path. Cached per request.
     */
    private function getGitCommand()
    {
        if ($this->gitCmd !== null) {
            return $this->gitCmd;
        }

        // Check common absolute paths first (fastest, no process needed)
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
                return $this->gitCmd;
            }
        }

        // Fallback
        $this->gitCmd = 'git';
        return $this->gitCmd;
    }

    /**
     * Get local-only git status. Used for initial page load.
     */
    private function getLocalStatus()
    {
        $basePath = base_path();
        $git = $this->getGitCommand();
        
        try {
            $branch = trim(Process::path($basePath)->timeout(3)->run("$git rev-parse --abbrev-ref HEAD")->output() ?: 'unknown');
            $hash = trim(Process::path($basePath)->timeout(3)->run("$git rev-parse --short HEAD")->output() ?: 'unknown');
            $date = trim(Process::path($basePath)->timeout(3)->run("$git log -1 --format=%cd --date=relative")->output() ?: 'unknown');

            return [
                'branch' => $branch,
                'hash' => $hash,
                'date' => $date,
                'behind' => 0
            ];
        } catch (\Exception $e) {
            Log::error("Git Local Status Error: " . $e->getMessage());
            return ['branch' => 'Error', 'hash' => 'Error', 'date' => 'Error', 'behind' => 0];
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
            $branch = trim(Process::path($basePath)->timeout(3)->run("$git rev-parse --abbrev-ref HEAD")->output() ?: 'unknown');
            $hash = trim(Process::path($basePath)->timeout(3)->run("$git rev-parse --short HEAD")->output() ?: 'unknown');
            $date = trim(Process::path($basePath)->timeout(3)->run("$git log -1 --format=%cd --date=relative")->output() ?: 'unknown');
            $behindCount = trim(Process::path($basePath)->timeout(3)->run("$git rev-list HEAD..origin/main --count")->output() ?: '0');

            return [
                'branch' => $branch,
                'hash' => $hash,
                'date' => $date,
                'behind' => (int)$behindCount
            ];
        } catch (\Exception $e) {
            Log::error("Git Remote Status Error: " . $e->getMessage());
            return ['branch' => 'Error', 'hash' => 'Error', 'date' => 'Error', 'behind' => 0];
        }
    }

    private function getGitLogs()
    {
        try {
            $git = $this->getGitCommand();
            $process = Process::path(base_path())->timeout(3)->run("$git log -n 10 --format=\"%h %s (%cr) <%an>\"");
            $output = trim($process->output());
            return $output ? explode("\n", $output) : [];
        } catch (\Exception $e) {
            return [];
        }
    }

    private function checkForNewMigrations()
    {
        try {
            $git = $this->getGitCommand();
            $process = Process::path(base_path())->timeout(3)->run("$git diff --name-only HEAD origin/main");
            $files = explode("\n", $process->output());
            
            foreach ($files as $file) {
                if (str_contains(trim($file), 'database/migrations')) {
                    return true;
                }
            }
        } catch (\Exception $e) {
            // Ignore
        }
        
        return false;
    }
}
