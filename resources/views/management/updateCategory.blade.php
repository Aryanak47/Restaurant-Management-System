@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row justify-content-center">
            @include("management.inc.sidebar")
            <div class="col-md-8">
                <i class="fas fa-bars"></i> Category Edit
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
                <form method="post" action="/management/category/{{$category->id}}">
                    @csrf
                    @method("PUT")
                    <div class="form-outline mb-4">
                        <label for="categoryName">Category Name</label>
                    
                            <input type="text" value={{$category->name}} class="form-control" name="name" id="categoryName" class="form-label" placeholder="Category name" />
                    
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form
            </div>
        </div>
    </div>
@endsection
