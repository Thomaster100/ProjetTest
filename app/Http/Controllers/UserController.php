<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\Permission;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Hash;
use Illuminate\Auth\Events\Registered;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Mail;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request) {

        $request->validate([
            'name' => 'required|string|min:5|max:255',
            'email' => 'required|email|unique:users'
        ]);
    
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt(Str::random(8)), // mot de passe temporaire ! 
        ]);

        // Evenement registred
        event(new Registered($user)); 
        $user->sendEmailVerificationNotification();
        
        return redirect()->route('users.create')->with('success', 'Un email de vérification vous a été envoyé.');
    }


    public function finishRegistrationView($id) {
        $user = User::findOrFail($id);
        return view('users.finish-creation', ['id' => $user->id]);
    }

    public function completeUser(Request $request, $id) {

        $user = User::findOrFail($id);
        if($request->password !== $request->confirmPassword) {
            return redirect()->route('finish-register', ['id' => $user->id])->with('error', 'Les mots de passe ne correspondent pas');
        }

        $request->validate([
            'password' => 'required|string|min:8',
            'role_id' => 'required|in:user,admin',
        ]);


        // Retrouver le role dans la table (pour l'ID)
        $role = Role::where('name', $request->role_id)->first();

        $user->update([
            'password' =>  bcrypt($request->input('password')),
            'role_id' => $role->id

        ]);

        return redirect()->route('login')->with('success', 'Utilisateur finalisé');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function run()
    {
        // Créer les rôles
        $adminRole = Role::create(['name' => 'admin']);
        $userRole = Role::create(['name' => 'user']);

        // Créer les permissions
        $modifyTodosPermission = Permission::create(['name' => 'modify-todos']);

        // Associer la permission au rôle administrateur
        $adminRole->permissions()->attach($modifyTodosPermission);

        // Créer les utilisateurs
        $admin = User::create([
            'name' => 'Admin User',
            'email' => 'admin@example.com',
            'password' => Hash::make('password'),
            'role_id' => $adminRole->id, // Associer le rôle administrateur
        ]);

        $user = User::create([
            'name' => 'Regular User',
            'email' => 'user@example.com',
            'password' => Hash::make('password'),
            'role_id' => $userRole->id, // Associer le rôle utilisateur
        ]);

        // Créer des utilisateurs supplémentaires (optionnel)
        for ($i = 1; $i <= 5; $i++) {
            User::create([
                'name' => "User $i",
                'email' => "user$i@example.com",
                'password' => Hash::make('password'),
                'role_id' => $userRole->id,
            ]);
        }
    }

}
