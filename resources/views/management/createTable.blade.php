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
            <form method="post" action="/management/table">
                @csrf
                <div class="form-outline mb-4">
                    <label for="categoryName">Table Name</label>
                    <input type="text" class="form-control" name="name" id="categoryName" class="form-label" placeholder="Table name" />
                </div>
                 <button type="submit" class="btn btn-primary">save</button>
            </form
            
        
        </div>
    </div>


</div>
@endsection