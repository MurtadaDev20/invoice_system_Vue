<?php

namespace App\Http\Controllers;

use App\Models\Counter;
use Illuminate\Http\Request;
use App\Models\Invoices;
use App\Models\InvoicesItem;

class InvoicesController extends Controller
{
    public function get_all_invoice(){
        $invoices = Invoices::with('customer')->orderBy('id','DESC')->get();
        return response()->json([
            'invoices' => $invoices,
        ],200);
    }

    public function search_invoice(Request $request){
        $search = $request->get('s');
        if($search != null){
            $invoices = Invoices::with('customer')
            ->where('id','LIKE',"%$search%")
            ->orWhere('number', 'LIKE', "%$search%")
            ->orWhere('total', 'LIKE', "%$search%")
            ->get();

            return response()->json([
                'invoices' => $invoices
            ],200);
        }else {
            return $this->get_all_invoice();
        }
    }

    public function create_invoice(Request $request){
        $counter = Counter::where('key','invoice')->first();
        $random =   Counter::where('key','invoice')->first();

        $invoice = Invoices::orderBy('id','DESC')->first();
        if($invoice){
            $invoice = $invoice->id+1;
            $counters = $counter->value + $invoice;
        }else{
            $counter = $counter->value;
        }

        $formData = [
            'number' => $counter->prefix.$counters,
            'customer_id' => null,
            'customer' => null,
            'date' => date('Y-m-d'),
            'due_date' => null,
            'reference' => null,
            'discount' =>0,
            'term_and_conditions' => 'Default Terms and Conditions',
            'items' =>
                [
                   'product_id' => null,
                   'product' => null,
                   'unit_price' => 0, 
                   'quantity' => 1
                ],
            ];
            return response()->json($formData);
    }

    public function add_invoice(Request $request){

        $invoiceitem = $request->input("invoice_item");

        $invoicedata['sub_total'] = $request->input("subtotal");
        $invoicedata['total'] = $request->input("total");
        $invoicedata['customer_id'] = $request->input("customer_id");
        $invoicedata['date'] = $request->input("date");
        $invoicedata['due_date'] = $request->input("due_date");
        $invoicedata['reference'] = $request->input("reference");
        $invoicedata['discount'] = $request->input("discount");
        $invoicedata['number'] = $request->input("number");
        $invoicedata['terms_and_conditions'] = $request->input("terms_and_conditions");

        $invoice = Invoices::create($invoicedata);

        foreach (json_decode($invoiceitem)as $item){
            $itemData['product_id'] = $item->id;
            $itemData['invoice_id'] = $invoice->id;
            $itemData['quantity'] = $item->quantity;
            $itemData['unit_price'] = $item->unit_price;

            InvoicesItem::create($itemData);
        }

    }
    
    public function show_invoice($id){
        $invoice = Invoices::with(['customer','invoices_items.product'])->find($id);

        return response()->json([
            'invoice' => $invoice,
        ],200);
    }
}
