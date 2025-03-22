<?php

namespace App\Http\Controllers;

use App\Models\Bale;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AdminController extends Controller
{
   
    public function index()
    {
        return $this->admin(); // ok
    }

    public function admin()
    {
        $bales = Bale::all();
        $agents = User::where('role', 'agent')->get();
        $buyers = User::where('role', 'buyer')->get();
        return view('admin', compact('bales', 'agents', 'buyers'));
    }

    // Gestion des balles
    public function storeBale(Request $request)
    {
        $request->validate([
            'reference' => 'required|string|unique:bales,reference',
            'quality' => 'required|string',
            'weight' => 'required|numeric',
            'private_data' => 'nullable|string',
        ]);

        Bale::create($request->all());
        return redirect()->route('admin')->with('success', 'Balle ajoutée avec succès.');
    }

    public function updateBale(Request $request, $id)
    {
        $request->validate([
            'reference' => 'required|string|unique:bales,reference,' . $id,
            'quality' => 'required|string',
            'weight' => 'required|numeric',
            'private_data' => 'nullable|string',
        ]);

        $bale = Bale::findOrFail($id);
        $bale->update($request->all());
        return redirect()->route('admin')->with('success', 'Balle mise à jour avec succès.');
    }

    public function destroyBale($id)
    {
        $bale = Bale::findOrFail($id);
        $bale->delete();
        return redirect()->route('admin')->with('success', 'Balle supprimée avec succès.');
    }

    // Gestion des utilisateurs (agents ou acheteurs)
    public function storeUser(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => 'required|string|min:8',
            'role' => 'required|in:agent,buyer',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return redirect()->route('admin')->with('success', 'Utilisateur ajouté avec succès.');
    }

    public function updateUser(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'role' => 'required|in:agent,buyer',
        ]);

        $user = User::findOrFail($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
        ]);

        return redirect()->route('admin')->with('success', 'Utilisateur mis à jour avec succès.');
    }

    public function destroyUser($id)
    {
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->route('admin')->with('success', 'Utilisateur supprimé avec succès.');
    }
}
