<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Language;
use \App\Mail\TranslationOrdered;
use Google\Cloud\Translate\V2\TranslateClient;
use App\Jobs\SendDiscordMessage;
use App\BookTranslation;

class LanguageController extends Controller
{
    
    public function editLanguages() {
        
        $languages = Language::orderBy('language', 'ASC')->get();
        
        return view('admin/languages/index', compact('languages'));
        
        
    }
    
    public function editLanguage($language) {
        
        $language = Language::findOrFail($language);
        
        return view('admin/languages/edit', compact('language'));
        
    }
   
    
    public function updateLanguage(Request $request, $language) {
        
        $language = Language::findOrFail($language);
        
        $whitelist = $request->whitelist;
        $replaceList = $request->replaceList;
        $punctuationList = $request->punctuationList;
        $useWhitelist = (bool)$request->useWhitelist;
        
        $language->replace_characters = \App\StringTools::createJSONReplaceList($replaceList);
        $language->whitelisted_characters = $whitelist;
        $language->punctuation_characters = $punctuationList;
        $language->use_whitelist = $useWhitelist;
        
        $language->save();
        
        return redirect()->back()->with('success', 'Updated...');
        
    }
    
    
    public function index() {
        $languages = Language::get();
        
        /*
        $string = 'I am testing my translation setup.';
        
        $from_language = \App\Language::where('abbreviation', '=', 'en')->first();
        $to_language = \App\Language::where('abbreviation', '=', 'ru')->first();
        
        $translate = new TranslateClient([
            'key' => config('google_translate.api_key'),
        ]);
        
        $result = $translate->translate($string, [
            'target' => $to_language->abbreviation,
            'source' => $from_language->abbreviation,
        ]);
        
        $string =  $result['text'];
        
        exit($string);*/
        
        
       // exit(config('google_translate.api_key'));
        
        /*==
        $key = json_decode(Storage::get('/google/bType-02ae34f91f91.json'), true);
        
        
        $translate = new TranslateClient([
            'keyFile' => $key
        ]);
        
        $translate = new TranslateClient([
            'key' => config('google_translate.api_key'),
        ]);
       
        //Language::lazyCreate('English', 'en', 'img/en.png');
        
        $languages = $translate->localizedLanguages();
        
        foreach ($languages as $language) {
            echo 'Language::lazyCreate(\''. $language['name'] . '\', \'' . $language['code'] . '\', \'img/' . $language['code']  . '.png\');<br>';
        }
        
        exit();*/
        
        
        return view('index', compact('languages'));
    }
    
    public function learnFromLanguage(Request $request, $native_abbreviation) {
        
        $languages = Language::get();
        $native_lang = Language::where('abbreviation', '=', $native_abbreviation)->first();
        
        if(!isset($native_lang)) {
            
            abort(404);
            
        }
        
        LanguageController::handleLocale($request, $native_abbreviation);
        
        return view('index', compact('languages', 'native_abbreviation', 'native_lang'));
    }
    
    public static function handleLocale($request, $language) {
        
        if (! in_array($language, ['en', 'af', 'sq', 'am', 'ar', 'hy', 'az', 'eu', 'be', 'bn', 'bs', 'bg', 'ca', 'ceb', 'ny', 'zh-CN', 'zh-TW', 'co', 'hr', 'cs', 'da', 'nl', 'eo', 'et', 'tl', 'fi', 'fr', 'fy', 'gl', 'ka', 'de', 'el', 'gu', 'ht', 'ha', 'haw', 'iw', 'hi', 'hmn', 'hu', 'is', 'ig', 'id', 'ga', 'it', 'ja', 'jw', 'kn', 'kk', 'km', 'rw', 'ko', 'ku', 'ky', 'lo', 'la', 'lv', 'lt', 'lb', 'mk', 'mg', 'ms', 'ml', 'mt', 'mi', 'mr', 'mn', 'my', 'ne', 'no', 'or', 'ps', 'fa', 'pl', 'pt', 'pa', 'ro', 'ru', 'sm', 'gd', 'sr', 'st', 'sn', 'sd', 'si', 'sk', 'sl', 'so', 'es', 'su', 'sw', 'sv', 'tg', 'ta', 'tt', 'te', 'th', 'tr', 'tk', 'uk', 'ur', 'ug', 'uz', 'vi', 'cy', 'xh', 'yi', 'yo', 'zu', 'he', 'zh'])) {
            abort(404);
        }
        
        App::setLocale($language);
        
        $request->session()->put('locale', $language);
        
        if(Auth::check()) {
            
            $user = \App\User::find(Auth::id());
            
            $user->locale = $language;
            $user->save();
            
        }
        
    }
    
}
