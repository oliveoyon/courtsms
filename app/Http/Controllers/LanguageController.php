<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\App; // You don't strictly need App::setLocale() here, but it's harmless.

class LanguageController extends Controller
{
    // The $locale parameter will be automatically populated from the route
    public function setLocale(Request $request, $locale)
    {
        // 1. Validate or check if the locale is supported (optional but recommended)
        $supportedLocales = ['en', 'bn', 'es', 'fr']; // Add all your supported locales
        
        if (! in_array($locale, $supportedLocales)) {
            // Log an error or return an error response
            abort(400, 'Unsupported language.'); 
        }

        // 2. Store the locale in the session
        Session::put('locale', $locale);

        // 3. Set locale for the current request (optional, but good practice)
        App::setLocale($locale);

        // 4. Redirect the user back to the page they came from
        return redirect()->back(); 
    }
}