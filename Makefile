.PHONY: lang-source lang-update lang-compile test

lang-source:
	xgettext *.php --from-code=UTF-8 -o locale_templates/raw.pot

lang-update:
	msgmerge -U locale/$(LOC)/LC_MESSAGES/messages.po locale/_templates/raw.pot

lang-compile:
ifdef LOC
	msgfmt locale/$(LOC)/LC_MESSAGES/messages.po -o locale/$(LOC)/LC_MESSAGES/messages.mo
else
	find . -name \*.po -execdir msgfmt messages.po -o messages.mo \;
endif

lang-new:
	mkdir -p locale/$(LOC)/LC_MESSAGES

test:
	vendor/bin/phpunit test --bootstrap vendor/autoload.php
