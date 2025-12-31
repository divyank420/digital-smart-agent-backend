<?php

namespace App\Http\Controllers\Agent;

use App\Http\Controllers\Controller;
use App\Models\PromotionalMessage;
use Illuminate\Http\Request;

class PromotionalMessageController extends Controller
{
    public function index()
    {
        $messages = PromotionalMessage::latest()->get();
        return view('agents.promotions.index', compact('messages'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'nullable|string|max:255',
            'message' => 'required|string',
            'is_active' => 'required|boolean',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date',
            'position' => 'required|in:top,middle,bottom,end',
        ]);
        PromotionalMessage::create($request->all());

        return redirect()->back()->with('success', 'Promotional message created.');
    }
    public function update(Request $request, $id)
    {
        $promotion = PromotionalMessage::findOrFail($id);
        $promotion->update($request->all());

        return redirect()->back()->with('success', 'Promotional message updated.');
    }

    public function destroy($id)
    {
        PromotionalMessage::destroy($id);
        return redirect()->back()->with('success', 'Promotional message deleted.');
    }
}
