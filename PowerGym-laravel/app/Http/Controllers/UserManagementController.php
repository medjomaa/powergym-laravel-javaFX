<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Coach;
use Illuminate\Http\Request;

class UserManagementController extends Controller
{
    public function index(Request $request)
    {
        if (!auth()->user()->isAdmin1()) {
            abort(403);
        }

        $searchQuery = $request->input('query');
        $users = User::query()
            ->when($searchQuery, function ($query) use ($searchQuery) {
                return $query->where('name', 'LIKE', "%{$searchQuery}%")
                    ->orWhere('email', 'LIKE', "%{$searchQuery}%");
            })
            ->paginate(10);

        return view('role', compact('users'));
    }

    public function suspend(User $user)
    {
        if (!auth()->user()->isAdmin1()) {
            abort(403);
        }

        $user->update(['is_suspended' => true]);

        return redirect()->route('admin.users.index')->with('success', 'User suspended successfully!');
    }

    public function unsuspend(User $user)
    {
        if (!auth()->user()->isAdmin1()) {
            abort(403);
        }

        $user->update(['is_suspended' => false]);

        return redirect()->route('admin.users.index')->with('success', 'User unsuspended successfully!');
    }

    public function destroy(User $user)
    {
        if (!auth()->user()->isAdmin1()) {
            abort(403);
        }

        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User removed successfully!');
    }

    public function updateRole(Request $request, User $user)
{
    if (!auth()->user()->isAdmin1()) {
        abort(403);
    }

    $validated = $request->validate(['role' => 'required|string']);

    // Update the user's role
    $user->update(['role' => $validated['role']]);

    // Add or remove user from coaches table based on the role
    if ($validated['role'] == 'trainers') {
        // Check if user already exists in coaches table
        if (!Coach::where('user_id', $user->id)->exists()) {
            Coach::create([
                'user_id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
            ]);
        }
    } else {
        // Remove from coaches table if exists
        Coach::where('user_id', $user->id)->delete();
    }

    return redirect()->route('admin.users.index')->with('success', 'User role updated successfully!');
}



}
