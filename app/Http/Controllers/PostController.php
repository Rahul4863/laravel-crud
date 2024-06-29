<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;
use File;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
       $posts=Post::paginate(5);
        return view('index',compact('posts'));

        
       /* $posts=Cache::remember('posts',60,function(){
            return Post::paginate(5);
        });
        return view('index',compact('posts'));*/
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create',Post::class);
        $categories=Category::all();
        //
        return view('create',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $this->authorize('create',Post::class);
        
        $request->validate([
            'image'=>['required','max:2028','mimes:png,jpg','image'],
            'title'=>['required','max:255'],
            'category_id'=>['required','integer'],
            'description'=>['required']
            
            ]);
            
            $fileName= time().'_'.$request->image->getClientOriginalName();
            $filePath=$request->image->storeAs('uploads',$fileName);
            $post =new Post();
            $post->title=$request->title;
            $post->category_id=$request->category_id;
            $post->description=$request->description;
            $post->image='storage/'.$filePath;
            $post->save();
            return redirect()->route('posts.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $posts=Post::findOrFail($id);
        $this->authorize('update',$posts);
        return view('show',compact('posts'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
       // $this->authorize('edit_post');
       $post=Post::find($id);
       $this->authorize('update',$post);
        $categories=Category::all();
        return view('edit',compact('post','categories'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
        //
        //$this->authorize('edit_post');
        $post =Post::findOrFail($id);
        $this->authorize('update',$post);
        $request->validate([
            
            'title'=>['required','max:255'],
            'category_id'=>['required','integer'],
            'description'=>['required']
            
            ]);
           
            if($request->hasFile('image')){
                $request->validate([
                    'image'=>['required','max:2028','mimes:png,jpg','image'],
            ]);

            $fileName= time().'_'.$request->image->getClientOriginalName();
            $filePath=$request->image->storeAs('uploads',$fileName);
            File::delete(public_path($post->image));
            $post->image='storage/'.$filePath;
            }
            
            $post->title=$request->title;
            $post->category_id=$request->category_id;
            $post->description=$request->description;
            
            $post->save();
            return redirect()->route('posts.index');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
{
    // Find the post by its ID
    $post = Post::findOrFail($id);

    // Authorize the delete action
    $this->authorize('delete', $post);

    // Delete the post
    $post->delete();

    // Redirect to the posts index
    return redirect()->route('posts.index');
}



    public function trashed()
    {
        //
      
        $posts=Post::onlyTrashed()->get();
       return view('trashed',compact('posts'));
    }

    public function restore($id)
{
    // Find the trashed post by its ID
    $post = Post::onlyTrashed()->findOrFail($id);

    // Authorize the restore action
    $this->authorize('restore', $post);

    // Restore the post
    $post->restore();

    // Redirect to the posts index
    return redirect()->route('posts.index');
}

public function forceDelete($id)
{
    // Find the trashed post by its ID
    $post = Post::onlyTrashed()->findOrFail($id);

    // Authorize the force delete action
    $this->authorize('forceDelete', $post);

    // Delete the post image if it exists
    if ($post->image && File::exists(public_path($post->image))) {
        File::delete(public_path($post->image));
    }

    // Force delete the post
    $post->forceDelete();

    // Redirect to the posts index
    return redirect()->route('posts.index');
}

}
