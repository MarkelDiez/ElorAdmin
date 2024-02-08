<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Department;
use App\Models\User;
use App\Models\Cycle;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        //
        $pagination = config('PAGINATION_COUNT');

        $query = User::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('surname', 'like', '%' . $request->input('search') . '%')
                  ->orWhere('dni', 'like', '%' . $request->input('search') . '%');
        }
    
        $users = $query->paginate($pagination);
        $roles = Role::all();
        $customPaginator = new LengthAwarePaginator(
            $users->items(),
            $users->total(),
            $users->perPage(),
            $users->currentPage(),
            [
                'path' => LengthAwarePaginator::resolveCurrentPath(),
                'pageName' => 'page',
            ]
        );
        return view('users.index',['users'=>$users], compact('customPaginator','roles'));
    }
    public function index2(Request $request)
    {   
        $pagination = config('PAGINATION_COUNT');
        
        $users = User::OrderBy('surname','asc')->paginate($pagination);

        return view('users.index2',['users' => $users],compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'surname' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'address' => 'required|string|max:255',
            'phone' => 'required|string|max:15',
            'dni' => 'required|string|max:9|unique:users',
            'birthdate' => 'required'
        ]);

        $user = User::create([
            'name' => $data['name'],
            'surname' => $data['surname'],
            'email' => $data['email'],
            'password' => Hash::make('Elorrieta00'),
            'address' => $data['address'],
            'phone' => $data['phone'],
            'dni' => $data['dni'],
            'birthdate' => $data['birthdate']
        ]);

        return redirect()->back()->with('success', 'Usuario creado con éxito');
    }

    public function showRegistrationForm()
    {
        $ano = now()->year;
        $numDias = date('L', strtotime("$ano-12-31")) ? 366 : 365;

        $departments = Department::all();
        $cycles = Cycle::all();
        return view('registerUser', compact('departments', 'cycles', 'numDias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = new User();
        $user->name = $request->input('name');
        $user->surname = $request->input('surname');
        $user->email = $request->input('email');
        $user->address = $request->input('address');
        $user->phone = $request->input('phone');
        $user->roles = $request->input('role');
        $user->dni = $request->input('dni');
        $user->birthdate = $request->input('birthdate');
        $user->curso = $request->input('curso');
        $user->fct = $request->input('fct');
        $user->save();
        return redirect()->route('users.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(User $user)
    {
        //$user = Auth::user()->load('department', 'cycle.modules', 'cycle.users');

        $cycles = Cycle::all();
    
        return view('users.show', compact('user', 'cycles'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        //
        $users = User::all();
        $roles = Role::all();
        return view('users.edit', ['users' => $users, 'user' => $user, 'roles'=> $roles]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        // Validar los datos según tus necesidades
        $request->validate([
            'name' => 'required',
            'surname' => 'required',
            'email' => 'required|email',
            'address' => 'required',
            'phone' => 'required',
            'roles' => 'array', // Asegúrate de que 'roles' sea un array
            'dni' => 'required',
            'birthdate' => 'required'
        ]);

        // Verificar si el array de roles es nulo y quitar todos los roles del usuario
        if ($request->roles === null) {
            $user->roles()->sync([]);
        } else {
            // Verificar si el usuario ya tiene el rol 'Estudiante'
            $hasStudentRole = $user->hasRole('Estudiante');

            // Verificar si se está intentando agregar roles adicionales cuando ya tiene 'Estudiante'
            if ($hasStudentRole && count($request->roles) > 1) {
                return redirect()->back()->with('error', 'No se pueden agregar roles adicionales a un usuario con el rol "Estudiante".');
            }

            $containsEstudiante = in_array('3', $request->roles);

            // Verificar si se está intentando asignar 'Estudiante' junto con otros roles
            if ($containsEstudiante && count($request->roles) > 1) {
                return redirect()->back()->with('error', 'No se puede asignar el rol "Estudiante" junto con otros roles.');
            }

            // Actualizar los campos básicos del usuario
            $user->name = $request->name;
            $user->surname = $request->surname;
            $user->email = $request->email;
            $user->address = $request->address;
            $user->phone = $request->phone;
            $user->dni = $request->dni;

            // Actualizar roles del usuario
            $user->roles()->sync($request->roles);
        }

        // Guardar los cambios
        $user->save();

        // Redirigir a la vista de detalles del usuario o a donde desees
        return redirect()->route('users.index')->with('success', 'Usuario actualizado con éxito');
    }



    /**
     * Remove the specified resource from storage.
     */

    public function changePassword(User $user){

        $user = Auth::user();
        return view('changePassword', ['user' => $user]);
    }


    public function updatePassword(Request $request, User $user)
    {
        $request->validate([
            'password' => 'required|string|min:6',
        ]);
    
        if (!Hash::check($request->old_password, $user->password)) {
            $user->password = bcrypt($request->new_password);
            $user->save();
    
            return redirect()->back()->with('success', 'Contraseña actualizada con éxito');
        } else {
            return redirect()->back()->with('error', 'La nueva contraseña debe ser diferente de la actual.');
        }
    }
    public function destroy(User $user)
    {
        //
        try {
            if($user->id==1){
                return redirect()->back()->with('error', 'No puedes eliminar ese usuario');
            }
            $user->delete();
            return redirect()->back()->with('success', 'Usuario '.$user->name.' '.$user->surname.' borrado con exito');
        } catch (\Throwable $th) {
            return redirect()->back()->with('error', 'No se pudo eliminar el usuario');
        }
    }
   

}
