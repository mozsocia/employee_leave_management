<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Leave;
use App\Models\User;
use App\Notifications\LeaveCreated;
use Illuminate\Support\Facades\Auth;

class LeaveController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $leaves = $user->leaves()->orderBy('created_at', 'desc')->paginate(10);
        return view('leaves.index', compact('leaves'));
    }

    public function create()
    {
        $categoryOptions = Leave::getCategoryOptions();
        return view('leaves.create', compact('categoryOptions'));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $leaveData = $request->validate([
            'category' => 'required|in:' . implode(',', array_keys(Leave::getCategoryOptions())),
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'reason' => 'required|string',
        ]);

        $startDate = \Carbon\Carbon::parse($leaveData['start_date']);
        $endDate = \Carbon\Carbon::parse($leaveData['end_date']);
        $leaveData['leave_days'] = $startDate->diffInDays($endDate) + 1; // +1 to include both start and end dates
    
        $leaveData['user_id'] = $user->id;
        $leaveData['status'] = 'pending';

        $leave = Leave::create($leaveData);
            
                // Send notification to all managers if the user is not a manager
        if (!$user->isAdmin()) {
            $managers = User::where('role', 'manager')->get();
            foreach ($managers as $manager) {
                $manager->notify(new LeaveCreated($leave));
            }
        }

        return redirect()->route('leaves.index')->with('success', 'Leave request submitted.');
    }

    public function destroy(Leave $leave)
    {
        $user = Auth::user();

        if ($user->id !== $leave->user_id) {
            return redirect()->route('leaves.index')->with('error', 'You are not authorized to delete this leave request.');
        }

        $leave->delete();

        return redirect()->route('leaves.index')->with('success', 'Leave request deleted.');
    }
}
