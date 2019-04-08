.PHONY: lang-source lang-update test

lang-source:
	xgettext *.php --from-code=UTF-8 -o locale/_templates/raw.pot

lang-update:
	msgmerge -U locale/$(LOC)/LC_MESSAGES/messages.po locale/_templates/raw.pot

lang-compile:
	msgfmt locale/$(LOC)/LC_MESSAGES/messages.po -o locale/$(LOC)/LC_MESSAGES/messages.mo

lang-new:
	mkdir -p locale/$(LOC)/LC_MESSAGES

test:
	vendor/bin/phpunit test --bootstrap vendor/autoload.php
