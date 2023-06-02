<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function index() {
        
        $settings = \App\Settings::where('type', '=', 'default')->first();
        
        return view('admin/languages/settings', compact('settings'));
        
    }
    
    public function updateSettings(Request $request) {
        
        $settings = \App\Settings::find(1);
        
        $whitelist = $request->whitelist;
        $replaceList = $request->replaceList;
        $punctuationList = $request->punctuationList;
        
        $settings->saveToJSONReplaceList($replaceList);
        
        $settings->gloabl_whitelisted_characters = $whitelist;
        $settings->global_punctuation_characters = $punctuationList;
        
        $settings->save();
        
        return redirect()->back()->with('success', 'Updated...');
        
    }
}
