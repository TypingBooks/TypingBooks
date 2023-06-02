<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    
    
    public function getAllTestResults() {
        
        $scores = \App\TestResult::where('user', '=', Auth::id())->orderBy('created_at', 'ASC')->get();

        return scores;
        
    }
    
    public function getAverageForAllTestResults() {
        
        $averageWPM = number_format(\App\TestResult::where('user', '=', Auth::id())->avg('wpm'), 2);
        
        if(!isset($averageWPM)) {
            
            $averageWPM = number_format(0, 2);
            
        }
      
        return averageWPM;
        
    }
    
    
    public function getTestResultsWithBook($bookId) {
        
        $scores = \App\TestResult::where('user', '=', Auth::id())->where('book', '=', $bookId)->orderBy('created_at', 'ASC')->get();
        
        return scores;
        
    }
    
    public function getStatsAddress() {
        
        return url('/stats/' . $this->id);
        
    }
    
    public function getAverageForTestResultsWithBook($bookId) {
        
        $averageWPM = number_format(\App\TestResult::where('user', '=', Auth::id())->where('book', '=', $bookId)->avg('wpm'), 2);
        
        if(!isset($averageWPM)) {
            
            $averageWPM = number_format(0, 2);
            
        }
        
        return averageWPM;
        
    }
    
    public function getTestResultsWithLanguage($languageId) {
        
        $scores = \App\TestResult::where('user', '=', Auth::id())->where('language', '=', $languageId)->orderBy('created_at', 'ASC')->get();
        
        return scores;
        
    }
    
    public function getAverageForTestResultsWithLanguage($languageId) {
        
        $averageWPM = number_format(\App\TestResult::where('user', '=', Auth::id())->where('language', '=', $languageId)->avg('wpm'), 2);
        
        if(!isset($averageWPM)) {
            
            $averageWPM = number_format(0, 2);
            
        }
        
        return averageWPM;
        
    }
    
    public function getLocale() {
        
        if($this->hasLocale()) {
            
            return $this->locale;
            
        }
        
        return 'en';
        
    }
        
    public function hasLocale() {
        
        if($this->locale != null) {
            
            return true;
            
        }
        
        return false;
        
    }
    
}
