<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CustomerController extends Controller
{
    /**
     * Display a listing of the customers.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $query = Customer::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->query('name') . '%');
        }

        if ($request->has('address')) {
            $query->where('address', 'like', '%' . $request->query('address') . '%');
        }

        if ($request->has('phone')) {
            $query->where('phone', 'like', '%' . $request->query('phone') . '%');
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]);
        }

        $customers = $query->get();
        return response()->json($customers);
    }

    /**
     * Store a newly created customer in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:50',
            'address' => 'required|string|min:5|max:255',
            'phone' => 'required|string|min:10|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        $customer = Customer::create($validated);
        return response()->json($customer, 201);
    }

    /**
     * Update the specified customer in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id)
    {
        $customer = Customer::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|min:3|max:50',
            'address' => 'required|string|min:5|max:255',
            'phone' => 'required|string|min:10|max:20',
            'email' => 'nullable|email|max:100',
        ]);

        $customer->update($validated);
        return response()->json($customer);
    }

    /**
     * Generate customer report (laporan) in table format
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function laporan(Request $request)
    {
        $query = Customer::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->query('name') . '%');
        }

        if ($request->has('address')) {
            $query->where('address', 'like', '%' . $request->query('address') . '%');
        }

        if ($request->has('phone')) {
            $query->where('phone', 'like', '%' . $request->query('phone') . '%');
        }

        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('created_at', [$request->query('start_date'), $request->query('end_date')]);
        }

        $customers = $query->get();
        $table = [];

        foreach ($customers as $customer) {
            $table[] = [
                'ID' => $customer->id,
                'Name' => $customer->name,
                'Address' => $customer->address,
                'Phone' => $customer->phone,
                'Email' => $customer->email,
                'Created At' => $customer->created_at->toDateString(),
            ];
        }

        return response()->json([
            'report_title' => 'Customer Report',
            'report_date' => now()->toDateString(),
            'table' => $table
        ]);
    }

    /**
     * Generate chart data for customers
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function chart()
    {
        $customers = Customer::select(DB::raw('MONTH(created_at) as month'), DB::raw('COUNT(*) as count'))
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $labels = [];
        $data = [];

        // Initialize all months with zero count
        for ($i = 1; $i <= 12; $i++) {
            $labels[] = date('F', mktime(0, 0, 0, $i, 1));
            $data[] = 0;
        }

        // Fill in actual counts
        foreach ($customers as $customer) {
            $data[$customer->month - 1] = $customer->count;
        }

        return response()->json([
            'labels' => $labels,
            'data' => $data
        ]);
    }

    /**
     * Generate PDF report for customers
     * 
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function print(Request $request)
    {
        $query = Customer::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->query('name') . '%');
        }

        if ($request->has('address')) {
            $query->where('address', 'like', '%' . $request->query('address') . '%');
        }

        if ($request->has('phone')) {
            $query->where('phone', 'like', '%' . $request->query('phone') . '%');
        }

        $customers = $query->get();

        // Here you would typically generate a PDF using a library like DOMPDF
        // For this example, we'll just return a JSON response
        return response()->json([
            'message' => 'PDF generation would happen here',
            'customers' => $customers
        ]);
    }
}
