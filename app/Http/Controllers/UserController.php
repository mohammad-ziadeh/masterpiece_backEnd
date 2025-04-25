<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = User::query();



        //  -------{{ Start Filters }}------- //

        if ($request->has('name') && !empty($request->name)) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }


        if ($request->has('role') && $request->role != 'all') {
            $query->where('role', $request->role);
        }

        if ($request->has('deleted')) {
            if ($request->deleted == 'only') {
                $query->onlyTrashed();
            } elseif ($request->deleted == 'with') {
                $query->withTrashed();
            }
        }

        if ($request->has('sort') && $request->sort == 'desc') {
            $query->orderBy('created_at', 'desc');
        } else {
            $query->orderBy('created_at', 'asc');
        }
        // -------{{ End Filters }}------- //

        $users = $query->paginate(10);

        return view('admin.tables.users', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("admin.tables.users");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        User::create([
            'id' => $request->id,
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return redirect('users')->with('success', 'user stored successfully.');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $users = User::findOrFail($id);
        return view("admin.tables.users", compact("users"));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $users = User::findOrFail($id);
        $users->update([
            'name' => $request->name,
            'role' => $request->role,
            'email' => $request->email,
            'password' => bcrypt($request->password),
        ]);
        return redirect('users')->with('success', 'user updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect('users')->with('success', 'User deleted successfully.');
    }

    public function restore($id)
    {
        $user = User::withTrashed()->findOrFail($id);
        $user->restore();

        return redirect()->route('users.index')->with('success', 'User restored successfully.');
    }


    public function deletePermanently($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();

        return redirect()->route('users.index')->with('success', 'User deleted permanently');
    }




    public function showUserPoints($userId)
    {
        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('users.index')->with('error', 'User not found.');
        }

        return view('tables.points', ['user' => $user]);
    }
}
