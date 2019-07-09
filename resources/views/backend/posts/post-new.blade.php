@extends('layouts.app')

@section('title', 'Blog Posts')

@section('content')
    <div class="row">
        <div class="col-sm-12"><h2 class="title__one">Add New Post</h2></div>
    <div class="col-sm-12">
            @include('partials.messages')
    </div>
    </div>
  <form action="" method="post">
        <div class="row">
                <div class="col-sm-10">
                    <div class="form-group">
                       <input type="text" name="title" class="uk-input" id="">
                    </div>
                    <div class="form-group">
                            <div class="inside">
                                    <div id="edit-slug-box" class="hide-if-no-js">
                                            </div>
                                        </div>
                    </div>
                    <div class="form-group">
                        <textarea name="post_content" class="uk-textarea" id="snow-container" cols="30" rows="10"></textarea>
                    </div>
                </div>
                <div class="col-sm-2">
                        {!! Widget::menubar('homepage') !!}
                    <div class="module">
                        <h4>Categories</h4>
                        <ul class="cat__list">
                            @foreach ($allcats as $item)
                        <li>
                                <label>
                                    <input value="{{$item->id}}" type="checkbox" class="uk-checkbox" name="post_category[{{$item->id}}]" id="in-category-{{$item->id}}"> 
                                    {{$item->post_title}}
                                
                                </label>
                           </li>
                            @endforeach
                        </ul>
                    </div>
                    <div>
                            @foreach($allcats as $item)
                            @if($item->children->count() > 0)
                                <li class="dropdown">
                                     <a href="#">{{ $item->name }} <span class="caret"></span></a>
                                     <ul>
                                         @foreach($item->children as $submenu)
                                             <li><a href="/{{ $submenu->slug }}">{{ $submenu->name }}</a></li>
                                          @endforeach
                                     </ul>
                               </li>
                            @else
                                <li><a href="/{{ $item->slug }}">{{ $item->name }}</a></li>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
  </form>
@stop