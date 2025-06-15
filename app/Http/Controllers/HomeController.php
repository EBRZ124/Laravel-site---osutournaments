<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\TranslationService;

class HomeController extends Controller
{
    public function homepage(Request $request)
    {
        $translator = new TranslationService();

        $lang = $request->input('lang', 'en');

        $translated = [];

        if ($lang !== 'en') {
            $translated = [
                'subtitle1' => $translator->translate('O!TH (osu!tournament hub) is a place to find and document osu tournaments.', $lang),
                'body1a'    => $translator->translate("Hello! You're looking at O!TH, an osu! tournament documentation site by EB124 for people of osu!game. Tournament documentation is a field in the community that has been lacking for years. Although external sites like liquipedia exist, it's much broader than what O!TH aims to be.", $lang),
                'body1b'    => $translator->translate("You can sign up and comment under documented tournaments here. Trusted members can apply for 'verified' user status, which will allow you to not just view and comment under posts, but also make ones yourself. If you want to join the team, feel free to shoot an application to my contacts.", $lang),
                'body2'     => $translator->translate("For over half a decade, the United States team had dominated the biggest international stage. However, the beasts that are South Korean decided to put a stop to the unbeatable and probably unrepeatable streak.", $lang),
            ];
        }

        return view('pages.homepage', compact('translated', 'lang'));
    }
}
