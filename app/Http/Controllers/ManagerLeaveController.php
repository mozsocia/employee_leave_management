<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use Illuminate\Support\Facades\Auth;


class ManagerLeaveController extends Controller
{
    // Your controller methods here

    // List all leaves for a manager
    public function index()
    {
        $leaves = Leave::all(); // You may want to filter by manager's leaves only
        return view('manager.leaves.index', compact('leaves'));
    }

    // Edit a leave status
    public function edit(Leave $leave)
    {
        return view('manager.leaves.edit', compact('leave'));
    }

    public function update(Request $request, Leave $leave)
    {
        $previousStatus = $leave->status;

        $leave->update($request->all());

        if ($leave->status === 'approved' && $previousStatus !== 'approved') {
            // Decrease the total_leave_days when the status is changed to 'approved'
            $user = $leave->user;
            $user->total_leave_days -= $leave->leave_days;
            $user->save();
        }

        // Redirect back to the list of leaves with a success message
        return redirect()->route('manager.leaves.index')->with('success', 'Leave updated successfully.');
    }

    // Delete a leave
    public function destroy(Leave $leave)
    {
        $leave->delete();

        // Redirect back to the list of leaves with a success message
        return redirect()->route('manager.leaves.index')->with('success', 'Leave deleted successfully.');
    }
}
