@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="row">
    <div class="col-sm-12"><h2>Categories</h2></div>
</div>
<div class="row">
    <div class="col-6 col-md-6">
        <h4>Add New Category</h4>
        <form id="addtag" method="post" action="" class="validate">
            
                
            <div class="form-field form-required term-name-wrap">
                <label for="tag-name">Name</label>
                <input name="title" id="title" type="text" value="" class="form-control" aria-required="true">
                <small>The name is how it appears on your site.</small>
            </div>
                <div class="form-field term-slug-wrap">
                <label for="tag-slug">Slug</label>
                <input name="slug" id="tag-slug" type="text" value="" class="form-control">
                <small>The “slug” is the URL-friendly version of the name. It is usually all lowercase and contains only letters, numbers, and hyphens.</small>
            </div>
                <div class="form-field term-parent-wrap">
                <label for="parent">Parent Category</label>
                    <select name="parent" id="parent" class="form-control">
                <option value="-1">None</option>
                <option class="level-0" value="4">Lifestyle Management</option>
                <option class="level-0" value="5">Mum’s Club</option>
                <option class="level-0" value="3">Nutrition</option>
                <option class="level-0" value="1">Parenthood</option>
            </select>
                            <small>Categories, unlike tags, can have a hierarchy. You might have a Jazz category, and under that have children categories for Bebop and Big Band. Totally optional.</small>
                </div>
                <div class="form-field term-description-wrap">
                <label for="tag-description">Description</label>
                <textarea name="description" id="tag-description" class="form-control" rows="5" cols="40"></textarea>
                <small>The description is not prominent by default; however, some themes may show it.</small>
            </div>
            
                <p class="submit"><input type="submit" name="submit" id="submit" class="btn btn-primary" value="Add New Category"></p>
            </form>
    </div>
    <div class="col-6 col-md-6">
        <table class="table table-hover" id="">
            <thead>
                <tr>
                    <th>Title</th>
                    <th>Slug</th>
                    <th>Author</th>
                    <th>Published</th>
                    <th>Edit</th>
                    <th>Delete</th>
                </tr>
            </thead>
            <tbody>
                @foreach($categories as $item)
                    <tr class="{{ $item->published_highlight }}">
                        <td>
                            <a href="{{ route('post.edit', $item->id) }}">{{ $item->title }}</a>
                        </td>
                        <td>{{ $item->post_title }}</td>
                        <td>{{ $item->author->name }}</td>
                        <td>{{ $item->published_date }}</td>
                        <td>
                            <a href="{{ route('backend.blog.edit', $item->id) }}">
                                <span class="glyphicon glyphicon-edit"></span>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('backend.blog.confirm', $item->id) }}">
                                <span class="glyphicon glyphicon-remove"></span>
                            </a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    
        {!! $categories->render() !!}
    </div>
</div>
   

@endsection
