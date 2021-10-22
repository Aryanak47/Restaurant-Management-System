@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Dashboard</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    <div class="row text-center">
                        <div class="col">
                            <a href="/management">
                                <h4>Management</h4>
                                <img width="50px" src="{{asset('images/web-management.svg')}}">
                            </a>
                        </div>
                        <div class="col">
                            <a href="/cashier">
                                <h4>Cashier</h4>
                                <img width="50px" src="{{asset('images/cashier.svg')}}">
                            </a>
                        </div>
                        <div class="col">
                            <a href="/report">
                                <h4>Report</h4>
                                <img width="50px" src="{{asset('images/report.svg')}}">
                            </a>
                            </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
@endsection
