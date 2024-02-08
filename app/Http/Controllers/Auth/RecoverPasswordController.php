<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class RecoverPasswordController extends Controller
{
    public function showResetForm(Request $request)
    {
        // Obtener el correo electrónico desde la solicitud
        $email = $request->input('email');

        // Validar si el usuario con ese correo electrónico existe
        $user = User::where('email', $email)->first();

        if ($user) {
            return view('recover-password', ['user' => $user]);
        } else {
            return view('auth.invalid-email');
        }
    }

public function reset(Request $request)
{
    $request->validate([
        'user_id' => 'required|exists:users,id',
        'new_password' => 'required|string|min:8|confirmed'
    ]);

    if($request->new_password === $request->new_password_confirmation){
        $user = User::findOrFail($request->user_id);
        $user->password = Hash::make($request->new_password);
        $user->save();
        return view('auth.password-changed');
    } else {
        return redirect()->back()->with('error', 'Los campos de la nueva contraseña no coinciden.');
    }


    
}
}
