@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
<div class="row">
    <div class="col-sm-12"><h2 class="title__one">Categories</h2></div>
   <div class="col-sm-12">
        @include('partials.messages')
   </div>
</div>
<div class="row">
    <div class="col-md-6 col-12">
        <h4 class="title__two">Add New Category</h4>
    <form id="addtag" method="post" action="{{route('new-category')}}" class="validate">
            
                @csrf
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
                @foreach ($categories as $item)
                    <option value="{{$item->id}}">{{$item->post_title}}</option>
                @endforeach
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
    <div class="col-md-6 col-12">
       <div class="card card-body">
           <div class="tablenav top">
               <div class="float-left"></div>
               <div class="float-right">
                   <span class="displaying-num">{{$categories->count()}} items</span>
               </div>
           </div>
           
        <table class="table table-hover table-striped" id="">
            <thead class="thead-dark">
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
                            <a  data-toggle="modal" data-target="#edit-{{$item->id}}">{{ $item->post_title }}</a>
                            <div class="row-actions">
                                <span class="edit">
                                        <a title="edit category"  data-toggle="modal" data-target="#edit-{{$item->id}}" data-toggle="tooltip" data-placement="top" data-method="Edit">Edit</a>
                                </span>
                                |
                                <span class="delete">
                                        <a href="{{ route('category.delete', $item->id) }}" title="delete category" data-toggle="tooltip" data-placement="top" data-method="Delete" data-confirm-title="@lang('app.please_confirm')" data-confirm-text="Are you sure you want to delete this category?"
                                                data-confirm-delete="@lang('app.yes_delete_it')">
                                                 Delete
                                        </a>
                                </span>
                                |
                                <span class="view">
                                    <a href="" title="view category"  data-toggle="tooltip" data-placement="top" data-method="View">
                                        View
                                    </a>
                                </span>
                            </div>
                        </td>
                        <td>{{ $item->slug }}</td>
                        <td>{{ $item->author->first_name }}</td>
                        <td>{{ $item->created_at }}</td>
                        <td>
                            <a data-toggle="modal" data-target="#edit-{{$item->id}}"  class="btn btn-icon">
                                <i class="fas fa-edit"></i>
                            </a>
                        </td>
                        <td>
                            <a href="{{ route('category.delete', $item->id) }}" class="btn btn-icon" title="delete category" data-toggle="tooltip" data-placement="top" data-method="DELETE" data-confirm-title="@lang('app.please_confirm')" data-confirm-text="Are you sure you want to delete this category?"
                                data-confirm-delete="@lang('app.yes_delete_it')">
                                 <i class="fas fa-trash"></i>
                             </a>
                        </td>
                        @include('backend.posts.partials.editcategory')
                    </tr>
                @endforeach
            </tbody>
        </table>
       </div>
    
        {!! $categories->render() !!}
    </div>
</div>
  

@endsection
