<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Instructor;
use App\Models\WithdrawalHistory;
use App\Models\EarningHistory;


class InstructorController extends Controller
{
    //

    public function index()
    {
        $instructors = Instructor::all();

        return response()->json(['instructors' => $instructors]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:instructors',
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            // Add validation rules for other fields as needed
        ]);

        $imagePath = $request->file('image')->store('instructor_images', 'public');

        $instructor = Instructor::create(array_merge(
            $request->all(),
            ['image' => $imagePath]
        ));

        return response()->json(['message' => 'Instructor created successfully', 'instructor' => $instructor]);
    }

    public function show($id)
    {
        $instructor = Instructor::findOrFail($id);

        // Retrieve all accepted withdrawal histories for the specific instructor
        $withdrawalHistories = WithdrawalHistory::where('instructor_id', $id)
            ->where('status', 'accept')
            ->get();

        // Calculate the sum of withdrawal amounts
        $totalWithdrawalAmount = $withdrawalHistories->sum('amount');

        // Retrieve the instructor's total earnings with "accept" status
        $totalEarnings = EarningHistory::where('instructor_id', $id)
            ->where('status', 'accept')
            ->sum('amount');

        // Calculate the available balance
        $availableBalance = $totalEarnings - $totalWithdrawalAmount;

        return response()->json([
            'instructor' => $instructor,
            'total_earnings' => $totalEarnings,
            'total_withdrawal' => $totalWithdrawalAmount,
            'available_balance' => $availableBalance,
        ]);
    }

    public function update(Request $request, $id)
    {
        $instructor = Instructor::findOrFail($id);

        $request->validate([
            'first_name' => 'required',
            'last_name' => 'required',
            'email' => 'required|email|unique:instructors,email,' . $instructor->id,
            // Add validation rules for other fields as needed
        ]);

        $instructor->update($request->all());

        return response()->json(['message' => 'Instructor updated successfully', 'instructor' => $instructor]);
    }

    public function destroy($id)
    {
        $instructor = Instructor::findOrFail($id);
        $instructor->delete();

        return response()->json(['message' => 'Instructor deleted successfully']);
    }







    //Get instructor earning 
    public function getEarnings($id)
    {
        $instructor = Instructor::findOrFail($id);
        $earnings = $instructor->earningHistories;
        $totalEarnings = $instructor->getTotalEarnings();

        return response()->json([
            'instructor' => $instructor,
            'total_earnings' => $totalEarnings
        ]);
    }
}
