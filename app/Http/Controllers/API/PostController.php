<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Tag;
use App\TagPost;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;

class PostController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if( \Gate::allows('isAdmin') || \Gate::allows('isAuthor') ) {
            // return Post::latest()->paginate(10);
            return Post::select('posts.*', 'categories.name')
                    ->join('categories', 'categories.id', '=', 'posts.category_id')
                    ->latest()->paginate(10);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $avatar = $request->avatar;
        $tags = $request->tags;

        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'avatar' => 'required',
            'content' => 'required',
            'post_status' => 'required',
            'hot' => 'required',
            'feature' => 'required',
        ]);
            
        DB::beginTransaction();
        try {    
            $post = new Post;
            $post->category_id = $request->category_id;
            $post->title = $request->title;
            $post->slug = Str::slug($request->title);
            $post->description = $request->description;
            $post->content = $request->content;
            $post->post_status = $request->post_status;
            $post->hot = $request->hot;
            $post->feature = $request->feature;
            if ($avatar) {
                $name = time() . '.' . explode(';', explode('/', $avatar)[1])[0];
                Image::make($avatar)->save(public_path('img/posts/').$name);
                $post->avatar = $name;
            }
            $post->save();
           
            if ($tags) {
                foreach ($tags as $tag) {
                    $foundTag = Tag::where('name', $tag)->first();
                    if ($foundTag != null) {
                        TagPost::create([
                            'tag_id' => $foundTag->id,
                            'post_id' => $post->id,
                        ]);
                    }
                    else {
                        $tagCreation = Tag::create(['name' => $tag]);
                        TagPost::create([
                            'tag_id' => $tagCreation->id,
                            'post_id' => $post->id,
                        ]);

                    }
                }
            }

            DB::commit();

            return $post;

        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        foreach ($post->tags as $tag) {
            $tags[] = $tag->name;
        }
        return response()->json([
            "id" => $post->id,
            "title" => $post->title,
            "content" => $post->content,
            "description" => $post->description,
            "avatar" => $post->avatar,
            "feature" => $post->feature,
            "hot" => $post->hot,
            "view" => $post->view,
            "category_id" => $post->category_id,
            "post_status" => $post->post_status,
            "slug" => $post->slug,
            "tags" => $tags
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post)
    {
        $avatar = $request->avatar;
        $tags = $request->tags;
        $this->validate($request, [
            'category_id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'avatar' => 'required',
            'content' => 'required',
            'post_status' => 'required',
            'hot' => 'required',
            'feature' => 'required',
        ]);

        DB::beginTransaction();
        try {
            $post->category_id = $request->category_id;
            $post->title = $request->title;
            $post->slug = Str::slug($request->title);
            $post->description = $request->description;
            $post->content = $request->content;
            $post->post_status = $request->post_status;
            $post->hot = $request->hot;
            $post->feature = $request->feature;
            if ( strlen($avatar) > 200 ) {
                $name = time() . '.' . explode(';', explode('/', $avatar)[1])[0];
                Image::make($avatar)->save(public_path('img/posts/').$name);
                $post->avatar = $name;
            }
            $post->save();

            TagPost::where('post_id', $post->id)->delete();
            
            if ($tags) {
                foreach ($tags as $tag) {
                    $foundTag = Tag::where('name', $tag)->first();
                    if ($foundTag != null) {
                        // exits
                        TagPost::create([
                            'tag_id' => $foundTag->id,
                            'post_id' => $post->id,
                        ]);
                    }
                    else {
                        $tagCreation = Tag::create(['name' => $tag]);
                        TagPost::create([
                            'tag_id' => $tagCreation->id,
                            'post_id' => $post->id,
                        ]);

                    }
                }
            }

            DB::commit();
            return ["message" => "updated successfully"];
        } catch (\Exception $e) {
            DB::rollBack();
            return $e->getMessage();
        }
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $post = Post::find($id);
        $post->delete();
        return ["message" => "deleted a post"];
    }
}
