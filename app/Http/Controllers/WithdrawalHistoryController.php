<?php

namespace App\Http\Controllers;

use App\Models\Instructor;
use App\Models\WithdrawalHistory;
use Illuminate\Http\Request;

class WithdrawalHistoryController extends Controller
{
    //

    public function index(Request $request)
    {
        $status = $request->input('status');
        $instructorId = $request->input('instructor_id');


        // Retrieve the withdrawal histories based on the status and instructor_id conditions
        $withdrawalHistories = WithdrawalHistory::where(function ($query) use ($status, $instructorId) {

            if ($status) {
                $query->where('status', $status);
            }
            if ($instructorId) {
                $query->where('instructor_id', $instructorId);
            }

        })->get();

        return response()->json(['withdrawal_histories' => $withdrawalHistories]);
    }


    public function store(Request $request)
    {
        $request->validate([
            'instructor_id' => 'required',
            'amount' => 'required|numeric|min:0',
        ]);

        $instructorId = $request->input('instructor_id');
        $withdrawalAmount = $request->input('amount');



        // Retrieve all accepted withdrawal histories for the specific instructor
        $withdrawalHistories = WithdrawalHistory::where('instructor_id', $instructorId)
            ->where('status', 'accept')
            ->get();

        // Calculate the sum of withdrawal amounts
        $totalWithdrawalAmount = $withdrawalHistories->sum('amount');

        // Retrieve the instructor's total earnings with "accept" status
        $totalEarnings = Instructor::findOrFail($instructorId)
            ->earningHistories()
            ->where('status', 'accept')
            ->sum('amount');


            $finalAvaibleBalance = $totalEarnings - $totalWithdrawalAmount;



        // Check if the withdrawal amount is less than or equal to the total earnings
        if ($withdrawalAmount <= $finalAvaibleBalance) {
            // Create the withdrawal history record
            WithdrawalHistory::create([
                'instructor_id' => $instructorId,
                'amount' => $withdrawalAmount,
                'status' => 'pending', // Set the initial status as pending
            ]);

            return response()->json(['message' => 'Withdrawal history created successfully']);
        }

        return response()->json(['message' => 'Withdrawal amount exceeds total earnings']);
    }
}
