<?php 

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

Route::get('language/{locale}', function($locale){
    $appLocale=App::getLocale();
    
    if($locale==$appLocale){
        return redirect()->back();
        Log::info('Current App Locale is the same as ' . $locale);
    }else{

        App::setLocale($locale);
        Session::put('locale', $locale);
        Log::info('Locale updated to ' . $locale);
        return redirect()->back();
    }
    
});