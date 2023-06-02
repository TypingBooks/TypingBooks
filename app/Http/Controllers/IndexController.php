<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    public function index(Request $request) {
		
		$locale = 'en';
		
		if($request->session()->get('locale') != null) {
			
			$locale = $request->session()->get('locale');
			
		}
		
		$localeID = \App\Language::where('abbreviation', '=', $locale)->first()->abbreviation;
	
		return view('homepage', compact('localeID'));
	}
}
