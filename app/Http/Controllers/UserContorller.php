<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class UserContorller extends Controller
{
    // Display the manager creation form
    public function create()
    {
        return view('manager.create');
    }

    // Store a new manager in the database
    public function store(Request $request)
    {
        // Validate the request data
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:8',
        ]);

        // Create a new manager
        User::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'role' => 'manager', // Set the role to 'manager'
            'total_leave_days' => 0, // You can set the initial total_leave_days as needed
        ]);

        return redirect()->route('managers.create')->with('success', 'Manager created successfully');
    }
}
