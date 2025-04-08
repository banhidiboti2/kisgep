<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function showRegistrationForm()
    {
        return view('auth.register');
    }
    
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'vezeteknev' => 'required|string|max:255',
            'keresztnev' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'jelszo' => 'required|string|min:8|confirmed',
            'telefonszam' => 'required|string|max:20',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $user = User::create([
            'vezeteknev' => $request->vezeteknev,
            'keresztnev' => $request->keresztnev,
            'email' => $request->email,
            'jelszo' => Hash::make($request->jelszo),
            'telefonszam' => $request->telefonszam,
        ]);
        
        Auth::login($user);
        
        return redirect()->route('home')->with('success', 'Sikeres regisztráció!');
    }
    
    public function showLoginForm()
    {
        return view('auth.login');
    }
    
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'jelszo' => 'required',
        ]);
        
        if (Auth::attempt(['email' => $credentials['email'], 'password' => $credentials['jelszo']])) {
            $request->session()->regenerate();
            return redirect()->intended('/');
        }
        
        return back()->withErrors([
            'email' => 'A megadott adatok nem egyeznek a nyilvántartásunkkal.',
        ])->withInput();
    }
    
    public function logout(Request $request)
    {
        Auth::logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect('/');
    }
    
    public function profil()
    {
        return view('auth.profil', ['user' => Auth::user()]);
    }
    
    public function updateProfil(Request $request)
    {
        $user = Auth::user();
        
        $validator = Validator::make($request->all(), [
            'vezeteknev' => 'required|string|max:255',
            'keresztnev' => 'required|string|max:255',
            'telefonszam' => 'required|string|max:20',
            'current_password' => 'nullable|required_with:new_password',
            'new_password' => 'nullable|min:8|confirmed',
        ]);
        
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        
        $user->vezeteknev = $request->vezeteknev;
        $user->keresztnev = $request->keresztnev;
        $user->telefonszam = $request->telefonszam;
        
        if ($request->filled('current_password') && $request->filled('new_password')) {
            if (!Hash::check($request->current_password, $user->password)) {
                return back()->withErrors([
                    'current_password' => 'A jelenlegi jelszó nem helyes.',
                ]);
            }
            
            $user->password = Hash::make($request->new_password);
        }
        
        $user->save();
        
        return redirect()->route('profil')->with('success', 'Profil sikeresen frissítve!');
    }
}
