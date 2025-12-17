<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavingRm;
class CustomerController extends Controller
{
    public function index()
    {
        return view('agents.customer.index');
    }
    public function getCustomersData(Request $request){

        $customers = SavingRm::with('customer')->company();
        if($request->search != ''){
            $customers = $customers->whereHas('customer',function($q) use ($request){
                return $q->where('name','LIKE','%'.$request->search.'%');
            });
        }
        $customers = $customers->orderBy('name','ASC')->paginate(20);
        /* $customers = $customers->map(function ($item) {
            return $item->formatData();
        }); */
        $listHtml = view('agents.customer.customer-list', compact('customers'))->render();
        $pagination = $customers->links('agents.pagination.default')->render();
        return response()->json(['status'=>1,'data'=>['list'=>$listHtml,'pagination'=>$pagination]], 200);
    }
    public function getCustomerDetail(Request $request){

        $customers = SavingRm::with('customer')->company();
        if($request->search != ''){
            $customers = $customers->whereHas('customer',function($q) use ($request){
                return $q->where('name','LIKE','%'.$request->search.'%');
            });
        }
        $customers = $customers->paginate(20);
        $customers = $customers->map(function ($item) {
            return $item->formatData();
        });
        $listHtml = view('agents.customer.customer-list', compact('customers'))->render();
        return response()->json(['status'=>1,'data'=>$listHtml], 200);
    }
}
