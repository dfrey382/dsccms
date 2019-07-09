 <!-- Edit Modal -->
 <div class="modal fade" id="edit-{{$item->id}}" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Category</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <form id="addtag" method="post" action="{{route('category.edit', $item->id)}}" class="validate">
            <div class="modal-body">
                   
            
                            @csrf
                        <div class="form-field form-required term-name-wrap">
                            <label for="tag-name">Name</label>
                            <input name="title" id="title" type="text" value="{{$item->post_title}}" class="form-control" aria-required="true">
                            <small>The name is how it appears on your site.</small>
                        </div>
                            <div class="form-field term-slug-wrap">
                            <label for="tag-slug">Slug</label>
                            <input name="slug" id="tag-slug" type="text" value="{{$item->slug}}" class="form-control">
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
                        
                           
                        
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              <button type="submit" class="btn btn-primary">Update Category</button>
            </div>
        </form>
          </div>
        </div>
      </div>