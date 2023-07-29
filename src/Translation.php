<?php

namespace Manifesthq\Translation;

use Illuminate\Support\Facades\Log;

class Translation
{
    // Build your next great package.
   
        /**
         * Translates a text from one language to another using the specified API.
         *
         * @param string $text The text to be translated.
         * @return string The translated text, or "Translation not available" if the translation is not available.
         */
        public function translate($text){
            
            $domain="manifestghana.com";
    
            //   Only translate if the current locale is not the default locale
           
            
            if(session('locale')!=config('app.fallback_locale')){
    
                Log::info("Translating from " . session('locale') . " to " . config('app.fallback_locale'));
                $from_language =config('app.fallback_locale');
                $to_language=session('locale');
               
    
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
    
                
    
            } catch (\Throwable $th) {
                //throw $th;
    
                dd($th);
    
                return trans("Api Not Available");
            }
    
            
            return htmlspecialchars_decode($resp->translated_text) ?? "Translation not available";
    
        } else{
    
            return $text;
    
        }
    
            
        }
    
    

}
