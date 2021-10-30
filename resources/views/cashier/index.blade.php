@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row mb-4" id= "tableDetail">
    </div>
    <div class="row justify-content-center">
        <div class="col-md-5 ">
            <button type="button" class="btn btn-primary btn-block" id="btn-show-table">Show Table</button>
            <div id="selectedTable"></div>
            <div id="orderedItem"></div>
        </div>
        <div class="col-md-7">
            <nav>
                <div class="nav nav-tabs" id="nav-tab" role="tablist">
                    @foreach($categories as $category)
                        <a class="nav-item nav-link" data-id={{$category->id}} id="nav-home-tab" data-toggle="tab" href="#nav-home" role="tab" aria-controls="nav-home" aria-selected="true">{{$category->name}}</a>
                    @endforeach   
                </div>
            </nav>
            <div id="list-menu" class="row mt-2"></div>
        
        </div>

    </div>
    <!-- Modal -->
<div class="modal fade" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="paymentModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-header">
          <h5 class="modal-title" id="paymentModalLabel">Payment</h5>
          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
          </button>
        </div>
        <div class="modal-body">
                <div class="form-row">
                    <div class="col-md-10 mb-3">
                        <h3 class="mt-3">Total Amount : Rs. <span class="totalPayment"></span></h3>
                        <div class="input-group">
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">Amount Received</span>
                          </div>
                          <input type="text" id="amountReceived" class="form-control"  placeholder="0.0" aria-describedby="inputGroupPrepend" required>
                          <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">Rs.</span>
                          </div>
                        </div>
                        <h3 class="mt-3">Total change : Rs. <span class="total_change"></span></h3>
                    </div>
                </div>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
          <button disabled id="savepaymentButton" type="button" class="btn btn-primary">Save changes</button>
        </div>
      </div>
    </div>
  </div>


</div>
<script>
    $(document).ready(()=>{
      
        const tables =  $("#tableDetail")
        const button =  $("#btn-show-table")
        tables.hide();

       button.click(function(){
           if(tables.is(":hidden")){
            button.text("Hide Table");
            button.addClass("btn-danger")
            
            var xmlhttp = new XMLHttpRequest();
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    $("#tableDetail").html("")
                    $("#tableDetail").html(this.responseText)
                }
            };
            xmlhttp.open("GET", "/cashier/tables", true);
            xmlhttp.send();
            tables.slideDown('fast');
   
           }else{
            button.text("Show Table");
            button.removeClass("btn-danger")
            tables.slideUp('fast');
           }
        })

    })
    // loading menus by category
    $(".nav-item").click(function(){
        $.get(`/cashier/getMenuByCategory/${$(this).data('id')}`,function(data){
            $("#list-menu").hide()
            $("#list-menu").html(data)
            $("#list-menu").fadeIn("fast")
        })
       
    })
    let selectedTableId = ""
    let selectedTableName = ""
    $("#tableDetail").on("click",".btn-table",function(){
        selectedTableId = $(this).data('id');
        selectedTableName = $(this).data('name');
        $("#selectedTable").html(`<br><h2>Table ${selectedTableName}</h2><hr>`)
        $.ajax({
            type:"GET",
            url: `/cashier/getMenuByTable/${selectedTableId}`,
            success: function(data){
                $("#orderedItem").html(data)
            }
        })
    
    })
    $("#list-menu").on("click",".btn-menu",function(){
        if(selectedTableName == ""){
            alert("Please select table first !")
            return
        }
        let menu_id = $(this).data("id")
        $.ajax({
        type: "POST",
        url: "/cashier/orderFood",
        data: {
            "_token":$('meta[name="csrf-token"]').attr('content'),
            "menu_id":menu_id,
            "table_id":selectedTableId,
            "table_name":selectedTableName,
            "quantity":1
        },
        success: function(data){
            $("#orderedItem").html(data)
        }
        });
        
    })
    // delete sale item
    $("#orderedItem").on("click",".btn-delete-saledetail",function(event){
        const sale_detail = $(this).data("saledetail")
        $.ajax({
            type: "Post",
            url: "/cashier/deleteOrderItem",
            data: {
            "_token":$('meta[name="csrf-token"]').attr('content'),
            sale_detail
            },
            success: function(data){
                $("#orderedItem").html(data)
            }

        })
    })
    // confirm order button
    $("#orderedItem").on("click",".btn-confirm",function (event){
        const sale_id = $(this).data("sale")
        $.ajax({
            type: "POST",
            url: `/cashier/confirmOrder`,
            data: {
                "_token":$('meta[name="csrf-token"]').attr('content'),
                sale_id:sale_id
                 
            },
            success: function(data){
                $("#orderedItem").html(data)
            }
        })
    })
    $("#amountReceived").keyup(function(event){
        let receivedAmount = $(this).val().trim()*1 ;
        let totalAmount = $("#btn-payment").attr('data-totalamount')*1
        let change =   receivedAmount - totalAmount 
        if(change >= 0){
            $("#savepaymentButton").prop("disabled",false)
            $(".total_change").text(change)
            return;

        }
        $("#savepaymentButton").prop("disabled",true)
    })
    $("#orderedItem").on("click","#btn-payment",function (event){
        const totalAmount = $("#btn-payment").attr('data-totalamount')
        $(".totalPayment").text(totalAmount)
        $("#amountReceived").val("")
        $(".total_change").text("")
    })
    $("#savepaymentButton").click(function (event){
       const receivedAmount =  $("#amountReceived").val()
       const change =  $(".total_change").text() 
       const sale = $("#btn-payment").data('sale')
       $.ajax({
            type: "POST",
            url: `/cashier/savePayment`,
            data: {
                "_token":$('meta[name="csrf-token"]').attr('content'),
                sale_id:sale,
                change,
                total_received:receivedAmount
            },
            success: function(data){
               window.location.href = data
            }
        })
        

    })

   
       


</script>
@endsection