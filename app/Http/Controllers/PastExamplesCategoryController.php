<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\PastExamplesCategory;

class PastExamplesCategoryController extends Controller
{



    public function index()
    {
        $categories = PastExamplesCategory::all();
        return view('past-examples-category.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('past-examples-category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|unique:categories',
        ]);

        PastExamplesCategory::create($validatedData);

        return redirect()->route('past-examples-category.index')->with('success', 'カテゴリが正常に作成されました.');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PastExamplesCategory  $pastExamplesCategory)
    {

        return view('past-examples-category.edit', ['category' => $pastExamplesCategory]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PastExamplesCategory $pastExamplesCategory)
    {
        $validatedData = $request->validate([
            'name' => [
                'required',
                'unique:past_examples_category,name,' . $pastExamplesCategory->id,
            ],
        ]);

        $pastExamplesCategory->update($validatedData);

        return redirect()->route('past-examples-category.index')
            ->with('success', 'カテゴリが正常に更新されました。');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PastExamplesCategory $pastExamplesCategory)
    {
        $pastExamplesCategory->delete();
        return redirect()->route('past-examples-category.index')->with('success', 'カテゴリが正常に削除されました。');
    }
}
