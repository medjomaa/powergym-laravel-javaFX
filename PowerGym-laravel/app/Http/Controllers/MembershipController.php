<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Membership;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class MembershipController extends Controller
{
    // Handle the form submission
    public function store(Request $request)
    {
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email',
                'phone' => 'required|string|max:20',
                'membership_duration' => 'required|in:1,3,6',
                'paid_status' => 'required|in:0,1',
            ]);

            // Check if a membership with the same email and phone exists
            $existingMembership = Membership::where('email', $request->email)
                ->where('phone', $request->phone)
                ->first();

            if ($existingMembership) {
                // Update the existing membership record
                $existingMembership->name = $request->input('name');
                $existingMembership->membership_type = $this->getMembershipType($request->input('membership_duration'));
                $existingMembership->paid = $request->input('paid_status');
                $existingMembership->save();

                return back()->with('success', 'Membership details updated successfully!');
            } else {
                // Create a new membership record
                $membershipData = [
                    'name' => $request->input('name'),
                    'email' => $request->input('email'),
                    'phone' => $request->input('phone'),
                    'membership_type' => $this->getMembershipType($request->input('membership_duration')),
                    'paid' => $request->input('paid_status'),
                ];

                Membership::create($membershipData);

                return back()->with('success', 'Your membership form has been submitted successfully!');
            }
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        }
    }

    // Helper function to determine membership type based on duration
    private function getMembershipType($duration)
    {
        switch ($duration) {
            case '1':
                return 'monthly';
            case '3':
                return 'quarterly';
            case '6':
                return 'yearly';
            default:
                return 'monthly'; // Default to monthly if unexpected value
        }
    }

    // Display all membership submissions to the admin
    public function index(Request $request)
{
    $query = Membership::query();

    // Sorting logic
    $sortBy = $request->input('sort_by', 'name'); // Default sort by name
    $sortOrder = $request->input('sort_order', 'asc'); // Default sort order ascending

    // Handle different sorting options
    switch ($sortBy) {
        case 'paid':
            $query->orderBy('paid', $sortOrder);
            break;
        case 'name':
        default:
            $query->orderBy('name', $sortOrder);
            break;
    }

    // Search logic
    $search = $request->input('search');
    if ($search) {
        $query->where(function ($q) use ($search) {
            $q->where('name', 'like', '%' . $search . '%')
              ->orWhere('email', 'like', '%' . $search . '%')
              ->orWhere('phone', 'like', '%' . $search . '%')
              ->orWhere('membership_type', 'like', '%' . $search . '%');
        });
    }

    $memberships = $query->get();

    return view('memberships.admin_index', compact('memberships'));
}

    // Method to update payment status
    public function updatePaymentStatus(Request $request, $id)
    {
        try {
            $request->validate([
                'paid_status' => 'required|in:0,1',
            ]);

            $membership = Membership::findOrFail($id);
            $membership->paid = $request->paid_status;
            $membership->save();

            return back()->with('success', 'Payment status updated successfully.');
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to update payment status.');
        }
    }

    // Method to approve a membership (simulating approval process)
    public function approve($id)
    {
        $membership = Membership::find($id);

        if (!$membership || $membership->paid !== '1') {
            return back()->with('error', 'Membership is not marked as paid or does not exist.');
        }

        // Creating a new user with membership details
        $user = User::create([
            'name' => $membership->name,
            'email' => $membership->email,
            'password' => Hash::make($membership->phone), // Temporary password, adjust as needed
            'phone' => $membership->phone, // Store the phone number in the users table
        ]);

        // Delete the membership record after approval
        $membership->delete();

        return back()->with('success', 'Membership approved and user account created.');
    }
}
