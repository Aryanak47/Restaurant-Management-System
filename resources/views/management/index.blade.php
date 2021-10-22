@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
            <div class="col-md-4">
            <div class="list-group">
                <a href="/management/category" class="list-group-item list-group-item-action">
                <i class="fas fa-bars"></i> Category
                </a>
                <a href="management/menu" class="list-group-item list-group-item-action">
                    <i class="fas fa-hamburger"></i> Menu
                </a>
                <a href="/management/users" class="list-group-item list-group-item-action">
                    <i class="fas fa-users"></i> Users
                </a>
                <a href="/management/table" class="list-group-item list-group-item-action">
                    <i class="fas fa-couch"></i> Table
                </a>
            </div>
        </div>
          <div class="col-md-8">
          content
            
        
        </div>
    </div>


</div>
@endsection