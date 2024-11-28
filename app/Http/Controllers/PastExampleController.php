<?php

namespace App\Http\Controllers;

use App\Models\PastExample;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PastExampleController extends Controller
{
    /**
     * Display a listing of the past examples.
     */
    public function index()
    {
        $pastExamples = PastExample::latest()->paginate(10);
        return view('admin.past-examples.index', compact('pastExamples'));
    }

    /**
     * Show the form for creating a new past example.
     */
    public function create()
    {
        return view('admin.past-examples.create');
    }

    /**
     * Store a newly created past example in storage.
     */
    public function store(Request $request)
    {
        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required', // Corrected spelling

        ]);

        // Handle multiple image uploads

        $content=$request->input('description');

        $pastExample = PastExample::create([
            'title' => $validatedData['title'],
            'description' => $content,
        ]);

        // Create the past example


        return redirect()->route('admin.past-examples.index')
            ->with('success', 'Past example created successfully.');
    }

    private function processContentImages($content)
    {
        // Create a new DOM document
        $dom = new DOMDocument();

        // Suppress warnings for malformed HTML
        @$dom->loadHTML(mb_convert_encoding($content, 'HTML-ENTITIES', 'UTF-8'), LIBXML_HTML_NOIMPLIED | LIBXML_HTML_NODEFDTD);

        $images = $dom->getElementsByTagName('img');

        foreach ($images as $key => $img) {
            // Check if image is base64
            if (strpos($img->getAttribute('src'), 'data:image') === 0) {
                // Generate unique filename
                $filename = 'past-examples/' . Str::uuid() . '.png';

                // Extract base64 image data
                $data = explode(',', $img->getAttribute('src'))[1];
                $decodedData = base64_decode($data);

                // Store image
                Storage::disk('public')->put($filename, $decodedData);

                // Replace src with new path
                $img->setAttribute('src', Storage::url($filename));
            }
        }

        // Save modified content
        return $dom->saveHTML();
    }

    public function uploadImage(Request $request)
    {
        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $filename = 'past-examples/' . Str::uuid() . '.' . $image->getClientOriginalExtension();

            // Store image
            $path = $image->storeAs('public/' . $filename);

            // Return URL for Summernote
            return response()->json([
                'status' => true,
                'url' => Storage::url($filename)
            ]);
        }

        return response()->json([
            'status' => false,
            'message' => 'No image uploaded'
        ]);
    }







    /**
     * Display the specified past example.
     */
    public function show(PastExample $pastExample)
    {
        return view('admin.past-examples.show', compact('pastExample'));
    }

    /**
     * Show the form for editing the specified past example.
     */
    public function edit(PastExample $pastExample)
    {
        return view('admin.past-examples.edit', compact('pastExample'));
    }

    /**
     * Update the specified past example in storage.
     */
    public function update(Request $request, PastExample $pastExample)
    {
        // Validate the request
        $validatedData = $request->validate([
            'title' => 'required|max:255',
            'description' => 'required',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif|max:2048',
            'remove_images' => 'array' // Optional: for removing existing images
        ]);

        // Handle existing images
        $currentImages = $pastExample->images ?? [];

        // Remove specified images
        if ($request->has('remove_images')) {
            foreach ($request->input('remove_images') as $imageToRemove) {
                // Remove from storage
                if (($key = array_search($imageToRemove, $currentImages)) !== false) {
                    Storage::disk('public')->delete($imageToRemove);
                    unset($currentImages[$key]);
                }
            }
        }

        // Handle new image uploads
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $path = $image->store('past_examples', 'public');
                $currentImages[] = $path;
            }
        }

        // Update the past example
        $pastExample->update([
            'title' => $validatedData['title'],
            'description' => $validatedData['description'],
            'images' => array_values($currentImages) // Reset array keys
        ]);

        return redirect()->route('past-examples.index')
            ->with('success', 'Past example updated successfully.');
    }

    /**
     * Remove the specified past example from storage.
     */
    public function destroy(PastExample $pastExample)
    {
        // Delete associated images
        if ($pastExample->images) {
            foreach ($pastExample->images as $imagePath) {
                Storage::disk('public')->delete($imagePath);
            }
        }

        // Delete the past example
        $pastExample->delete();

        return redirect()->route('admin.past-examples.index')
            ->with('success', 'Past example deleted successfully.');
    }

    /**
     * Search past examples
     */
    public function search(Request $request)
    {
        $query = PastExample::query();

        // Search by title or description
        if ($request->filled('search')) {
            $searchTerm = $request->input('search');
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', "%{$searchTerm}%")
                  ->orWhere('description', 'like', "%{$searchTerm}%");
            });
        }

        $pastExamples = $query->latest()->paginate(10);

        return view('admin.past-examples.index', compact('pastExamples'));
    }
}
