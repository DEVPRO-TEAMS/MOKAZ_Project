<?php

namespace App\Http\Controllers;

use App\Models\Appartement;
use App\Models\Property;
use Illuminate\Http\Request;

use function PHPSTORM_META\type;

class PagesController extends Controller
{
    public function index()
    {
        $apparts = Appartement::where('etat', 'pending')->get();
        return view('welcome', compact('apparts'));
    }
    public function getAllProperties()
    {
        // Récupérer tous les propriétés avec latitude et longitude
        $properties = Property::where(['etat'=>'pending'])->get();
        // $properties = Property::select('title', 'longitude', 'latitude', 'image_property')->where(['etat'=>'Actif'])->get();
        return response()->json($properties);
    }
    public function indexReservations()
    {
        return view('pages.reservation');
    }
    public function indexApropos()
    {
        return view('pages.apropos');
    }
    public function indexContact()
    {
        return view('pages.contact');
    }
    public function indexFaq()
    {
        return view('pages.faq');
    }
    public function indexPolitiq()
    {
        return view('pages.politiq');
    }
    public function show()
    {
        return view('pages.detail');
    }
}
