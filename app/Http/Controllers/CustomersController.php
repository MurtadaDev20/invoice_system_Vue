<?php

namespace App\Http\Controllers;

use App\Models\Customers;
use Illuminate\Http\Request;

class CustomersController extends Controller
{
    public function all_customer(){
        $customers  = Customers::orderBy('id','DESC')->get();

        return response()->json([
            'customers' => $customers,
        ],200);
    }
}
