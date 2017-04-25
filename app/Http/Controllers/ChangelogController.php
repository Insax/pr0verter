<?php

namespace App\Http\Controllers;

use GrahamCampbell\GitHub\Facades\GitHub;

class ChangelogController extends Controller
{
    public function index()
    {
        $data = GitHub::repo()->commits()->all('Insax', 'pr0verter', ['sha' => 'master']);
        $object = json_decode(json_encode($data), false);

        return view('changelog.home', ['data' => $object]);
    }
}
