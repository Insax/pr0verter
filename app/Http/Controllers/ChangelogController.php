<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use GrahamCampbell\GitHub\Facades\GitHub;

class ChangelogController extends Controller
{
    public function index()
    {
        $data = GitHub::repo()->commits()->all('Insax', 'pr0verter', array('sha' => 'master'));
        $object = json_decode(json_encode($data), FALSE);
        return view('changelog.home', ['data' => $object]);
    }
}
