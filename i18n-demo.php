<?php

require_once 'locale.php';

echo _('demo.greeting') . '!' . PHP_EOL;

echo sprintf(ngettext('demo.books.single', 'demo.books.plural.%d', 5), 5);

session_destroy();
