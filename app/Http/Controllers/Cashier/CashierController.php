<?php

namespace App\Http\Controllers\Cashier;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Table;
use App\Category;
use App\Menu;
use App\Sale;
use App\saleDetail;
use Illuminate\Support\Facades\Auth;

class CashierController extends Controller
{
    public function index(){
        $categories = Category::all();
        return view('cashier.index')->with('categories', $categories);

    }
    public function printBill($sale_id){
        $sale = Sale::find($sale_id);
        return view("cashier/bill")->with('sale', $sale);
    }
    public function getTable(){
        $tables = Table::all();
        $html="";
        foreach($tables as $table){
            $class = 'badge-warning';
            if($table->status != 'available'){
                $class = 'badge-danger';
            }
            $html .= '<div class="col-md-2">
            <button type="button" class="btn btn-primary btn-table" data-id="' . $table->id.'" data-name="' . $table->name.'">
            <span class="badge btn-warning '.$class.'">'.$table->name.'</span></button></div>';
        }
        return $html;

    }
    public function getMenuByCategory($category_id){
        $menus = Menu::where('category_id',$category_id)->get();
        $html = '';
        foreach($menus as $menu){
            $html .= '<div class="col-md-3 text-center">
            <a class="btn btn-outline-secondary btn-menu" data-id="'.$menu->id.'">
                <img class="img-fluid" src="'.url('/images/menu_images/'.$menu->image).'">
                <br>
                '.$menu->name.'
                <br>
                '.number_format($menu->price).'
            </a>
            </div>';
            
        }
        return $html;

    }
    public function orderFood(Request $request){
        $table_id = $request->table_id;
        $table_name = $request->table_name;
        $menu = Menu::find($request->menu_id);
        $sale = Sale::where('table_id',$table_id)->where('sale_status','unpaid')->first();
        
        if(!$sale){
            $user = Auth::user();
            $sale = new Sale();
            $sale->table_id = $table_id;
            $sale->table_name = $table_name;
            $sale->user_name = $user->name;
            $sale->user_id = $user->id;
            $sale->save();
            $sale_id = $sale->id;
            $table = Table::find($table_id);
            $table->status = "unavailable";
            $table->save();
        }else{
            $sale_id = $sale->id;
        }
        $sale_detail = new saleDetail();
        $sale_detail->sale_id = $sale_id;
        $sale_detail->menu_id = $menu->id;
        $sale_detail->menu_name = $menu->name;
        $sale_detail->menu_price = $menu->price;
        $sale_detail->quantity = $request->quantity;
        $sale_detail->save();
        $sale->total_price = $sale->total_price + ($sale_detail->menu_price * $request->quantity);
        $sale->save();
        $html = $this->getSaleDetail($sale_id);
        return $html;
    }
    public function getMenuByTable($table_id){
        $sale = Sale::where('table_id',$table_id)->where('sale_status','unpaid')->first();
        if(!$sale){
            $html = '<div>There is no any order in this table.</div>';
        }else{
            $html = $this->getSaleDetail($sale->id);
        }
        return $html;
    }

    public function confirmOrder(Request $request){
        $sale_id = $request->sale_id;
        $sale_details = saleDetail::where('sale_id',$sale_id)->update(['status' => "confirm"]);
        $html = $this->getSaleDetail($sale_id);
        return $html;

    }
    public function deleteOrderItem(Request $request){
        $sale_detail = saleDetail::find($request->sale_detail);
        $menu_price = $sale_detail->quantity * $sale_detail->menu_price;
        $sale_id = $sale_detail->sale_id;
        $sale_detail->delete();
        $sale = Sale::find($sale_id);
        // update total price
        $sale->total_price = $sale->total_price -$menu_price ;
        $sale->save();
        $sale_details = saleDetail::where('sale_id', $sale_id)->first();
        if($sale_details){
            $html = $this->getSaleDetail($sale->id);
        }else{
            $html = '<div>There is no any order in this table.</div>';
        }
        return $html;
    }
    public function savePayment(Request $request){
        $total_recieved = $request->total_received;
        $sale_id = $request->sale_id;
        $sale = Sale::find($sale_id);
        $sale->total_received = $total_recieved;
        $sale->change = $total_recieved - $sale->total_price;
        $sale->sale_status = "paid";
        $sale->save();
        $table = Table::find($sale->table_id);
        $table->status = "available";
        $table->save();
        return "/cashier/print";

    }
 

    private function getSaleDetail($sale_id){
        $sale_details = saleDetail::where('sale_id', $sale_id)->get();
       
        $html = '<div class="table-responsive-md" style="height=400px;overflow-y:scroll;border:1px solid #ccc">
        <table class="table table-dark">
                    <thead>
                        <tr>
                            <th scope="col">Id</td>
                            <th scope="col">Name</td>
                            <th scope="col">Price</td>
                            <th scope="col">Quantity</td>
                            <th scope="col">status</td>
                        </tr>
                    </thead>
                    <tbody>';
        $btnPayment = true;
        foreach($sale_details as $sale_detail){
            $html .= '<tr>
                        <th scope="row">'.$sale_detail->id.'</td>
                        <td>'.$sale_detail->menu_name.'</td>
                        <td>Rs. '.$sale_detail->menu_price.'</td>
                        <td>'.$sale_detail->quantity.'</td>';
                        if($sale_detail->status == 'confirm'){
                            $html .= '<td><i class="far fa-check-circle"></i></td></tr>';
                        }else{
                            $btnPayment = false;
                            $html .= '<td><a class="btn btn-danger btn-delete-saledetail" data-saleDetail="'.$sale_detail->id.'"><i class="fas fa-trash"></i></a></td></tr>';
                        }
        }
        $html .= '</tbody></table></div>';
        $sale = Sale::find($sale_id);
        $html .='<hr><h3 class="totalPrice font-weight-normal">Total Price : Rs.<span>'.number_format($sale->total_price).'</span></h3>';
        if($btnPayment){
            $html .='<button type="button" id="btn-payment" class="mt-5 font-weight-bold btn btn-success btn-block" data-totalAmount="'.$sale->total_price.'" data-toggle="modal" data-target="#paymentModal" data-sale="'.$sale->id.'">Payment</button>';
        }else{
            $html .='<button type="button" class="mt-5 font-weight-bold btn btn-warning btn-confirm btn-block"  data-sale="'.$sale->id.'">Confirm Order</button>';
        }
        
        return $html;

    }
}
