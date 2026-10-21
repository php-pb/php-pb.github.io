<?php

namespace App\Http\Controllers;

use App\Models\User;

class SpeakerController extends Controller
{
    public function index()
    {
        $speakers = User::has('speakingEvents')->with('speakingEvents')->orderBy('name')->get();

        return view('speakers.index', ['speakers' => $speakers]);
    }
}
