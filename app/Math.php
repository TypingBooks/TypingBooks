<?php

namespace App;

class Math {
    
	public static function roundUp($number, $precision = 2) {
	
	    $fig = (int) str_pad('1', $precision, '0');
	    
	    return (ceil($number * $fig) / $fig);
	    
	}
	
	public static function roundDown($number, $precision = 2) {
	
	    $fig = (int) str_pad('1', $precision, '0');
	    
	    return (floor($number * $fig) / $fig);
	    
	}
    
}