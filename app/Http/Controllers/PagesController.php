<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request; //to handle req.s

class PagesController extends Controller
{
    public function index()
    {
        $title = "welcome to laravel. Alaa!";
        // return view('pages.index',compact('title'));
        return view('pages.index')->with('title', $title);
    }
    public function about()
    {
        return view('pages.about');
    }
    public function services()
    {
        $data = array( // pass variables/data with array key=>val
            'title' => 'services',
            'services' => ['web des.', 'prog.', 'Seo']
        );
        //$title="welcome to services. Alaa!";
        return view('pages.services')->with($data);
    }
}
