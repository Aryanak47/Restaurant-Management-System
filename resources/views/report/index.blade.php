@extends('layouts.app')

@section('content')
<div class="container">
    <h2 class="text-center mb-5">Report</h2>
    @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
    <form class="row justify-content-center" method="get" action="/report/show">
        {{-- <div class="form-container"></div> --}}
        <div class="form-outline mr-4">
        <input type="date" class="form-control" name="date_start">
        </div>
        <h3>To</h3>
        <div class="form-outline ml-4 mb-5">
        <input type="date" class="form-control" name="date_end">
        </div>
        <button type="submit" class="btn btn-block btn-primary">Show</button>

    </form>

   
</div>
@endsection