<?php

namespace App\Http\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserVedika;
use Illuminate\Support\Facades\Hash;

class UserVedikaController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        $title = 'User Vedika';
        $search = $request->input('search');
        $uservedikas = UserVedika::when($search, function ($query, $search) {
            return $query->where('nama', 'like', "%{$search}%")
                         ->orWhere('username', 'like', "%{$search}%")
                         ->orWhere('level', 'like', "%{$search}%");
        })->paginate(10);
        return view('admin.uservedika', compact('uservedikas','title'));
    }

    public function create()
    {
        $title = 'Tambah User Vedika';
        return view('admin.createuservedika', compact('title'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama' => 'required|string|max:255',
            'username' => 'required|string|max:255|unique:uservedika,username',
            'password' => 'required|string|min:6',
            'level' => 'required|string',
        ]);

        try {
            UserVedika::create([
                'nama' => $validated['nama'],
                'username' => $validated['username'],
                'password' => Hash::make($validated['password']),
                'level' => $validated['level'],
            ]);
    
            return redirect()->route('uservedika.index')->with('success', 'User created successfully.');
        } catch (\Exception $e) {
            return redirect()->route('uservedika.index')->with('error', 'There was an error creating the user.');
        }
    }

    public function show(Uservendika $uservedika)
    {
        $title = 'Tambah User Vedika';
        return view('uservedika.show', compact('uservedika', compact('title')));
    }

    public function edit(UserVedika $uservedika)
    {
        $title = 'Edit User Vedika';
        return view('admin.edituservedika', compact('uservedika','title'));
    }

    public function update(Request $request, UserVedika $uservedika)
    {
      $validatedData = $request->validate([
            'nama' => 'required',
            'username' => 'required|unique:uservedika,username,' . $uservedika->id_uservedika . ',id_uservedika',
            'level' => 'required',
            'password' => 'nullable|min:8',
        ]);

        $uservedika->update([
            'nama' => $validatedData['nama'],
            'username' => $validatedData['username'],
            'level' => $validatedData['level'],
            'password' => $validatedData['password'] ? Hash::make($validatedData['password']) : $uservedika->password,
        ]);

        return redirect()->route('uservedika.index')
                         ->with('success', 'User created successfully.');
    
    }

    public function destroy(UserVedika $uservedika)
    {
        $uservedika->delete();
        return redirect()->route('uservedika.index')
                        ->with('success', 'User deleted successfully.');
    }
}