.PHONY: lang-source test

lang-source:
	xgettext *.php --from-code=UTF-8 -o locale/_templates/raw.pot

test:
	vendor/bin/phpunit test --bootstrap vendor/autoload.php
