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
          <i class="fas fa-hamburger"></i> Menu
          <a href="/management/menu/create"  class="btn btn-success float-right mb-5"> <i class="fas fa-plus"></i> Create Menu</a>
          <table class="table table-bordered">
            <thead>
              <tr>
                <th>Id</th>
                <th>Name</th>
                <th>Picture</th>
                <th>Price</th>
                <th>Category</th>
                <th>Edit</th>
                <th>Delete</th>
              </tr>
            </thead>
            <tbody>
              @foreach($menus as $menu)
              <tr>
                <td>{{$menu->id}}</td>
                <td>{{$menu->name}}</td>
                <td><img width="120px" class="img-thumbnail" height="120px" src="{{asset('images/menu_images')}}/{{$menu->image}}"></td>
                <td>{{$menu->price}}</td>
                <td>{{$menu->category->name}}</td>
                <td><a href="/management/menu/{{$menu->id}}/edit" class="btn btn-warning">Edit</a></td>
                <td>
                    <form method="post" action="/management/menu/{{$menu->id}}">
                        @csrf
                        @method("delete")
                    <input type="submit" value="Delete"  class="btn btn-danger"/>
                    </form>
                </td>
          </tr>
              @endforeach               
               
            </tbody>
          </table>
         
        </div>
    </div>


</div>
@endsection