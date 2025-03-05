<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Http\Controllers\LogController;
use Symfony\Component\Process\Exception\ProcessFailedException;
use Illuminate\Support\Facades\Redirect;
use Symfony\Component\Process\Process;

// Hardcoded credentials
$validUsername = 'admin';
$validPassword = 'mypassword123';

// Login Page
Route::get('/login', function () {
    return view('auth.simple-login');
})->name('login');

// Handle Login Request
Route::post('/login', function (Request $request) use ($validUsername, $validPassword) {
    if ($request->input('username') === $validUsername && $request->input('password') === $validPassword) {
        session(['authenticated' => true]);
        return redirect('/');
    }

    return back()->withErrors(['message' => 'Invalid credentials']);
})->name('login.process');

// Logout Route
Route::get('/logout', function () {
    session()->forget('authenticated');
    return redirect('/login');
})->name('logout');

// Middleware Closure for Authentication
$authMiddleware = function ($request, $next) {
    if (!session('authenticated')) {
        return redirect('/login');
    }
    return $next($request);
};

// Protect Routes with Authentication
Route::group(['middleware' => $authMiddleware], function () {

    Route::get('/', function () {
        // Get container status
        $process = new Process(['docker', 'ps', '-a', '--format', '{{json .}}']);
        $process->run();
    
        if (!$process->isSuccessful()) {
            return response()->json(['error' => 'Failed to fetch Docker containers'], 500);
        }
    
        // Convert JSON lines to an array of objects
        $containers = array_map('json_decode', explode("\n", trim($process->getOutput())));
    
        return view('home', compact('containers'));
    });
    
    Route::post('/restart-container', function (Request $request) {
        $containerId = $request->input('container_id');
    
        if (!$containerId) {
            return Redirect::back()->with('error', 'Container ID is required.');
        }
    
        $process = new Process(['docker', 'restart', $containerId]);
        $process->run();
    
        if (!$process->isSuccessful()) {
            return Redirect::back()->with('error', 'Failed to restart container.');
        }
    
        return Redirect::back()->with('success', 'Container restarted successfully.');
    });
    

    Route::get('/logs', [LogController::class, 'index'])->name('logs.index');

    // New route to filter by request_id
    Route::get('/logs/{request_id}', [LogController::class, 'showByRequest'])->name('logs.showByRequest');

    Route::get('/logs/{request_id}/{log_id}', [LogController::class, 'show'])->name('logs.show');
});
