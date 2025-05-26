<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:50',
            'description' => 'nullable|string|max:255',
        ]);
        $category = Category::create($validated);
        return response()->json($category, 201);
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, $id)
    {
        $category = Category::findOrFail($id);
        $validated = $request->validate([
            'name' => 'required|string|min:3|max:50',
            'description' => 'nullable|string|max:255',
        ]);
        $category->update($validated);
        return response()->json($category);
    }
    public function index()
    {
        return response()->json(Category::all());
    }

    /**
     * Get chart data for categories
     * 
     * @return \Illuminate\Http\JsonResponse
     */
    public function chart()
    {
        // For demo purposes, we'll create some sample data
        // In a real application, you would query the database for actual data
        // related to categories (e.g., number of products per category)
        $categories = Category::all();

        $labels = $categories->pluck('name')->toArray();
        $data = [];

        // Generate random data for demonstration
        foreach ($categories as $category) {
            $data[] = rand(5, 30); // Random values between 5 and 30
        }

        return response()->json([
            'labels' => $labels,
            'datasets' => [
                [
                    'label' => 'Jumlah Item per Kategori',
                    'data' => $data,
                    'backgroundColor' => [
                        'rgba(255, 99, 132, 0.2)',
                        'rgba(54, 162, 235, 0.2)',
                        'rgba(255, 206, 86, 0.2)',
                        'rgba(75, 192, 192, 0.2)',
                        'rgba(153, 102, 255, 0.2)',
                    ],
                    'borderColor' => [
                        'rgba(255, 99, 132, 1)',
                        'rgba(54, 162, 235, 1)',
                        'rgba(255, 206, 86, 1)',
                        'rgba(75, 192, 192, 1)',
                        'rgba(153, 102, 255, 1)',
                    ],
                    'borderWidth' => 1
                ]
            ]
        ]);
    }
}
