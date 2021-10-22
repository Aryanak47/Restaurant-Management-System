@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
      @include("management.inc.sidebar")
          <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    <button type="button" class="close" data-dismiss="alert">X</button>
                    {{ session('status') }}
                </div>
             @endif
          <i class="fas fa-bars"></i> Category
          <a href="/management/category/create"  class="btn btn-success float-right mb-5"> <i class="fas fa-plus"></i> Create Category</a>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
                @foreach ($categories  as $category)
                    <tr>
                        <td>{{$category->id}}</td>
                        <td>{{$category->name}}</td>
                        <td><a href="/management/category/{{$category->id}}/edit" class="btn btn-warning">Edit</a></td>
                        <td>
                            <form method="post" action="/management/category/{{$category->id}}">
                                @csrf
                                @method("delete")
                            <input type="submit" value="Delete"  class="btn btn-danger"/>
                            </form>
                        </td>
                  </tr>
                @endforeach
               
            </tbody>
          </table>
          {{ $categories->links() }}
        </div>
    </div>


</div>
@endsection