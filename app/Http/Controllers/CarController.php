<?php

namespace App\Http\Controllers;

use App\Models\Car;
use Illuminate\Http\Request;

class CarController extends Controller
{
    public function index(Request $request)
    {


        $searchQuery=$request->input('search');

        $carData = Car::where(function($query) use ($searchQuery) {
            $query->where('car_id', 'like', '%' . $searchQuery . '%')
                  ->orWhere('number_plate', 'like', '%' . $searchQuery . '%')
                  ->orWhere('car_type', 'like', '%' . $searchQuery . '%')
                  ->orWhere('car_made_year', 'like', '%' . $searchQuery . '%')
                  ->orWhere('car_insurance_company', 'like', '%' . $searchQuery . '%')
                  ->orWhere('car_insurance_start', 'like', '%' . $searchQuery . '%')
                  ->orWhere('car_insurance_end', 'like', '%' . $searchQuery . '%')
                  ->orWhere('etc', 'like', '%' . $searchQuery . '%')
                  ->orWhere('car_detail', 'like', '%' . $searchQuery . '%');
        })->paginate(20); //




        $cars = Car::all();
        return view('car.index', compact('cars','carData'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('car.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'car_id' => 'nullable|string|max:255',
            'number_plate' => 'nullable|string|max:255',
            'car_type' => 'nullable|string|max:255',
            'car_made_year' => 'nullable|string|max:4',
            'car_insurance_company' => 'nullable|string|max:255',
            'car_insurance_start' => 'nullable|date',
            'car_insurance_end' => 'nullable|date',
            'etc' => 'nullable|string|max:255',
            'image_path' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'car_detail' => 'nullable|string',
        ]);

        if ($request->hasFile('image_path')) {
            $imageName = time().'.'.$request->image_path->extension();
            $request->image_path->move(public_path('images'), $imageName);
            $validatedData['image_path'] = 'images/' . $imageName;
        }

        Car::create($validatedData);

        return redirect()->route('car.index')->with('success', '車が正常に作成されました.');
    }


    /**
     * Display the specified resource.
     */
    public function show($id)
    {
        $car = Car::findOrFail($id);
        return view('car.show', compact('car'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $car = Car::findOrFail($id);
        return view('car.edit', compact('car'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $car = Car::findOrFail($id);

        $validatedData = $request->validate([
            'car_id' => 'nullable|string|max:255',
            'number_plate' => 'nullable|string|max:255',
            'car_type' => 'nullable|string|max:255',
            'car_made_year' => 'nullable|string|max:4',
            'car_insurance_company' => 'nullable|string|max:255',
            'car_insurance_start' => 'nullable|date',
            'car_insurance_end' => 'nullable|date',
            'etc' => 'nullable|string|max:255',
            'image_path' => 'nullable|string|max:255',
            'car_detail' => 'nullable|string',
        ]);

        $car->update($validatedData);

        return redirect()->route('car.index')->with('success', '車が正常に更新されました.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $car = Car::findOrFail($id);
        $car->delete();

        return redirect()->route('car.index')->with('success', '車が正常に削除されました.');
    }
}
