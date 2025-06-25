<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('users.pages.index');
    }

   public function store(Request $request)
    {
        DB::beginTransaction();

        try{
            
            $validated = $request->validate([
                'name'       => 'required|string|max:255',
                'lastname'   => 'nullable|string|max:255',
                'phone'      => 'nullable|string|max:20',
                'email'      => 'required|email|unique:users,email',
                'password'   => 'required|string|min:8|confirmed',
                'user_type'  => 'nullable|string',
                'role_id'    => 'nullable|string',
            ]);

            $user = User::create([
                'uuid'        => Str::uuid(),
                'name'        => $validated['name'],
                'lastname'    => $validated['lastname'] ?? null,
                'phone'       => $validated['phone'] ?? null,
                'email'       => $validated['email'],
                'password'    => Hash::make($validated['password']),
                'user_type'   => $validated['user_type'] ?? null,
                'role_id'     => $validated['role_id'] ?? null,
                'token'       => null,
                'is_logged_in'=> false,
            ]);

            DB::commit();

            return response()->json(['message' => 'Utilisateur créé avec succès', 'user' => $user]);
        }catch (\Exception $e){
            
            return response()->json(['message' => 'Une erreur s\'est produite lors de la création de l\'utilisateur' . $e], 500);
        }
        
    }

    /**
     * Update an existing user.
     */
    public function update(Request $request, $id)
    {

        try{
            DB::beginTransaction();

            $user = User::findOrFail($id);

            $validated = $request->validate([
                'name'       => 'sometimes|string|max:255',
                'lastname'   => 'nullable|string|max:255',
                'phone'      => 'nullable|string|max:20',
                'email'      => 'required|email|unique:users,email,' . $user->id,
                'password'   => 'nullable|string|min:8|confirmed',
                'user_type'  => 'nullable|string',
                'role_id'    => 'nullable|string',
            ]);

            $user->update([
                'name'       => $validated['name'] ?? $user->name,
                'lastname'   => $validated['lastname'] ?? $user->lastname,
                'phone'      => $validated['phone'] ?? $user->phone,
                'email'      => $validated['email'],
                'user_type'  => $validated['user_type'] ?? $user->user_type,
                'role_id'    => $validated['role_id'] ?? $user->role_id,
                'password'   => !empty($validated['password']) ? Hash::make($validated['password']) : $user->password,
            ]);

            DB::commit();

            return response()->json(['message' => 'Utilisateur mis à jour avec succès', 'user' => $user]);
        }catch (\Exception $e){
            return response()->json(['message' => 'Une erreur s\'est produite lors de la mise à jour de l\'utilisateur' . $e], 500);
        }
        

        
    }

    /**
     * Remove (soft delete) the specified user.
     */
    public function destroy($id)
    {
        try{
            DB::beginTransaction();

            $user = User::findOrFail($id);
            $user->delete();

            DB::commit();

            return response()->json(['message' => 'Utilisateur supprimé avec succès']);

        }catch (\Exception $e){
            return response()->json(['message' => 'Une erreur s\'est produite lors de la suppression de l\'utilisateur' . $e], 500);
        }
        
    }
}
