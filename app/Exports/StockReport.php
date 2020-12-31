<?php

namespace App\Exports;

use App\Customer;
use App\Order;
use App\Brand;
use App\Product;
use App\ProductMaster;
use App\ProductRate;
use App\Stock;
use App\Refund;
use App\ProductSource;
use App\ProductCombo;
use DB;
use Auth;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithTitle;


class StockReport implements FromCollection, WithHeadings, ShouldAutoSize, WithEvents, WithTitle
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function __construct()
    {
        // echo "<pre>"; print_r('hbjnjnkmnk'); echo "</pre>"; die('end of code');

    }
    
    public function registerEvents(): array
    {
        return [
            AfterSheet::class    => function(AfterSheet $event) {
                $cellRange = 'A1:S1'; // All headers
                $event->sheet->getDelegate()->getStyle($cellRange)->getFont()->setSize(11)->setBold(true);
            },
        ];
    }
    public function title(): string
    {
        return 'stock_report';
    }
    public function collection()
    {
    	$new_stock_list = Stock::with('product')->get();
        $ProductMaster = ProductMaster::all();
        $stock_list = array();
        $c = 0;
        foreach ($ProductMaster as $keys => $values) {
            $purchase_qty = 0;
            $available_qty = 0;
            foreach ($new_stock_list as $key => $value) {
                if ($value->product->name == $values->name) {
                    $purchase_qty += $value->purchase_quantity;
                    $available_qty += $value->available_quantity;
                } 
            }
            $data = Product::where('name',$values->name)->orderBy('id','DESC')->first();
            $stock_list[$c]['name'] =$values->name;
            $stock_list[$c]['purchase_quantity'] =$purchase_qty;
            $stock_list[$c]['available_quantity'] =$available_qty;
            if ($data) {
               $stock_list[$c]['purchase_price'] =$data->purchase_price;
               $stock_list[$c]['sale_price'] =$data->sale_price;
               $stock_list[$c]['last_purchase_date'] =$data->order_date;
            } else {
               $stock_list[$c]['purchase_price'] = null;
               $stock_list[$c]['sale_price'] =null;
               $stock_list[$c]['last_purchase_date'] =null;
            }
            $c++;
        }    
        // echo "<pre>"; print_r($stock_list); echo "</pre>"; die('end of code');    
    	return collect(array($stock_list));
    }
    public function headings(): array
    {
        return [
            'Name',
            'purchase_quantity',
            'available_quantity',
            'purchase_price',
            'sale_price',
            'last_purchase_date',
        ];
    }
}
