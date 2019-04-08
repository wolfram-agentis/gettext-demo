<?php

require_once 'locale.php';

echo _('Hello World!');

echo sprintf(ngettext('I have %d book.', 'I have %d books.', 5), 5);

session_destroy();
