<?php

namespace App\Http\Controllers;

use App\Models\EarningHistory;
use Illuminate\Http\Request;

class EarningHistoryController extends Controller
{
    //

    public function index()
    {
        $earningHistory = EarningHistory::with('instructor')->get();
        return response()->json(['earning_history' => $earningHistory]);
    }

    public function store(Request $request)
    {
        // Validation and create logic for earning history
    }

    public function show(EarningHistory $earningHistory)
    {
        return response()->json(['earning_history' => $earningHistory]);
    }

    public function updateStatus(Request $request, EarningHistory $earningHistory)
    {
        $request->validate([
            'status' => 'required|in:pending,accept,reject', // Define the allowed status values
        ]);
    
        $earningHistory->status = $request->input('status');
        $earningHistory->save();
    
        return response()->json(['message' => 'Earning history status updated successfully']);
    }

    public function destroy(EarningHistory $earningHistory)
    {
        $earningHistory->delete();
        return response()->json(['message' => 'Earning history deleted successfully']);
    }

}
