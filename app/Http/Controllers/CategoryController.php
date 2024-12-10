<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $category = Category::all();

        return response()->json([
            'status' => true,
            'message' => 'All Categories',
            'category' => $category
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // return $request;

        $categoryValidation = validator($request->all(), [
            'category_name' => 'required',
            'parking_charge' => 'required|numeric',
            'category_status' => 'required|boolean'
        ]);

        if ($categoryValidation->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Failed',
                'error' => $categoryValidation->errors()->all(),
            ], 401);
        }

        $category = Category::create([
            'category_name' => $request->category_name,
            'parking_charge' => $request->parking_charge,
            'category_status' => $request->category_status
        ]);

        if ($category) {
            return response()->json([
                'status' => true,
                'message' => 'Category Added Successfully',
                'category' => $category->category_name,
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Category Not Added',
            ], 400);
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $category = Category::find($id);

        return response()->json([
            'status' => true,
            'message' => 'Single Category',
            'category' => $category
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        try {
            // Validate request data
            $request->validate([
                'category_name' => 'required|string|max:255',
                'parking_charges' => 'required|numeric', // Ensure this matches the field name in JavaScript
                'category_status' => 'required|boolean',
            ]);

            $category = Category::findOrFail($id); // This will throw a ModelNotFoundException if not found

            $category->update([
                'category_name' => $request->category_name,
                'parking_charge' => $request->parking_charges, // Ensure this matches your database column
                'category_status' => $request->category_status,
            ]);

            return response()->json([
                'status' => true,
                'message' => 'Updated Successfully'
            ], 200);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'status' => false,
                'message' => 'Validation Error',
                'errors' => $e->validator->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'Error: ' . $e->getMessage() // More details about the error
            ], 500);
        }
    }



    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $category = Category::find($id);

        $category->delete();

        if ($category) {
            return response()->json([
                'status' => true,
                'message' => 'Deleted Successfully',
                'category' => $category
            ]);
        }
    }
}
