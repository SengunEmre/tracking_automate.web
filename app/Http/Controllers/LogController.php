<?php

namespace App\Http\Controllers;
use App\Models\Log; 
use Illuminate\Http\Request;

class LogController extends Controller
{

    public function index(Request $request)
    {
        $query = Log::query();
    
        // Filter by logger_name if provided
        if ($request->filled('logger_name')) {
            $query->where('logger_name', 'like', '%' . $request->logger_name . '%');
        }
        
        // Filter by request_id if provided
        if ($request->filled('request_id')) {
            $query->where('request_id', $request->request_id);
        }
    
        // Filter by update_status if provided
        if ($request->filled('update_status')) {
            $query->where('update_status', $request->update_status);
        }
    
        // Filter by email_status if provided
        if ($request->filled('email_status')) {
            $query->where('email_status', $request->email_status);
        }
    
        // Order and paginate results
        $logs = $query->select('log_id', 'logger_name', 'request_id', 'exception_status', 'email_status', 'update_status', 'timestamp')
                      ->orderBy('log_id', 'desc')
                      ->paginate(25);
    
        // Append query parameters to pagination links so filters persist on page change
        $logs->appends($request->all());
    
        return view('logs.index', compact('logs'));
    }
    
    public function showByRequest($request_id)
    {
    // Query logs where the 'request' column matches the provided request_id
    $logs = Log::where('request_id', $request_id)
               ->orderBy('log_id', 'desc')
               ->paginate(25);

    // Reuse the same 'logs.index' view (or create a separate view if you prefer)
    return view('logs.index', compact('logs'));
    }
    public function show($request_id, $log_id)
    {
        // 1. Fetch the log entry by request_id + log_id
        $log = Log::where('request_id', $request_id)
                  ->where('log_id', $log_id)
                  ->firstOrFail();
    
        // 2. Decode the JSON data
        $data = json_decode($log->data, true);
        $finalResults = json_decode($log->logs, true);
        $exceptions = json_decode($log->exceptions, true);
    
        // 3. Load and convert the vessel mapping JSON file
        $vesselJson = file_get_contents(storage_path('app/vessel_data.json'));
        $vesselList = json_decode($vesselJson, true);
        $vesselMapping = [];
        if (isset($vesselList['vessel_data']) && is_array($vesselList['vessel_data'])) {
            foreach ($vesselList['vessel_data'] as $vessel) {
                if (isset($vessel['id'], $vessel['name'])) {
                    $vesselMapping[$vessel['id']] = $vessel['name'];
                }
            }
        }
        
        // 4. Load and convert the port mapping JSON file
        $portsJson = file_get_contents(storage_path('app/ports.json'));
        $portsArray = json_decode($portsJson, true);
        $portMapping = [];
        if (isset($portsArray['ports']) && is_array($portsArray['ports'])) {
            foreach ($portsArray['ports'] as $port) {
                if (isset($port['id'], $port['name'])) {
                    $portMapping[$port['id']] = $port['name'];
                }
            }
        }
    
        // 5. Helper function to update data with mapping names
        $updateDataWithNames = function (&$sourceData) use ($portMapping, $vesselMapping) {
            if (isset($sourceData['movements'])) {
                // Update port_of_loading
                if (isset($sourceData['movements']['port_of_loading'])) {
                    $portLoading = &$sourceData['movements']['port_of_loading'];
                    if (isset($portLoading['port_id']) && isset($portMapping[$portLoading['port_id']])) {
                        $portLoading['port_name'] = $portMapping[$portLoading['port_id']];
                    }
                    if (isset($portLoading['departured_vessel_id']) && isset($vesselMapping[$portLoading['departured_vessel_id']])) {
                        $portLoading['departured_vessel_name'] = $vesselMapping[$portLoading['departured_vessel_id']];
                    }
                }
                // Update port_of_discharge
                if (isset($sourceData['movements']['port_of_discharge'])) {
                    $portDischarge = &$sourceData['movements']['port_of_discharge'];
                    if (isset($portDischarge['port_id']) && isset($portMapping[$portDischarge['port_id']])) {
                        $portDischarge['port_name'] = $portMapping[$portDischarge['port_id']];
                    }
                }
                // Update transshipments (if any)
                if (isset($sourceData['movements']['transshipments']) && is_array($sourceData['movements']['transshipments'])) {
                    foreach ($sourceData['movements']['transshipments'] as &$transshipment) {
                        if (isset($transshipment['port_id']) && isset($portMapping[$transshipment['port_id']])) {
                            $transshipment['port_name'] = $portMapping[$transshipment['port_id']];
                        }
                        if (isset($transshipment['departured_vessel_id']) && isset($vesselMapping[$transshipment['departured_vessel_id']])) {
                            $transshipment['departured_vessel_name'] = $vesselMapping[$transshipment['departured_vessel_id']];
                        }
                    }
                }
            }
        };
    
        // 6. Update both carrier_data and shipsgo_data (if they exist)
        if (isset($data['carrier_data'])) {
            $updateDataWithNames($data['carrier_data']);
        }
        if (isset($data['shipsgo_data'])) {
            $updateDataWithNames($data['shipsgo_data']);
        }
        
        //dd($data['shipsgo_data']['containers']);
        // 7. Pass the updated data to the view
        return view('logs.show', [
            'log'        => $log,
            'data'       => $data,
            'results'    => $finalResults,
            'exceptions' => $exceptions
        ]);
    }
    
    
}
