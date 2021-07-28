<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contact;
use App\Models\Product;
use Luecano\NumeroALetras\NumeroALetras;
use DB;

class AjaxController extends Controller
{
    public function getproviders(Request $request){

        $search = $request->search;

        if($search == ''){
        $providers = Contact::orderby('business_name','asc')
                            ->select('id','business_name as text','ci')
                            ->where('type','provider')
                            ->limit(5)->get();
        }else{
        $providers = Persona::orderby('business_name','asc')
                            ->select('id','business_name as text','ci')
                            ->where('type','provider')
                            ->where('ci', 'like', '%' .$search . '%')
                            ->limit(5)->get();
        }

        return response()->json($providers);
    }

    public function getcustomers(Request $request){

        $search = $request->search;

        if($search == ''){
        $customers = Contact::orderby('fullName','asc')
                            ->select('id','fullName as text','ci')
                            ->where('type','customer')
                            ->limit(5)->get();
        }else{
        $customers = Persona::orderby('fullName','asc')
                            ->select('id','fullName as text','ci')
                            ->where('type','customer')
                            ->where('ci', 'like', '%' .$search . '%')
                            ->limit(5)->get();
        }

        return response()->json($customers);
    }

    public function print_bar_code(Request $request){
        $productos = Product::select('id', 'barcode')->whereIn('id', $request->input_print)->get();
        $cantidad = $request->cantidad ?? 1;
        return view('inventarios.productos.partials.print_bar_code', compact('productos', 'cantidad'));
    }
}
