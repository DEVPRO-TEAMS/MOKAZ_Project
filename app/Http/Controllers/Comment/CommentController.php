<?php

namespace App\Http\Controllers\Comment;

use App\Models\Comment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Comment::with('property', 'appart');

        if ($request->filled('search')) {
            $query->whereHas('appart', function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                    ->orWhere('code', 'like', '%' . $request->search . '%')
                    ->orWhere('commodities', 'like', '%' . $request->search . '%')
                    ->orWhere('nbr_room', 'like', '%' . $request->search . '%')
                    ->orWhere('nbr_bathroom', 'like', '%' . $request->search . '%')
                    ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // Filtre par date
        if ($request->filled('date_debut') && $request->filled('date_fin')) {
            $query->whereBetween('created_at', [
                $request->date_debut . ' 00:00:00',
                $request->date_fin . ' 23:59:59'
            ]);
        } elseif ($request->filled('date_debut')) {
            $query->where('created_at', '>=', $request->date_debut . ' 00:00:00');
        } elseif ($request->filled('date_fin')) {
            $query->where('created_at', '<=', $request->date_fin . ' 23:59:59');
        }

        // Filtre par statut
        if ($request->filled('status')) {
            $query->where('etat', $request->status);
        }

        if (Auth::user()->user_type == 'admin') {
            $comments = $query->where('etat', 'actif')->orderBy('created_at', 'desc')->get();
        } else {

            $comments = $query->where('etat', 'actif')->where('partner_uuid', Auth::user()->partner_uuid)->orderBy('created_at', 'desc')->get();
        }
        return view('comments.index', compact('comments'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
}
