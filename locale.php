<?php

require __DIR__ . '/vendor/autoload.php';

const SUPPORTED_LANGUAGES = [
    'en' => 'en_US',
    'en-US' => 'en_US',
    'es' => 'es_ES',
    'fr' => 'fr_FR',
];

session_start();

// determine preferred language
$language = getLanguage(SUPPORTED_LANGUAGES);

// set environment variable and session for rest of application
putenv('LANG=' . $language);

// set settings for things like currency, sorting, and time formatting
setlocale(LC_MESSAGES, $language);

// let PHP know where to find the translation files
$pathToLocale = __DIR__ . '/locale';
// $domain should match the file names of the translation files
bindtextdomain('messages', $pathToLocale);
// by default, codeset is ASCII; UTF-8 is better suited for foreign characters
bind_textdomain_codeset('messages', 'UTF-8');

// set default $domain used when we call gettext()
textdomain('messages');

/**
 * @param array $supportedLanguages - allowable languages
 *
 * @return string
 */
function getLanguage($supportedLanguages) {
    // allow hard overwrite via ?lang=x param
    if (isset($_GET['lang']) && array_key_exists($_GET['lang'], $supportedLanguages)) {
        return $supportedLanguages[$_GET['lang']];
    } else {
        $http = new HTTP2();
        $lang = $supportedLanguages[$http->negotiateLanguage($supportedLanguages)];
        return $lang;
    }
}
