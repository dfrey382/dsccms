<?php

namespace Dsc\Http\Controllers\Web;

use Dsc\Post;
use Dsc\Category;
use Auth;
use Illuminate\Http\Request;
use Dsc\Http\Controllers\Controller;

class PostController extends Controller
{
    protected $posts;

    public function __construct(Post $posts, Category $categories)
    {
        $this->posts = $posts;
        $this->categories = $categories;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $posts = $this->posts->with('author')->orderBy('published_at', 'desc')->paginate(10);

        return view('backend.posts.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $allcats = Category::all();
        return view('backend.posts.post-new', compact('allcats'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Requests\StorePostRequest $request)
    {
        $this->posts->create(
            ['author_id' => auth()->user()->id] + $request->only('title', 'slug', 'published_at', 'body', 'excerpt')
        );

        return redirect(route('backend.posts.index'))->with('status', 'Post has been created.');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = $this->posts->findOrFail($id);

        return view('backend.posts.form', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Requests\UpdatePostRequest $request, $id)
    {
        $post = $this->posts->findOrFail($id);

        $post->fill($request->only('title', 'slug', 'published_at', 'body', 'excerpt'))->save();

        return redirect(route('backend.posts.edit', $post->id))->with('status', 'Post has been updated.');
    }

    public function confirm($id)
    {
        $post = $this->posts->findOrFail($id);

        return view('backend.posts.confirm', compact('post'));
    }

     public function _recentPosts($parameters = array())
     {
            extract($parameters) ;
            $count = isset($count) ? $count : 10 ;
            $posts = Post::published()->recent()->orderBy('created_at', 'desc')->take($count)->get() ;
            return \View::make('widgets._recentPosts', ['posts'=>$posts]) ;
     }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $post = $this->posts->findOrFail($id);

        $post->delete();

        return redirect(route('backend.posts.index'))->with('status', 'Post has been deleted.');
    }

    public function categories() {
        $categories = $this->categories->orderBy('created_at', 'desc')->paginate(10);

        return view('backend.posts.categories', compact('categories'));
    }
    public function addcategories(Request $request) {
        $category = new Category();
        $category->post_title = $request->get('title');
        $category->slug = $request->get('slug');
        $category->description = $request->get('description');
        $category->author_id = auth::id();
        $category->save();
        return redirect()->route('category')
            ->withSuccess('Category added Successfully');
    }

    public function editcategory(Request $request, $id) {
        $category = Category::find($id);
        $category->post_title = $request->get('title');
        $category->slug = $request->get('slug');
        $category->description = $request->get('description');
        $category->author_id = auth::id();
        $category->update();
        return redirect()->route('category')
            ->withSuccess('Category updated Successfully');
    }

    public function deletecategory(Category $categories) {

        $this->categories->delete($categories->id);

        Cache::flush();

        return redirect()->route('category')
            ->withSuccess('Category deleted');
    }
}
