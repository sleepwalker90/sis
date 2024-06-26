<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;

class LanguageController extends Controller
{
    public function switchLang($locale)
    {
        if (! in_array($locale, ['en', 'bg'])) {
            abort(400);
        }
        session()->put('locale', $locale);
        
        return redirect()->back();
    }
    
}
