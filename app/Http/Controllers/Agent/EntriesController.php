<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SavingRmEntries;
use Illuminate\Support\Facades\DB;

class EntriesController extends Controller
{
    public function index(Request $request)
    {
        //$entries = SavingRmEntries::whereDate('entry_date',date('Y-m-d'))->get();

        $rowCount  = 20;
        $filter = ['search' => $request->search ?? "", 'date' => $request->date ?? date('Y-m-d')];
        $entries = SavingRmEntries::with('agent', 'RmDetail');
        if (!empty($filter['search'])) {
            $entries = $entries->whereHas('RmDetail', function ($q) use ($request) {
                return $q->where('name', 'LIKE', "%$request->search%");
            });
        }
        if (!empty($request->agent)) {
            $entries = $entries->where('user_id', $request->agent);
        }
        if (!empty($request->amount_type)) {
            $entries = $entries->where('amount_type', $request->amount_type);
        }

        $entries = $entries->whereDate('entry_date', $filter['date'])->orderBy('id', 'DESC')->paginate($rowCount);
        if ($request->ajax()) {
            $list =  view('agents.entries.list', compact('entries'))->render();
            return response()->json(['status' => 1, 'data' => $list], 200);
        }
        return view('agents.entries.index', compact('entries'));
    }

    public function corruptedEntries()
    {
        try {

            $entries = SavingRmEntries::leftJoin('saving_rms', 'saving_rms.id', '=', 'saving_rm_entries.rm_id')
                ->leftJoin('saving_customers', 'saving_customers.id', '=', 'saving_rm_entries.user_id')
                ->select(
                    'saving_rm_entries.id',
                    'saving_rm_entries.amount',
                    'saving_rm_entries.entry_date',
                    'saving_rm_entries.rm_id',
                    'saving_customers.name as customer_name',
                    'saving_customers.mobile as customer_mobile',
                )
                ->whereNull('saving_rms.id')
                // ->groupBy(
                //     'saving_rm_entries.rm_id',
                //     'saving_customers.name',
                //     'saving_customers.mobile'
                // )
                ->orderBy('saving_rm_entries.entry_date', 'ASC')
                ->take(50)->get();

            return view('agents.currepted_entries.index', compact('entries'));
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
    }
}
