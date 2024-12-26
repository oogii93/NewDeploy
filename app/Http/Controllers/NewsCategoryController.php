<?php

namespace App\Http\Controllers;

use Log;
use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    public function index()
    {
        $newsCategories=NewsCategory::all();
        return view('inner-news.news-category.index',compact('newsCategories'));
    }

    public function create()
    {
        return view('inner-news.news-category.create');
    }


    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'fields' => 'required'
            ]);

            // \Log::info('Request data:', $request->all());

            $fields=json_decode($request->fields, true);
                if(!is_array($fields)){
                    throw new \Exception('invalid fields format');


                }

            $category=NewsCategory::create([
                'name'=>$request->name,
                'fields'=>$fields
            ]);

            return redirect()->route('inner-news.news-category.index')
                ->with('success', 'ニュースカテゴリが正常に作成されました');


            } catch (\Exception $e) {
                return back()
                    ->withInput()
                    ->withErrors(['error' => 'Failed to create category: ' . $e->getMessage()]);
            }
    }


    public function show()
    {

    }


    public function edit($id)
    {

        $newsCategory = NewsCategory::findOrFail($id);//singular
        return view('inner-news.news-category.edit',compact('newsCategory'));
    }


    public function update(Request $request, NewsCategory $category)
    {
        $request->validate([
            'name'=>'required',
            'fields'=>'required|json',
        ]);

        $category->update([
            'name'=>$request->name,
            'fields'=>json_decode($request->fields, true),
        ]);

        return redirect()->route('inner-news.news-category.index')->with('success', 'ニュースカテゴリが正常に更新されました');

    }


    public function destroy(NewsCategory $category)
    {
        $category->delete();
        return redirect()->route('inner-news.news-category.index')->with('success', 'ニュースカテゴリが正常に削除されました');
    }



}
