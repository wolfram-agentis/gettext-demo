<?php

require_once dirname(__DIR__) . '/locale.php';

use PHPUnit\Framework\TestCase;

final class LocaleTest extends TestCase
{
    /**
     * @dataProvider acceptLanguageProvider
     */
    public function testParseHttpAcceptLanguage($sample, $expected) {
        $this->assertSame($expected, parseHttpAcceptLanguage($sample));
    }

    public function acceptLanguageProvider() {
        return [
            ['en-US,fr-FR;q=0.8', ['en-US', 'fr-FR']],
            ['nl-NL;q=0.3,es;q=0.8', ['es', 'nl-NL']]
        ];
    }

    /**
     * @dataProvider setSessionProvider
     */
    public function testSetSessionLanguage($setup, $expected) {
        $setup();
        $language = getLanguage(['de', 'en', 'en-US', 'es']);
        $this->assertSame($expected, $language);
    }

    public function setSessionProvider() {
        return [
            'basic' => [function () {
                $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'en-US,en;q=0.9,es;q=0.8';
            }, 'en-US'],
            'lang-param-valid' => [function () {
                $_GET['lang'] = 'es';
                $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'whatever';
            }, 'es'],
            'lang-param-invalid' => [function () {
                $_GET['lang'] = 'nl';
                $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'de;q=0.9,es;q=0.8';
            }, 'de'],
            'default' => [function () {
                $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'pt-BR';
            }, 'en-US']
        ];
    }
}
