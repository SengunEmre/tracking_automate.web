@extends('layouts.app')

@section('title', 'Logs')

@section('content')
    <div class="pt-4 pb-2 d-flex justify-content-between align-items-center">
        <h1>Logs</h1>
    </div>

    <!-- Filter Form -->
    <form method="GET" action="{{ route('logs.index') }}" class="mb-3">
        <div class="row">
            <!-- Logger Name Filter -->
            <div class="col-md-3">
                <input type="text" name="logger_name" class="form-control" placeholder="Logger Name" value="{{ request('logger_name') }}">
            </div>
            <!-- Request ID Filter -->
            <div class="col-md-3">
                <input type="text" name="request_id" class="form-control" placeholder="Request ID" value="{{ request('request_id') }}">
            </div>
            <!-- Update Status Filter -->
            <div class="col-md-3">
                <select name="update_status" class="form-control">
                    <option value="">All Update Statuses</option>
                    <option value="1" {{ request('update_status') === "1" ? 'selected' : '' }}>Updated</option>
                    <option value="0" {{ request('update_status') === "0" ? 'selected' : '' }}>Not Updated</option>
                </select>
            </div>
            <!-- Email Status Filter -->
            <div class="col-md-3">
                <select name="email_status" class="form-control">
                    <option value="">All Email Statuses</option>
                    <option value="1" {{ request('email_status') === "1" ? 'selected' : '' }}>Email Sent</option>
                    <option value="0" {{ request('email_status') === "0" ? 'selected' : '' }}>Email Not Sent</option>
                </select>
            </div>
        </div>
        <div class="mt-2">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <!-- Logs Table -->
    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle">
            <thead>
                <tr>
                    <th>Log ID</th>
                    <th>Logger Name</th>
                    <th>Request</th>
                    <th class="text-center">Exception</th>
                    <th class="text-center">Update</th>
                    <th class="text-center">Email</th>
                    <th>Timestamp</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                    <tr>
                        <td>
                            <a href="{{ route('logs.show', [$log->request_id, $log->log_id]) }}">
                                {{ $log->log_id }}
                            </a>
                        </td>
                        <td>{{ $log->logger_name }}</td>
                        <td>
                            <a href="{{ route('logs.showByRequest', $log->request_id) }}">{{ $log->request_id }}</a>
                        </td>
                        <td class="text-center align-middle">
                            @if($log->exception_status)
                                <i class="fa fa-check-circle text-failed"></i>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if($log->update_status)
                                <i class="fa fa-check-circle text-success"></i>
                            @else
                                -
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if($log->email_status)
                                <i class="fa fa-check-circle text-success"></i>
                            @else
                                -
                            @endif
                        </td>
                        <td>{{ $log->timestamp }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Pagination Links -->
    <div class="justify-content-center">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>
@endsection
