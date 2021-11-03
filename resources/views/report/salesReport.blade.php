@extends('layouts.app')

@section('content')
<div class="container">
   
            @if ($sales->count() > 0)
                <div class="alert alert-success" role="alert">
                  <p>Report of sale from {{$date_start}} to {{$date_end}}.</p>
                  <p>The total amount is {{$total_sale}}.</p>
                  <p>Total sale:  {{$sales->count()}}.</p>
                    {{ session('status') }}
                </div>
             @endif
          <table class="table">
            <thead>
              <tr class="bg-primary text-light">
                <th>S.N</th>
                <th>Receipt Id</th>
                <th>Date Time</th>
                <th>Table</th>
                <th>Staff</th>
                <th>Total Amount</th>
              </tr>
            </thead>
            <tbody>
                @php
                $count = ($sales->currentPage() -1) * $sales->perPage();
                @endphp
                
                @foreach($sales as $sale)

                <tr class="bg-primary text-light">
                    <td>{{++$count}}</td>
                    <td>{{$sale->id}}</td>
                    <td>{{date("m/d/Y H:i:s",strtotime($sale->updated_at))}}</td>
                    <td>{{$sale->table_name}}</td>
                    <td>{{$sale->user_name}}</td>
                    <td>Rs. {{$sale->total_price}}</td>
                </tr>
                <tr>
                    <th></th>
                    <th>Menu Id</th>
                    <th>Menu Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                @foreach($sale->saleDetails as $saleDetail)
                    <tr>
                        <td></td>
                        <td>{{$saleDetail->menu_id}}</td>
                        <td>{{$saleDetail->menu_name}}</td>
                        <td>{{$saleDetail->menu_price}}</td>
                        <td>{{$saleDetail->quantity}}</td>
                        <td>{{$saleDetail->quantity * $saleDetail->menu_price}}</td>
                        
                    </tr>
                 
                @endforeach

                @endforeach
                         
               
            </tbody>
          </table>
          {{ $sales->appends($_GET)->links() }}
         
    </div>
    



@endsection