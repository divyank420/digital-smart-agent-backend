<?php

namespace App\Http\Controllers;

use App\Helper\Helper;
use App\Models\SavingRm;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class UsersController extends Controller
{
    public function index(){
        
        $data = SavingRm::where(['account_type'=>'daily'])->get()->toArray();
        $pdf = Pdf::loadView('RmCodePdf', ['data'=>$data])->setPaper('a4');
        return $pdf->download('rmCodeList.pdf');
    }
}
