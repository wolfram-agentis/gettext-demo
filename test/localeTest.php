<?php

require_once dirname(__DIR__) . '/locale.php';

use PHPUnit\Framework\TestCase;

final class LocaleTest extends TestCase
{
    /**
     * @dataProvider setSessionProvider
     */
    public function testSetSessionLanguage($setup, $expected) {
        $setup();
        $language = getLanguage([
            'de' => 'de_DE',
            'en' => 'en_US',
            'en-US' => 'en_US',
            'es' => 'es_ES',
        ]);
        $this->assertSame($expected, $language);
    }

    public function setSessionProvider() {
        return [
            'basic' => [function () {
                $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'en-US,en;q=0.9,es;q=0.8';
            }, 'en_US'],
            'lang-param-valid' => [function () {
                $_GET['lang'] = 'es';
                $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'whatever';
            }, 'es_ES'],
            'lang-param-invalid' => [function () {
                $_GET['lang'] = 'nl';
                $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'de;q=0.9,es;q=0.8';
            }, 'de_DE'],
            'default' => [function () {
                $_SERVER['HTTP_ACCEPT_LANGUAGE'] = 'pt-BR';
            }, 'en_US']
        ];
    }
}
