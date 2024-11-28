<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use App\Models\Corp;
use App\Models\Post;
use App\Models\User;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Models\PostAttachment;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Notifications\NewPostNotification;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $categories = Category::all();

        $userCorpId=Auth::user()->corp_id;


        // Search query
        $searchQuery = $request->input('search');

        if ($request->has('category')) {
            $category = Category::findOrFail($request->input('category'));
            $posts = $category->posts();
        } else {
            $posts = Post::query();
        }

        $posts->where(function ($query) use ($userCorpId){
            $query->whereHas('corps', function ($q) use ($userCorpId){
                $q->where('corps.id', $userCorpId);
            }) ->orWhereDoesntHave('corps');
        });

        // Apply search query
        if ($searchQuery) {
            $posts->where(function ($query) use ($searchQuery) {
                $query->where('title', 'like', '%' . $searchQuery . '%')
                    ->orWhere('content', 'like', '%' . $searchQuery . '%')
                    ->orWhereHas('category', function ($q) use ($searchQuery) {
                        $q->where('name', 'like', '%' . $searchQuery . '%');
                    })
                    ->orWhereHas('user', function ($q) use ($searchQuery) {
                        $q->where('name', 'like', '%' . $searchQuery . '%');
                    });
            });
        }

        $posts = $posts->latest()->paginate(8);

        return view('posts.index', compact('posts', 'categories', 'searchQuery'));
    }

    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();

        $corps=Corp::all();
        // dd([
        //     'category'=>$categories,
        //     'tags'=>$tags,
        //     'corps'=>$corps,
        // ]);
        return view('posts.create', compact('categories','tags', 'corps'));
    }

    public function uploadImage(Request $request)
{
    if ($request->hasFile('image')) {
        $path = $request->file('image')->store('summernote', 'public');
        return response()->json(['url' => Storage::url($path)]);
    }
    return response()->json(['error' => 'No image uploaded'], 400);
}


    public function store(Request $request)
    {
        // dd($request->all());
        try {
            Log::info('Store method called', ['request' => $request->all()]);

            $validatedData = $request->validate([
                'title' => 'required',
                'category_id' => 'required|exists:categories,id',
                'tags' => 'nullable|array',
                'content' => 'required',
             'attachments.*' => 'nullable|file|max:50240',

             'corps' => 'required|array', // Add this validation
             'corps.*' => 'exists:corps,id', // Add this validation
             'notify_all_corps' => 'nullable|boolean', // Add this for the "notify all" option
            ]);

            // dd($request->all());

            Log::info('Validation passed', ['validatedData' => $validatedData]);

            $post = new Post;
            $post->title = $validatedData['title'];
            $post->content = $validatedData['content'];
            $post->category_id = $validatedData['category_id'];
            $post->user_id = Auth::id();
            $post->save();



if($request->has('notify_all_corps') && $request->notify_all_corps =='1'){

            Log::info('Notifying all corps');

    User::chunk(100, function ($users) use ($post){
            foreach($users as $user) {
                $user->notify(new NewPostNotification($post));
            }

    });


            }else{

                Log::info('Notifying specific corps', ['corps' => $request->corps]);

                if ($request->has('corps')) {
                    $post->corps()->attach($request->corps);
                }



                       // Notify users from selected corps
            User::whereIn('corp_id', $request->corps)
            ->chunk(100, function ($users) use ($post) {
                foreach ($users as $user) {
                    $user->notify(new NewPostNotification($post));
                }
            });

                //


            }


            // Send notification to all users

            // User::all()->each(function ($user) use ($post) {
            //     $user->notify(new NewPostNotification($post));
            // });

            // Log::info('Post created', ['post' => $post]);

            if($request->hasFile('attachments')){
                Log::info('Attachments found', ['count' => count($request->file('attachments'))]);
                foreach($request->file('attachments') as $file){
                    $originalName = $file->getClientOriginalName();
                    $extension = $file->getClientOriginalExtension();
                    $mimeType = $file->getMimeType();

                    Log::info('Processing file', [
                        'original_name' => $originalName,
                        'extension' => $extension,
                        'mime_type' => $mimeType
                    ]);

                    $path = $file->store('attachments', 'public');

                    Log::info('File uploaded', [
                        'original_name' => $originalName,
                        'stored_path' => $path,
                        'mime_type' => $mimeType
                    ]);

                    PostAttachment::create([
                        'post_id' => $post->id,
                        'file_name' => $originalName,
                        'file_path' => $path,
                        'file_type' => $extension,
                    ]);

                    Log::info('PostAttachment created', ['file_name' => $originalName]);
                }
            } else {
                Log::info('No attachments found');
            }



            if (isset($validatedData['tags'])) {
                $post->tags()->attach($validatedData['tags']);
                Log::info('Tags attached', ['tags' => $validatedData['tags']]);
            }

            Log::info('Store method completed successfully');

            return redirect()->route('posts.index')->with('success', 'Post created successfully!');


        } catch (\Exception $e) {
            Log::error('Error in store method', [
                'message' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);



            return back()->withErrors(['error' => 'An error occurred while creating the post: ' . $e->getMessage()])->withInput();
        }
    }


public function download($id)
{
    $attachment = PostAttachment::findOrFail($id);

    $path=Storage::disk('public')->path($attachment->file_path);

    Log::info('Attempting to download file', [
        'id' => $id,
        'file_path' => $attachment->file_path,
        'full_path' => $path,
        'exists' => file_exists($path)
    ]);


     if (!file_exists($path)) {
            Log::error('File not found', ['path' => $path]);
            abort(404, 'File not found');
        }


    // $file = Storage::disk('public')->get($attachment->file_path);

    return response()->file($path, [
        'Content-Disposition' => 'attachment; filename="' . $attachment->file_name . '"'
    ]);
}






    public function show($id)
    {


        $userCorpId=Auth::user()->corp_id;

      $post = Post::where(function($query) use ($userCorpId) {
        $query->whereHas('corps', function($q) use ($userCorpId) {
            $q->where('corps.id', $userCorpId);
        })
        ->orWhereDoesntHave('corps'); // Posts with no corps specified are visible to all
    })->findOrFail($id);

        return view('posts.show', compact('post'));
    }

    public function preview($id)
    {
        $attachment=PostAttachment::findOrFail($id);
        $path=Storage::dist('public')->path($attachment->file_path);

        if(!file_exists($path)){
            abort(404 , 'file not found');
        }

        $supportedPreviewTypes=['pdf', 'jpg', 'jpeg', 'png', 'gif'];
        if (in_array($attachment->file_type, $supportedPreviewTypes)) {
            return response()->file($path);
        } else {
            return response()->json(['error' => 'Preview not available for this file type'], 400);
        }



    }

    public function showByCategory(Category $category)
{
    $categories = Category::all();
    $posts = $category->posts()->paginate(8); // Paginate the posts
    return view('posts.index', compact('posts', 'categories'));
}


public function edit($id)
{
    $post = Post::with('attachments')->findOrFail($id);
    $categories = Category::all();
    $tags = Tag::all();
    return view('posts.edit', compact('post', 'categories', 'tags'));
}


public function update(Request $request, $id)
{
    $validatedData = $request->validate([
        'title' => 'required',
        'content' => 'required',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        'youtube_url' => 'nullable|url',
        'category_id' => 'required|exists:categories,id',
        'tags' => 'nullable|array',
        'attachments.*'=>'nullable|file|max:50240',
    ]);

    $post = Post::findOrFail($id);
    $post->title = $validatedData['title'];
    $post->content = $validatedData['content'];
    $post->category_id = $validatedData['category_id'];
    $post->save();


  if($request->hasFile('attachments')){
    foreach($request->file('attachments') as $file){
        $orignalName=$file->getClientOriginalName();
        $path=$file->store('attachments','public');

        PostAttachment::create([
            'post_id'=>$post->id,
            'file_name'=>$orignalName,
            'file_path'=>$path,
            'file_type'=>$file->getClientOriginalExtension(),
        ]);
    }
  }


      // Sync tags
      if (isset($validatedData['tags'])) {
        $post->tags()->sync($validatedData['tags']);
    }


    return redirect()->route('posts.index')->with('success', 'Post updated successfully!');
}


public function destroy($id)
{
    $post = Post::findOrFail($id);
    $post->delete();
    return redirect()->route('posts.index')->with('success', 'Post deleted successfully!');
}

public function showByTag(Tag $tag)
{
    $posts = $tag->posts()->latest()->paginate(10);
    $categories = Category::all();
    return view('posts.index', compact('posts', 'categories'));
}


public function destroy2($id){

    try {
        $attachment = PostAttachment::findOrFail($id);

        // Delete the file from the storage
        if (Storage::disk('public')->exists($attachment->file_path)) {
            Storage::disk('public')->delete($attachment->file_path);
        }

        // Delete the record from the database
        $attachment->delete();

        return redirect()->back()->with('success', 'Attachment deleted successfully!');
    } catch (\Exception $e) {
        return redirect()->back()->withErrors(['error' => 'An error occurred while deleting the attachment: ' . $e->getMessage()]);
    }

}


}


