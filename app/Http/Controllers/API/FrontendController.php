<?php

namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Post;
use App\Category;
use App\Contact;
use App\TagPost;
use Illuminate\Support\Facades\Validator;

class FrontendController extends Controller
{
    public function getLatestNews() {
        return Post::select('posts.*', 'categories.name')
                    ->join('categories', 'categories.id', '=', 'posts.category_id')
                    ->where('post_status', 1)
                    ->latest()->take(3)->get();
    }

    public function getFeatureHot() {
        return Post::select('posts.*', 'categories.name')
                    ->join('categories', 'categories.id', '=', 'posts.category_id')
                    ->where(['hot' => 1, 'feature' => 1, 'post_status' => 1])
                    ->latest()->first();
    }

    public function getPostDetail($slug) {
        return Post::select('posts.*', 'categories.name')
                    ->join('categories', 'categories.id', '=', 'posts.category_id')
                    ->where('posts.slug', $slug)->where('posts.post_status', 1)
                    ->latest()->first();
    }

    public function getListCategories() {
        return Category::where('status', 1)->get();
    }

    public function getListPostsByCategory($id) {
        return Post::where(['category_id' => $id, 'post_status' => 1])
                    ->take(3)->latest()->get();
    }

    public function addView($id) {
        $post =  Post::find($id);
        $post->view ++;
        $post->save();
        return ["success" => "added a view"];
    }

    public function getHotNews() {
        return Post::select('posts.*', 'categories.name')
                    ->join('categories', 'categories.id', '=', 'posts.category_id')
                    ->where(['hot' => 1, 'post_status' => 1])
                    ->latest()->take(5)->get();
    }

    public function getFeatureNews() {
        return Post::select('posts.*', 'categories.name')
                    ->join('categories', 'categories.id', '=', 'posts.category_id')
                    ->where(['feature' => 1, 'post_status' => 1])
                    ->latest()->take(5)->get();
    }

    public function getPostsByCategory($slug) {
        return Post::select('posts.*', 'categories.name')
                    ->join('categories', 'categories.id', '=', 'posts.category_id')
                    ->where(['categories.slug' => $slug, 'posts.post_status' => 1])
                    ->latest()->paginate(6);
    }

    public function postContact(Request $request) {
        
        $this->validate($request, [
            'name' => 'required|max:100',
            'email' => 'required|email|max:100',
            'content' => 'required|min:10',
        ]);

        return Contact::create([
            'name' => $request->name,
            'email' => $request->email,
            'content' => $request->content,
        ]);
    }

    public function getTopViews() {
        return Post::select('posts.*', 'categories.name')
                    ->join('categories', 'categories.id', '=', 'posts.category_id')
                    ->where(['post_status' => 1])
                    ->orderBy('view', 'DESC')->take(10)->get();
    }

    public function getRelatedPosts($slug) {
        $post_id = Post::where('slug', $slug)->first()->id;
        $tagPostsById =  TagPost::where('post_id', $post_id)->get();
        $tagIds = [];
        foreach ($tagPostsById as $tagPost) {
            $tagIds[] = $tagPost->tag_id ;
        }
        $tagPosts = TagPost::whereIn('tag_id', $tagIds)->where('post_id', '!=', $post_id)->groupBy('post_id')->get();
        $postIds= [];
        foreach ($tagPosts as $tagPost) {
            $postIds[] = $tagPost->post_id;
        }
        return Post::select('posts.*', 'categories.name')
                    ->join('categories', 'categories.id', '=', 'posts.category_id')
                    ->whereIn('posts.id', $postIds)
                    ->where(['post_status' => 1])
                    ->latest()->take(5)->get();
    }

}
