@extends('layouts.app') 
<!-- If you're using a layout file -->

@section('title', 'Logs')

@section('content')
    <div class="pt-4 pb-2 d-flex justify-content-between align-items-center">
        <h1>Logs</h1>
    </div>

    <div class="table-responsive">
        <table class="table table-dark table-striped align-middle">
            <thead>
                <tr>
                    <th>Log ID</th>
                    <th>Logger Name</th>
                    <th>Request</th>
                    <th class="text-center">Exception</th>
                    <th class="text-center">Update</th>
                    <th class="text-center" >Email</th>
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
                        <td class="text-center align-middle" >
                            @if($log->exception_status)
                                <!-- If exception == 1 -->
                                <i class="fa fa-check-circle text-failed"></i>
                            @else
                                <!-- If exception == 0 -->
                                -
                            @endif
                        </td>
                        <td class="text-center align-middle" >
                            @if($log->update_status)
                                <!-- If exception == 1 -->
                                <i class="fa fa-check-circle text-success"></i>
                            @else
                                <!-- If exception == 0 -->
                                -
                            @endif
                        </td>
                        <td class="text-center align-middle">
                            @if($log->email_status)
                                <!-- If exception == 1 -->
                                <i class="fa fa-check-circle text-success"></i>
                            @else
                                <!-- If exception == 0 -->
                                -
                            @endif
                        </td>
                        <td>{{ $log->timestamp }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="text-center">No logs found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    
    <!-- Pagination links (Bootstrap 5 style) -->
    <div class="d-flex justify-content-center">
        {{ $logs->links('pagination::bootstrap-5') }}
    </div>


@endsection
