<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class LinkController extends Controller
{
    
    public function indexReservations()
    {
        return view('navigations.reservation');
    }
    public function indexApropos()
    {
        return view('navigations.apropos');
    }
    public function indexContact()
    {
        return view('navigations.contact');
    }
    public function indexFaq()
    {
        return view('navigations.faq');
    }
    public function indexPolitiq()
    {
        return view('navigations.politiq');
    }
}
