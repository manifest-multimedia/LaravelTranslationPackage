<?php 

if(!function_exists('translate')){

   
/**
 * Translates a text from one language to another using the specified API.
 *
 * @param string $text The text to be translated.
 * @return string The translated text, or "Translation not available" if the translation is not available.
 */
function translate($text){
    
    $domain=config('translation.domain');

    //   Only translate if the current locale is not the default locale

    if(session()->has('locale')){
        Log::info("Translating from " .  config('translation.default_locale') . " to " . session('locale'));
        
        $from_language=config('translation.default_locale');
        $to_language=session('locale');

    }else{
        Session()->put('locale',config('translation.default_locale'));
        $from_language = config('translation.target_locale');
        $to_language=session('locale');
    }
       
 
        if($from_language!=$to_language)
        
        {
            // dd('Not Equal '. session('locale'). ' and ' . config('translation.default_locale'));
            // dd($from_language . ' to Language ' . $to_language);

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

            return $response;

    } else{

    return $text;

    }

    
}
}