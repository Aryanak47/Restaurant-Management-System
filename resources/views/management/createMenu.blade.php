@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        @include("management.inc.sidebar")
        <div class="col-md-8">
        <i class="fas fa-bars"></i> Category
        <hr>
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
            <form method="post" action="/management/menu" enctype="multipart/form-data">
                @csrf
                <div class="form-row">
                    <div class="col-md-10">
                        <label for="menuName">Menu Name</label>
                        <input type="text" class="form-control" name="name" id="menuName" class="form-label" placeholder="Menu name" required/>
                    </div>
                    <div class="col-md-10 mb-3">
                        <label for="validationCustomUsername"></label>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">Price</span>
                          </div>
                          <input type="text" name="price" class="form-control" id="validationCustomUsername" placeholder="$10" aria-describedby="inputGroupPrepend" required>
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">$$</span>
                          </div>
                        </div>
                    </div>
                    <div class="input-group col-md-10 mb-3">
                        <div class="input-group-prepend">
                          <span class="input-group-text">Upload</span>
                        </div>
                        <div class="custom-file">
                          <input type="file" name="image" class="custom-file-input" id="imageUpload">
                          <label class="custom-file-label" for="imageUpload">Choose file</label>
                        </div>
                    </div>
                    <div class="form-group col-md-10">
                        <label for="category">Category</label>
                        <select class="form-control" name="category_id" id="category">
                            @foreach($categories as $category)
                                <option value={{$category->id}}>{{$category->name}}</option>
                            @endforeach
                        </select>
                      </div>
                    <div class="form-group col-md-10">
                        <label for="menuDescription"></label>
                        <textarea required name="description" class="form-control" placeholder="Description" id="menuDescription" rows="3"></textarea>
                    </div>

                </div>
                 <button type="submit" class="btn btn-primary">save</button>
            </form
            
        
        </div>
    </div>


</div>
@endsection