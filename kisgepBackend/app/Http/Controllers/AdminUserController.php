<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class AdminUserController extends Controller
{
    public function index()
    {
        $users = User::paginate(15);
        return view('admin.users.index', compact('users'));
    }
    
    public function show(User $user)
    {
        $rendelesek = $user->rendelesek()->orderBy('created_at', 'desc')->get();
        return view('admin.users.show', compact('user', 'rendelesek'));
    }
    
    public function destroy(User $user)
    {
        // Admin felhasználót nem lehet törölni
        if ($user->is_admin) {
            return redirect()->route('admin.felhasznalok.index')
                ->with('error', 'Admin felhasználót nem lehet törölni!');
        }
        
        $user->delete();
        
        return redirect()->route('admin.felhasznalok.index')
            ->with('success', 'Felhasználó sikeresen törölve!');
    }
}
