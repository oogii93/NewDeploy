<?php

namespace App\Http\Controllers;

use App\Models\InnerNews;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class InnerNewsController extends Controller
{


    // public function index(Request $request)
    // {
    //     $query=InnerNews::query();

    //     if($request->filled('search')){
    //         $query->where('title', 'like','%' . $request->search . '%')
    //             ->orWhere('content', 'like', '%' . $request->search . '%');
    //     }

    //     if($request->filled('category_id')){
    //         $query->whereRaw('JSON_CONTAINS(categories_data, \'{"category_id": ' . $request->category_id . '}\', "$[*]")');
    //     }
    // }
    public function index(){

        $innerNews = InnerNews::all();
        return view('inner-news.index', compact('innerNews'));
    }


    public function create(){

        $categories=NewsCategory::all();
        return view('inner-news.create',compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([

            'categories_data' => 'required|array'
        ]);

        try {
            $categoriesData = [];
            foreach ($request->categories_data as $index => $categoryData) {
                if (empty($categoryData['category_id'])) continue;

                $category = NewsCategory::findOrFail($categoryData['category_id']);

                $categoriesData[] = [
                    'category_id' => $category->id,
                    'fields' => $categoryData['fields'] ?? []
                ];
            }

            $innerNews = InnerNews::create([

                'categories_data' => $categoriesData
            ]);

            return redirect()
                ->route('inner-news.index')
                ->with('success', '社内ニュースが作成されました。');
        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->withErrors(['error' => '作成に失敗しました: ' . $e->getMessage()]);
        }
    }

 public function edit($id)
 {
    $innerNews=InnerNews::findOrFail($id);
    $categories=NewsCategory::all();

    if (is_string($innerNews->categories_data)) {
        $innerNews->categories_data = json_decode($innerNews->categories_data, true);
    }
    return view('inner-news.edit', compact('innerNews', 'categories'));
 }


 public function update(Request $request, $id)
 {
     $request->validate([

         'categories_data' => 'required|array'
     ]);

     try {
         $innerNews = InnerNews::findOrFail($id);
         $categoriesData = [];

         foreach ($request->categories_data as $index => $categoryData) {
             if (empty($categoryData['category_id'])) continue;

             $category = NewsCategory::findOrFail($categoryData['category_id']);

             $categoriesData[] = [
                 'category_id' => (int)$category->id,
                 'fields' => isset($categoryData['fields']) ? $categoryData['fields'] : []
             ];
         }

         // Ensure we're storing as JSON
         $innerNews->update([

             'categories_data' => json_encode($categoriesData)
         ]);

         return redirect()
             ->route('inner-news.index')
             ->with('success', '社内ニュースが更新されました。');
     } catch (\Exception $e) {
         \Log::error('Update error: ' . $e->getMessage());
         return back()
             ->withInput()
             ->withErrors(['error' => '更新に失敗しました: ' . $e->getMessage()]);
     }
 }
    public function show($id)
    {
        $innerNews=InnerNews::findOrFail($id);
        return view('inner-news.show', compact('innerNews'));
    }


    public function destroy($id)
    {
        $innerNews = InnerNews::find($id);
        $innerNews->delete();

        return redirect()->route('inner-news.index');
    }
}
