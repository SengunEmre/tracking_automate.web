<!-- resources/views/home.blade.php -->
@extends('layouts.app')

@section('title', 'Home Dashboard')

@section('content')
<div class="pt-4 pb-2 d-flex justify-content-between align-items-center">
        <h1>Machine List</h1>
    </div>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Docker Container Status</title>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <style>
    body {
        font-family: Arial, sans-serif;
        background-color: #121212; /* Dark background */
        color: #FFFFFF; /* White text */
        margin: 20px;
    }
    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
        background-color: #232323; /* Dark table background */
        color: white;
    }
    th, td {
        padding: 10px;
        border: 1px solid #444; /* Border color */
        text-align: left;
    }
    th {
        background-color: #1E1E1E; /* Table header */
    }
    tr:nth-child(even) {
        background-color: #2C2C2C; /* Even row color */
    }
    tr:nth-child(odd) {
        background-color: #252525; /* Odd row color */
    }
    .running {
        background-color: #4CAF50; /* Green for running containers */
    }
    .stopped {
        background-color: #F44336; /* Red for stopped containers */
    }
    .restart-btn {
        background-color: #FFC107; /* Yellow button */
        color: black;
        padding: 5px 10px;
        border: none;
        cursor: pointer;
    }
    .restart-btn:hover {
        background-color: #FFA000;
    }
</style>

</head>
<body>
    <h2>Docker Container Status</h2>

    @if(session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif
    @if(session('error'))
        <p style="color: red;">{{ session('error') }}</p>
    @endif

    <table>
        <thead>
            <tr>
                <th>Container ID</th>
                <th>Name</th>
                <th>Image</th>
                <th>Command</th>
                <th>Status</th>
                <th>Ports</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($containers as $container)
                @php
                    $isRunning = str_contains($container->Status, 'Up');
                    $rowClass = $isRunning ? 'running' : 'stopped';
                @endphp
                <tr class="{{ $rowClass }}">
                    <td>{{ $container->ID }}</td>
                    <td>{{ $container->Names }}</td>
                    <td>{{ $container->Image }}</td>
                    <td>{{ $container->Command }}</td>
                    <td>{{ $container->Status }}</td>
                    <td>{{ $container->Ports }}</td>
                    <td>
                        @if (!$isRunning)
                            <form method="POST" action="/restart-container">
                                @csrf
                                <input type="hidden" name="container_id" value="{{ $container->ID }}">
                                <button type="submit" class="restart-btn">Restart</button>
                            </form>
                        @else
                            Running
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>

@endsection
