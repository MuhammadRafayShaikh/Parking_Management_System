<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function addCategory()
    {
        return view('add-vehicle-category');
    }
    public function editCategory(string $id)
    {
        $cateogry = Category::find($id);
        // return $cateogry;
        return view('update-vehicle-category', compact('cateogry'));
    }

    public function viewvehicle(string $id)
    {
        $vehicle = Vehicle::find($id);
        return view('view-vehicle', compact('vehicle'));
    }

    public function addVehicle()
    {
        $category = Category::all();
        return view('add-vehicle', compact('category'));
    }

    public function outgoingvehicle()
    {
        return view('manage-outgoingvehicle');
    }

    public function viewoutgoingvehicle(string $id)
    {
        $vehicle = Vehicle::find($id);
        return view('view-outgoingvehicle', compact('vehicle'));
    }


    public function reports()
    {
        return view('reports');
    }
}
