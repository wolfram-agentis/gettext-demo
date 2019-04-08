<?php

session_start();

const VALID_LANGUAGES = ['en', 'en-US', 'es', 'fr'];

// determine preferred language
$language = getLanguage(VALID_LANGUAGES);

// set env; gettext() uses this to determine file lookup
putenv('LANG=' . $language);

// set settings for things like currency, sorting, and time formatting
setlocale(LC_ALL, $language);

// let PHP know where to find the translation files
$pathToLocale = 'locale';
// $domain should match the file names of the translation files
bindtextdomain('messages', $pathToLocale);
// by default, codeset is ASCII; UTF-8 is better suited for foreign characters
bind_textdomain_codeset('messages', 'UTF-8');

// set default $domain used when we call gettext()
textdomain('messages');

/**
 * @param array $validLanguages - allowable languages
 *
 * @return string
 */
function getLanguage($validLanguages) {
    // allow hard overwrite via ?lang=x param
    if (isset($_GET['lang']) && in_array($_GET['lang'], $validLanguages)) {
        return $_GET['lang'];
    } elseif (!isset($_SESSION['lang'])) {
        $acceptedLanguages = parseHttpAcceptLanguage();

        for ($i = 0; $i < count($acceptedLanguages); $i++) {
            if (in_array($acceptedLanguages[$i], $validLanguages)) {
                // exit on first match
                return $acceptedLanguages[$i];
            }
        }
    }
    // if nothing was set, default to en-US
    return 'en-US';
}

/**
 * @param string $acceptLanguageString - (optional), default = $_SERVER['HTTP_ACCEPT_LANGUAGE']
 *
 * @return array - accepted languages sorted in descending order by weight
 */
function parseHttpAcceptLanguage($acceptLanguageString = '') {
    // e.g., en-US,en;q=0.9,fr-FR;q=0.8,fr;q=0.7
    $acceptLanguageString = $acceptLanguageString ?: $_SERVER['HTTP_ACCEPT_LANGUAGE'];

    $acceptedLanguages = array_reduce(
        explode(',', $acceptLanguageString),
        function ($result, $el) {
            // we're going to append 1 to the array so that default languages "en-US" have a weight attributed to it
            list($l, $q) = array_merge(explode(';q=', $el), [1]);
            $result[$l] = (float) $q;
            return $result;
        }, []);

    // safety sort, theoretically not needed since most browsers return HTTP_ACCEPT_LANGUAGE pre-sorted
    arsort($acceptedLanguages);

    return array_keys($acceptedLanguages);
}
