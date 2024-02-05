<?php 

use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;

if(!function_exists('translate')){

   
/**
 * Translates a text from one language to another using the specified API.
 *
 * @param string $text The text to be translated.
 * @return string The translated text, or "Translation not available" if the translation is not available.
 */
function translate($text){

    $source='';
    $target='';

    // Obtain Config Values
    $domain=config('translation.domain');
    $targetLocale=config('translation.default_locale');
    $defaultLocale=config('translation.default_locale');
    $fallbackLocale=config('app.fallback_locale');

    // Obtain Defaults
    $appLocale=App::getLocale();
    $sessionLocale='';

    if(Session::has('locale')){

        $sessionLocale=Session::get('locale');
        
    }else{
        Session::put('locale',$defaultLocale);
        $sessionLocale=$defaultLocale;
    }

    if($appLocale!=$defaultLocale){
        $source=$appLocale;
    }else{
        $source=$defaultLocale;
    }

    if($sessionLocale!=$source){
        
        $target=$sessionLocale;

        Log::info("Attempting to translate form $source to $target");

        try {
            //Handle Translation

            $url = "https://manifestghana.com/api/v1/translation/translate";
            
            $curl = curl_init($url);
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            
            $headers = array(
            "Content-Type: application/json",
            );
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
            
            $req = [
            "translationText"=>$text,
            "sourceLanguage"=>$from_language,
            "targetLanguage"=>$to_language,
            "projectDomain"=>$domain
            ];

            $data=json_encode($req);

            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            
            //for debug only!
            curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
            
            $resp = json_decode(curl_exec($curl));
            curl_close($curl);

            $response=htmlspecialchars_decode($resp->translated_text);
        
           

        } catch (\Throwable $th) {
            //throw $th;
            
            Log::critical('Translation Failed '.$th);

            return $text;
        }
            Log::info('Translation Successful');

        return $response;

    }else{

        Log::info("No Translation occured since $source and $target are the same.");

        return $text;

    }

    

    
}
}