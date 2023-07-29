<?php 

Route::get('language/{locale}', function($locale){
    app()->setLocale($locale);
    session()->put('locale', $locale);
    return redirect()->back();
});