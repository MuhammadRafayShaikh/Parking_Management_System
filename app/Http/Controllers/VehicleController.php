<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Mail\outmail;
use App\Models\Vehicle;
use App\Models\Category;
use App\Mail\welcomemail;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;

class VehicleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $vehicle = Vehicle::with('category')->where('status', 0)->get();

        return response()->json([
            'status' => true,
            'message' => 'All Vehicles',
            'vehicles' => $vehicle
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */

    public function store(Request $request)
    {

        $vehicleValidation = validator($request->all(), [
            'category_id' => 'required|numeric',
            'vehicle_company' => 'required',
            'registration_number' => 'required',
            'owner_name' => 'required',
            'owner_contact' => 'required|string',
            'owner_email' => 'required|email',
            'intime' => 'required',
        ]);

        if ($vehicleValidation->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'error' => $vehicleValidation->errors()->all()
            ], 401);
        }


        try {
            $intime = Carbon::parse(preg_replace('/\s*\(.*\)$/', '', $request->intime))->format('Y-m-d H:i:s');
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Invalid date format',
                'error' => $e->getMessage()
            ], 400);
        }

        // Create a new vehicle record
        $vehicle = Vehicle::create([
            'parking_number' => random_int(1000, 10000),
            'category_id' => $request->category_id,
            'vehicle_company' => $request->vehicle_company,
            'registration_number' => $request->registration_number,
            'owner_name' => $request->owner_name,
            'owner_contact' => $request->owner_contact,
            'owner_email' => $request->owner_email,
            'intime' => $intime,
            'outtime' => null,
            'charges' => 0,
            'status' => 0
        ]);

        Mail::to($request->owner_email)->send(new welcomemail('Hello', 'Your Vehicle is our responsibility'));

        if ($vehicle) {
            return response()->json([
                'status' => true,
                'message' => 'Vehicle Added Successfully',
                'vehicle' => $vehicle
            ], 200);
        }

        // Fallback in case of failure
        return response()->json([
            'status' => false,
            'message' => 'Failed to add vehicle',
        ], 500);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $vehicle = Vehicle::with('category')->findOrFail($id);


        return response()->json([
            'status' => true,
            'message' => 'Single Vehicle',
            'vehicle' => $vehicle
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // return $request;

        $vehcileValidation = validator($request->all(), [
            'outtime' => 'required',
            'charges' => 'required',
            'vehicle_status' => 'required'
        ]);

        $vehicle = Vehicle::find($id);

        if ($vehicle->status == 1) {
            return redirect()->route('vehicle')->with('error', 'Already Updated');
        } else {
            $vehicle->update([
                'outtime' => $request->outtime,
                'charges' => $request->charges,
                'status' => $request->vehicle_status
            ]);

            Mail::to($vehicle->owner_email)->send(new outmail('Thanks','Thanks To Park Your Vehicle'));

            if ($vehicle) {
                return redirect()->route('outgoingvehicle')->with('status', 'Successfully Updated Vehicle');
            }
        }
    }

    public function index2()
    {
        $vehicle = Vehicle::with('category')->where('status', 1)->get();

        return response()->json([
            'status' => true,
            'message' => 'All Outgoing Vehicles',
            'vehicles' => $vehicle
        ], 200);
    }

    public function dashboardData()
    {
        $category = Category::count();
        $incoming = Vehicle::count();
        $vehicle = Vehicle::orderBy('id', 'DESC')->limit(1)->where('status', 0)->get();
        $todayincoming = Vehicle::whereDate('intime', Carbon::today())->count();
        $todayoutgoing = Vehicle::whereDate('outtime', Carbon::today())->count();

        // $todayIncoming = Vehicle::where('intime',);

        if ($vehicle->count() > 0) {
            return response()->json([
                'status' => true,
                'message' => 'Latest Incoming Vehicles',
                'vehicles' => $vehicle,
                'category' => $category,
                'incoming' => $incoming,
                'todayincoming' => $todayincoming,
                'todayoutgoing' => $todayoutgoing
            ], 200);
        } else {
            return response()->json([
                'status' => true,
                'message' => 'No Vehicle Found'
            ], 200);
        }
    }

    public function filter(Request $request)
    {
        $from_date = Carbon::parse($request->from_date)->format('Y-m-d H:i:s');
        $to_date = Carbon::parse($request->to_date)->format('Y-m-d H:i:s');


        $query = Vehicle::query();


        if ($request->search_type == 1) {
            $query->where('status', 0)->whereBetween('intime', [$from_date, $to_date]);
        } elseif ($request->search_type == 2) {
            $query->where('status', 1)->whereBetween('outtime', [$from_date, $to_date]);
        } elseif ($request->search_type === "user_name") {
            $query->where('owner_name', 'like', '%' . $request->user_name . '%');
        } elseif ($request->search_type === "phone_number") {
            $query->where('owner_contact', 'like', '%' . $request->phone_number . '%');
        } elseif ($request->search_type === "vehicle_number") {
            $query->where('registration_number', 'like', '%' . $request->vehicle_number . '%');
        } else {
            $query->get();
        }


        $vehicles = $query->get();
        $total = $vehicles->sum('charges');


        if ($vehicles->isNotEmpty()) {
            return response()->json([
                'from_date' => $from_date,
                'to_date' => $to_date,
                'search_type' => $request->search_type,
                'vehicle_number' => $request->vehicle_number,
                'user_name' => $request->user_name,
                'phone_number' => $request->phone_number,
                'vehicles' => $vehicles,
                'charges' => $total
            ]);
        } else {
            return response()->json(['message' => 'No Vehicles Found']);
        }
    }


    public function downloadPdf(Request $request)
    {
        $from_date = $request->from_date;
        $to_date = $request->to_date;
        $search_type = $request->search_type;
        $user_name = $request->user_name;
        $phone_number = $request->phone_number;
        $vehicle_number = $request->vehicle_number;

        $query = Vehicle::query();

        if ($search_type == 1) {
            $query->where('status', 0)->whereBetween('intime', [$from_date, $to_date]);
        } elseif ($search_type == 2) {
            $query->where('status', 1)->whereBetween('outtime', [$from_date, $to_date]);
        } elseif ($search_type === "user_name") {
            $query->where('owner_name', 'like', '%' . $user_name . '%');
        } elseif ($search_type === "phone_number") {
            $query->where('owner_contact', 'like', '%' . $phone_number . '%');
        } elseif ($search_type === "vehicle_number") {
            $query->where('registration_number', 'like', '%' . $vehicle_number . '%');
        }

        $vehicles = $query->get();
        $total = $vehicles->sum('charges');

        $pdf = Pdf::loadView('pdf.report', compact('vehicles', 'from_date', 'to_date', 'total'));

        return $pdf->download('filtered_report.pdf');
    }

    public function pdf2()
    {
        $vehicles = Vehicle::where('status', 0)->get();

        $pdf = Pdf::loadView('pdf.report2', compact('vehicles'));

        return $pdf->download('incoming_vehicles.pdf');
    }

    public function pdf3()
    {
        $vehicles = Vehicle::where('status', 1)->get();

        $total = $vehicles->sum('charges');

        $pdf = Pdf::loadView('pdf.report3', compact('vehicles', 'total'));

        return $pdf->download('outgoing_vehicles.pdf');
    }

    public function pdf4(string $id)
    {
        $vehicle = Vehicle::find($id);

        $total = $vehicle->sum('charges');

        $pdf = Pdf::loadView('pdf.report4', compact('vehicle', 'total'));

        return $pdf->download('outgoing' . '_' . $vehicle->owner_name . '_' . 'vehicle.pdf');
    }

    public function pdf5(string $id)
    {
        $vehicle = Vehicle::find($id);

        $pdf = Pdf::loadView('pdf.report5', compact('vehicle'));

        return $pdf->download('incoming' . '_' . $vehicle->owner_name . '_' . 'vehicle.pdf');
    }

    public function pdf6()
    {
        $category = Category::all();

        $pdf = Pdf::loadView('pdf.report6', compact('category'));

        return $pdf->download('categories.pdf');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
