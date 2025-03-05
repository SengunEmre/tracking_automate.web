{{-- resources/views/logs/show.blade.php --}}
@extends('layouts.app')

@section('title', 'Individual Log View')

@section('content')
<style>
    /* Make text and icons white on dark background */
    .bg-dark .form-control,
    .bg-dark .input-group-text {
        border: 1px solid #555 !important; /* Adjust color as needed */
        color: #fff !important;           /* Ensures text is white */
        background-color: #222;           /* Darken the inputs if desired */
    }

    /* Keep icon and text aligned in .input-group-text */
    .input-group-text.icon-sized {
        height: 38px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* Adjust icon size if you want it larger than normal text */
    .input-group-text.icon-sized i {
        font-size: 1.2rem;
    }

    /* Make check icon green */
    .text-success i {
        color: #28a745 !important;
    }

    /* Example class for a "failed" icon color */
    .text-failed i {
        color: #dc3545 !important;
    }
</style>

<div class="container-fluid mt-3">
    <h3>Log Details</h3>
    <hr>
    
    <!-- Top row: ShipSgo Data (left) & Carrier Data (right) -->
    <div class="row">
        <!-- ShipSgo Data (Left Column) -->
        <div class="col-md-6">
            <h5>ShipSgo Data</h5>
            <div class="card bg-dark text-white mb-3">
                <div class="card-body">
                    <div class="row bg-dark text-white p-3">
                        <div class="col-md-6">
                            <p class="mb-1">
                                Request ID:
                                <a href="https://shipsgo.com/admin/requests/{{ $log->request_id }}" target="_blank" rel="noopener noreferrer">
                                    {{ $log->request_id ?? '-' }}
                                </a>
                            </p>
                            <p class="mb-1">
                                Status:
                                <span class="badge bg-success">
                                    {{ $log->status ?? '-' }}
                                </span>
                            </p>
                            <p class="mb-1">Carrier: {{ $log->carrier ?? '-' }}</p>
                            <p class="mb-1">Booking: {{ $log->booking_number ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1">Container: {{ $log->container_number ?? '-' }}</p>
                            <p class="mb-1">Admin: {{ $log->admin ?? '-' }}</p>
                            <p class="mb-1">Creation: {{ $log->created_at ?? '-' }}</p>
                            <p class="mb-0">Last Update: {{ $log->updated_at ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Nav Tabs (Left Column) -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="movements-tab" data-bs-toggle="tab" href="#movements" role="tab" aria-controls="movements" aria-selected="true">
                                Movements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="containers-tab" data-bs-toggle="tab" href="#containers" role="tab" aria-controls="containers" aria-selected="false">
                                Containers
                                <span class="badge bg-secondary ms-1">{{ count($data['shipsgo_data']['containers'] ?? []) }}</span>

                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content (Left Column) -->
                    <div class="tab-content mt-3">
                        <!-- Movements Panel -->
                        <div class="tab-pane fade show active" id="movements" role="tabpanel" aria-labelledby="movements-tab">
                            @if(isset($data['shipsgo_data']['movements']))
                                <div class="text-white bg-dark p-2">
                                <!-- PORT OF LOADING -->
                                <div class="bg-dark p-3 text-white">
                                    <h6 class="mt-3">Port of Loading:</h6>
                                    <!-- Location -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text icon-sized">
                                                        <i class="fa fa-map-marker-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" value="{{ $data['shipsgo_data']['movements']['port_of_loading']['port_name'] ?? '-' }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ship & File -->
                                    <div class="row">
                                        <div class="col-md-6">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text icon-sized">
                                                        <i class="fa fa-ship"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" value="{{ $data['shipsgo_data']['movements']['port_of_loading']['departured_vessel_name'] ?? '-' }}" readonly>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text icon-sized">
                                                        <i class="fa fa-file-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" value="{{ $data['shipsgo_data']['movements']['port_of_loading']['departured_vessel_voyage'] ?? '-' }}" readonly>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Date 1 -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text icon-sized">
                                                        <i class="fa fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" value="{{ $data['shipsgo_data']['movements']['port_of_loading']['date_of_loading']['date'] ?? '-' }}" readonly>
                                                <div class="input-group-append">
                                                    @if($data['shipsgo_data']['movements']['port_of_loading']['date_of_loading']['is_actual'] === "true")
                                                        <span class="input-group-text icon-sized text-success">
                                                            <i class="fa fa-check"></i>
                                                        </span>
                                                    @else
                                                        <span class="input-group-text icon-sized text-failed">
                                                            <i class="fa fa-times"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Date 2 -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text icon-sized">
                                                        <i class="fa fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" value="{{ $data['shipsgo_data']['movements']['port_of_loading']['date_of_departure']['date'] ?? '-' }}" readonly>
                                                <div class="input-group-append">
                                                    @if($data['shipsgo_data']['movements']['port_of_loading']['date_of_departure']['is_actual'] === "true")
                                                        <span class="input-group-text icon-sized text-success">
                                                            <i class="fa fa-check"></i>
                                                        </span>
                                                    @else
                                                        <span class="input-group-text icon-sized text-failed">
                                                            <i class="fa fa-times"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Transshipments -->
                                @if(isset($data['shipsgo_data']['movements']['transshipments']) && count($data['shipsgo_data']['movements']['transshipments']) > 0)
                                    <h6 class="mt-3">Transshipments:</h6>
                                    @foreach($data['shipsgo_data']['movements']['transshipments'] as $transshipment)
                                        <div class="mb-2">
                                            <div class="bg-dark p-3 text-white">
                                                <!-- Row 1: Date with check icon -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text icon-sized">
                                                                    <i class="fa fa-calendar-alt"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control" value="{{ $transshipment['date_of_arrival']['date'] ?? '-' }}" readonly>
                                                            <div class="input-group-append">
                                                                @if($transshipment['date_of_arrival']['is_actual'] === "true")
                                                                    <span class="input-group-text icon-sized text-success">
                                                                        <i class="fa fa-check"></i>
                                                                    </span>
                                                                @else
                                                                    <span class="input-group-text icon-sized text-failed">
                                                                        <i class="fa fa-times"></i>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Row 2: Location -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text icon-sized">
                                                                    <i class="fa fa-map-marker-alt"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control" value="{{ $transshipment['port_name'] ?? '-' }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Row 3: Ship & File -->
                                                <div class="row">
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text icon-sized">
                                                                    <i class="fa fa-ship"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control" value="{{ $transshipment['departured_vessel_name'] ?? '-' }}" readonly>
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text icon-sized">
                                                                    <i class="fa fa-file-alt"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control" value="{{ $transshipment['departured_vessel_voyage'] ?? '-' }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>

                                                <!-- Row 4: Date with check icon -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text icon-sized">
                                                                    <i class="fa fa-calendar-alt"></i>
                                                                </span>
                                                            </div>
                                                            <input type="text" class="form-control" value="{{ $transshipment['date_of_departure']['date'] ?? '-' }}" readonly>
                                                            <div class="input-group-append">
                                                                @if($transshipment['date_of_departure']['is_actual'] === "true")
                                                                    <span class="input-group-text icon-sized text-success">
                                                                        <i class="fa fa-check"></i>
                                                                    </span>
                                                                @else
                                                                    <span class="input-group-text icon-sized text-failed">
                                                                        <i class="fa fa-times"></i>
                                                                    </span>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @endif

                                <!-- PORT OF DISCHARGE -->
                                <div class="bg-dark p-3 text-white">
                                    <h6 class="mt-3">Port of Discharge:</h6>
                                    <!-- Row 1: Date with check icon -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text icon-sized">
                                                        <i class="fa fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" value="{{ $data['shipsgo_data']['movements']['port_of_discharge']['date_of_arrival']['date'] ?? '-' }}" readonly>
                                                <div class="input-group-append">
                                                    @if($data['shipsgo_data']['movements']['port_of_discharge']['date_of_arrival']['is_actual'] === "true")
                                                        <span class="input-group-text icon-sized text-success">
                                                            <i class="fa fa-check"></i>
                                                        </span>
                                                    @else
                                                        <span class="input-group-text icon-sized text-failed">
                                                            <i class="fa fa-times"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 2: Date with check icon -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text icon-sized">
                                                        <i class="fa fa-calendar-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" value="{{ $data['shipsgo_data']['movements']['port_of_discharge']['date_of_discharge']['date'] ?? '-' }}" readonly>
                                                <div class="input-group-append">
                                                    @if($data['shipsgo_data']['movements']['port_of_discharge']['date_of_discharge']['is_actual'] === "true")
                                                        <span class="input-group-text icon-sized text-success">
                                                            <i class="fa fa-check"></i>
                                                        </span>
                                                    @else
                                                        <span class="input-group-text icon-sized text-failed">
                                                            <i class="fa fa-times"></i>
                                                        </span>
                                                    @endif
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Row 3: Location -->
                                    <div class="row">
                                        <div class="col-12">
                                            <div class="input-group mb-2">
                                                <div class="input-group-prepend">
                                                    <span class="input-group-text icon-sized">
                                                        <i class="fa fa-map-marker-alt"></i>
                                                    </span>
                                                </div>
                                                <input type="text" class="form-control" value="{{ $data['shipsgo_data']['movements']['port_of_discharge']['port_name'] ?? '-' }}" readonly>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </div>
                            @else
                                <p>No Movemetns Data Available.</p>
                            @endif
                            </div>

                        <!-- Containers Panel -->
                        <div class="tab-pane fade" id="containers" role="tabpanel" aria-labelledby="containers-tab">
                            <div class="text-white bg-dark p-2">
                                @if(isset($data['shipsgo_data']['containers']) && count($data['shipsgo_data']['containers']) > 0)
                                    <h6 class="mt-3">Containers:</h6>
                                    @foreach($data['shipsgo_data']['containers'] as $container)
                                        <div class="mb-2">
                                            <div class="bg-dark p-3 text-white">
                                                <!-- Row 1: Container Number + Badge -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text icon-sized">
                                                                <i class="fa fa-box"></i>
                                                            </span>
                                                            <input type="text" class="form-control" value="{{ $container['number'] ?? '-' }}" readonly>
                                                            <span class="input-group-text bg-warning text-dark fw-bold">
                                                                {{ $container['size'] ?? '-' }}{{ $container['type'] ?? '-' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row 2: First Date -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text icon-sized">
                                                                <i class="fa fa-calendar-alt"></i>
                                                            </span>
                                                            <input type="text" class="form-control" value="{{ $container['empty_to_shipper'] ?? '-' }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row 3: Second Date -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text icon-sized">
                                                                <i class="fa fa-calendar-alt"></i>
                                                            </span>
                                                            <input type="text" class="form-control" value="{{ $container['gate_in'] ?? '-' }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row 4: Gate Out -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text icon-sized">
                                                                <i class="fa fa-truck"></i>
                                                            </span>
                                                            <input type="text" class="form-control" value="{{ $container['gate_out'] ?? '-' }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row 5: Empty Return -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text icon-sized">
                                                                <i class="fa fa-warehouse"></i>
                                                            </span>
                                                            <input type="text" class="form-control" value="{{ $container['empty_return'] ?? '-' }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>No Containers Data Available.</p>
                                @endif
                            </div>
                        </div>
                    </div> <!-- End Left Column Tab Content -->
                </div>
            </div>
        </div> <!-- End ShipSgo Data -->

        <!-- Carrier Data (Right Column) -->
        <div class="col-md-6">
            <h5>Carrier Data</h5>
            <div class="card bg-dark text-white mb-3">
                <div class="card-body">
                    <div class="row bg-dark text-white p-3">
                        <div class="col-md-6">
                            <p class="mb-1">
                                Source:
                                <span class="badge bg-success">
                                    {{ $data['carrier_data']['source'] ?? '-' }}
                                </span>
                            </p>
                            <p class="mb-1">Carrier: {{ $data['carrier_data']['carrier_id'] ?? '-' }}</p>
                            <p class="mb-1">Booking: {{ $data['carrier_data']['booking_number'] ?? '-' }}</p>
                        </div>
                        <div class="col-md-6">
                            <p class="mb-1">Container: {{ $data['carrier_data']['container_number'] ?? '-' }}</p>
                            <p class="mb-1">Process: {{ $log->logger_name ?? '-' }}</p>
                            <p class="mb-1">Creation: {{ $log->created_at ?? '-' }}</p>
                            <p class="mb-0">Comparison Date: {{ $log->timestamp ?? '-' }}</p>
                        </div>
                    </div>

                    <!-- Nav Tabs (Right Column) -->
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" id="carrier-movements-tab" data-bs-toggle="tab" href="#carrier-movements" role="tab" aria-controls="carrier-movements" aria-selected="true">
                                Movements
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" id="carrier-containers-tab" data-bs-toggle="tab" href="#carrier-containers" role="tab" aria-controls="carrier-containers" aria-selected="false">
                                Containers
                                <span class="badge bg-secondary ms-1">{{ count($data['carrier_data']['containers'] ?? []) }}</span>

                            </a>
                        </li>
                    </ul>

                    <!-- Tab Content (Right Column) -->
                    <div class="tab-content mt-3">
                        <!-- Carrier Movements Panel -->
                        <div class="tab-pane fade show active" id="carrier-movements" role="tabpanel" aria-labelledby="carrier-movements-tab">
                            @if(isset($data['carrier_data']['movements']))
                                <div class="text-white bg-dark p-2">
                                    <!-- PORT OF LOADING -->
                                    <div class="bg-dark p-3 text-white">
                                        <h6 class="mt-3">Port of Loading:</h6>
                                        <!-- Location -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text icon-sized">
                                                            <i class="fa fa-map-marker-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $data['carrier_data']['movements']['port_of_loading']['port_name'] ?? '-' }}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Ship & File -->
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text icon-sized">
                                                            <i class="fa fa-ship"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $data['carrier_data']['movements']['port_of_loading']['departured_vessel_name'] ?? '-' }}" readonly>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text icon-sized">
                                                            <i class="fa fa-file-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $data['carrier_data']['movements']['port_of_loading']['departured_vessel_voyage'] ?? '-' }}" readonly>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Date 1 -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text icon-sized">
                                                            <i class="fa fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $data['carrier_data']['movements']['port_of_loading']['date_of_loading']['date'] ?? '-' }}" readonly>
                                                    <div class="input-group-append">
                                                        @if($data['carrier_data']['movements']['port_of_loading']['date_of_loading']['is_actual'] === "true")
                                                            <span class="input-group-text icon-sized text-success">
                                                                <i class="fa fa-check"></i>
                                                            </span>
                                                        @else
                                                            <span class="input-group-text icon-sized text-failed">
                                                                <i class="fa fa-times"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Date 2 -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text icon-sized">
                                                            <i class="fa fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $data['carrier_data']['movements']['port_of_loading']['date_of_departure']['date'] ?? '-' }}" readonly>
                                                    <div class="input-group-append">
                                                        @if($data['carrier_data']['movements']['port_of_loading']['date_of_departure']['is_actual'] === "true")
                                                            <span class="input-group-text icon-sized text-success">
                                                                <i class="fa fa-check"></i>
                                                            </span>
                                                        @else
                                                            <span class="input-group-text icon-sized text-failed">
                                                                <i class="fa fa-times"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Transshipments -->
                                    @if(isset($data['carrier_data']['movements']['transshipments']) && count($data['carrier_data']['movements']['transshipments']) > 0)
                                        <h6 class="mt-3">Transshipments:</h6>
                                        @foreach($data['carrier_data']['movements']['transshipments'] as $transshipment)
                                            <div class="mb-2">
                                                <div class="bg-dark p-3 text-white">
                                                    <!-- Row 1: Date with check icon -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text icon-sized">
                                                                        <i class="fa fa-calendar-alt"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control" value="{{ $transshipment['date_of_arrival']['date'] ?? '-' }}" readonly>
                                                                <div class="input-group-append">
                                                                    @if($transshipment['date_of_arrival']['is_actual'] === "true")
                                                                        <span class="input-group-text icon-sized text-success">
                                                                            <i class="fa fa-check"></i>
                                                                        </span>
                                                                    @else
                                                                        <span class="input-group-text icon-sized text-failed">
                                                                            <i class="fa fa-times"></i>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Row 2: Location -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text icon-sized">
                                                                        <i class="fa fa-map-marker-alt"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control" value="{{ $transshipment['port_name'] ?? '-' }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Row 3: Ship & File -->
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text icon-sized">
                                                                        <i class="fa fa-ship"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control" value="{{ $transshipment['departured_vessel_name'] ?? '-' }}" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text icon-sized">
                                                                        <i class="fa fa-file-alt"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control" value="{{ $transshipment['departured_vessel_voyage'] ?? '-' }}" readonly>
                                                            </div>
                                                        </div>
                                                    </div>

                                                    <!-- Row 4: Date with check icon -->
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="input-group mb-2">
                                                                <div class="input-group-prepend">
                                                                    <span class="input-group-text icon-sized">
                                                                        <i class="fa fa-calendar-alt"></i>
                                                                    </span>
                                                                </div>
                                                                <input type="text" class="form-control" value="{{ $transshipment['date_of_departure']['date'] ?? '-' }}" readonly>
                                                                <div class="input-group-append">
                                                                    @if($transshipment['date_of_departure']['is_actual'] === "true")
                                                                        <span class="input-group-text icon-sized text-success">
                                                                            <i class="fa fa-check"></i>
                                                                        </span>
                                                                    @else
                                                                        <span class="input-group-text icon-sized text-failed">
                                                                            <i class="fa fa-times"></i>
                                                                        </span>
                                                                    @endif
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif

                                    <!-- PORT OF DISCHARGE -->
                                    <div class="bg-dark p-3 text-white">
                                        <h6 class="mt-3">Port of Discharge:</h6>
                                        <!-- Row 1: Date with check icon -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text icon-sized">
                                                            <i class="fa fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $data['carrier_data']['movements']['port_of_discharge']['date_of_arrival']['date'] ?? '-' }}" readonly>
                                                    <div class="input-group-append">
                                                        @if($data['carrier_data']['movements']['port_of_discharge']['date_of_arrival']['is_actual'] === "true")
                                                            <span class="input-group-text icon-sized text-success">
                                                                <i class="fa fa-check"></i>
                                                            </span>
                                                        @else
                                                            <span class="input-group-text icon-sized text-failed">
                                                                <i class="fa fa-times"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Row 2: Date with check icon -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text icon-sized">
                                                            <i class="fa fa-calendar-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $data['carrier_data']['movements']['port_of_discharge']['date_of_discharge']['date'] ?? '-' }}" readonly>
                                                    <div class="input-group-append">
                                                        @if($data['carrier_data']['movements']['port_of_discharge']['date_of_discharge']['is_actual'] === "true")
                                                            <span class="input-group-text icon-sized text-success">
                                                                <i class="fa fa-check"></i>
                                                            </span>
                                                        @else
                                                            <span class="input-group-text icon-sized text-failed">
                                                                <i class="fa fa-times"></i>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Row 3: Location -->
                                        <div class="row">
                                            <div class="col-12">
                                                <div class="input-group mb-2">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text icon-sized">
                                                            <i class="fa fa-map-marker-alt"></i>
                                                        </span>
                                                    </div>
                                                    <input type="text" class="form-control" value="{{ $data['carrier_data']['movements']['port_of_discharge']['port_name'] ?? '-' }}" readonly>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="text-white bg-dark p-2">
                                    <h6>No Movements Data Available</h6>
                                </div>
                            @endif
                        </div>

                        <!-- Carrier Containers Panel -->
                        <div class="tab-pane fade" id="carrier-containers" role="tabpanel" aria-labelledby="carrier-containers-tab">
                            <div class="text-white bg-dark p-2">
                                @if(isset($data['carrier_data']['containers']) && count($data['carrier_data']['containers']) > 0)
                                    <h6 class="mt-3">Containers:</h6>
                                    @foreach($data['carrier_data']['containers'] as $container)
                                        <div class="mb-2">
                                            <div class="bg-dark p-3 text-white">
                                                <!-- Row 1: Container Number + Badge -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text icon-sized">
                                                                <i class="fa fa-box"></i>
                                                            </span>
                                                            <input type="text" class="form-control" value="{{ $container['number'] ?? '-' }}" readonly>
                                                            <span class="input-group-text bg-warning text-dark fw-bold">
                                                                {{ $container['size'] ?? '-' }}{{ $container['type'] ?? '-' }}
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row 2: First Date -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text icon-sized">
                                                                <i class="fa fa-calendar-alt"></i>
                                                            </span>
                                                            <input type="text" class="form-control" value="{{ $container['empty_to_shipper'] ?? '-' }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row 3: Second Date -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text icon-sized">
                                                                <i class="fa fa-calendar-alt"></i>
                                                            </span>
                                                            <input type="text" class="form-control" value="{{ $container['gate_in'] ?? '-' }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row 4: Gate Out -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text icon-sized">
                                                                <i class="fa fa-truck"></i>
                                                            </span>
                                                            <input type="text" class="form-control" value="{{ $container['gate_out'] ?? '-' }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Row 5: Empty Return -->
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="input-group mb-2">
                                                            <span class="input-group-text icon-sized">
                                                                <i class="fa fa-warehouse"></i>
                                                            </span>
                                                            <input type="text" class="form-control" value="{{ $container['empty_return'] ?? '-' }}" readonly>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                @else
                                    <p>No Containers Data Available.</p>
                                @endif
                            </div>
                        </div>
                    </div> <!-- End Right Column Tab Content -->
                </div>
            </div>
        </div> <!-- End Carrier Data -->
    </div> <!-- End Row -->

    <!-- Final Result -->
    <h5>Final Result</h5>
    <div class="card bg-dark text-white">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-dark table-striped align-middle">
                    <thead>
                        <tr>
                            <th>Message</th>
                            <th class="text-center">File</th>
                            <th class="text-center">Function</th>
                            <th>Timestamp</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if(is_array($results))
                            @foreach($results as $item)
                                <tr>
                                    <td>{{ $item['message'] ?? '-' }}</td>
                                    <td class="text-center">{{ $item['caller']['file'] ?? '-' }}</td>
                                    <td class="text-center">{{ $item['caller']['function'] ?? '-' }}</td>
                                    <td>{{ $item['timestamp'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No final results found.</td>
                            </tr>
                        @endif
                    </tbody>
                    <tbody>
                        @if(is_array($exceptions))
                            @foreach($exceptions as $item)
                                <tr>
                                    <td>{{ $item['message'] ?? '-' }}</td>
                                    <td class="text-center">{{ $item['caller']['file'] ?? '-' }}</td>
                                    <td class="text-center">{{ $item['caller']['function'] ?? '-' }}</td>
                                    <td>{{ $item['timestamp'] ?? '-' }}</td>
                                </tr>
                            @endforeach
                        @else
                            <tr>
                                <td colspan="5" class="text-center">No Exceptions found.</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Raw log info / debugging -->
    <div class="mt-3">
        <small class="text-muted">
            <strong>Request ID:</strong> {{ $log->request_id }} |
            <strong>Log ID:</strong> {{ $log->log_id }}
        </small>
    </div>
</div>
@endsection

@push('styles')
<style>
    .card.bg-dark {
        background-color: #1f1f1f; /* Adjust if needed for your theme */
        border: 1px solid #333;
    }
</style>
@endpush
