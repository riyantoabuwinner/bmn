<?php

namespace App\Http\Controllers;

use App\Models\ImportTask;
use App\Imports\AssetImport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Storage;

class AssetImportController extends Controller
{
    public function index()
    {
        $lastTask = ImportTask::where('user_id', auth()->id())
            ->where('type', 'asset')
            ->latest()
            ->first();

        return view('assets.import', compact('lastTask'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:102400', // 100MB max
        ]);

        $file = $request->file('file');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('imports', $filename);

        $task = ImportTask::create([
            'type' => 'asset',
            'filename' => $file->getClientOriginalName(),
            'status' => 'pending',
            'user_id' => auth()->id(),
        ]);

        Excel::queueImport(new AssetImport($task->id), $path);

        return response()->json([
            'message' => 'Import started successfully in background.',
            'task_id' => $task->id
        ]);
    }

    public function status(ImportTask $task)
    {
        return response()->json([
            'status' => $task->status,
            'processed' => $task->processed_rows,
            'total' => $task->total_rows,
            'progress' => $task->progress,
            'error' => $task->error_message
        ]);
    }
}
