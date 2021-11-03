<?php

namespace App\Http\Controllers\Report;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Sale;

class ReportController extends Controller
{
    public function index(){
        return view('report.index');
    }
    public function showReport(Request $request){
        $request->validate([
            'date_start'=>'required',
            'date_end'=>'required',
        ]);
        $startDate = date('Y-m-d H:i:s', strtotime($request->date_start . ' 00:00:00'));
        $endDate = date('Y-m-d H:i:s', strtotime($request->date_end . ' 23:59:59'));
        $sales = Sale::whereBetween("updated_at",[$startDate, $endDate])->where('sale_status','paid');
        return view('report.salesReport')->
        with('total_sale',$sales->sum('total_price'))->
        with('date_start',$startDate)->
        with('date_end',$endDate)->
        with('sales',$sales->paginate(5));
        
    }
}
