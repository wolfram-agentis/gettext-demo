# gettext-demo

## Setup
You'll need the GNU `gettext` extension installed.

```
$ brew install gettext
$ brew link gettext --force
```
Sometimes macOS is finicky with `brew link`s. You might want to do `brew install php` or `brew install php@5.6` for the time being.

Compile all the `.po` files for the first time:
> `$ make lang-compile`

Consider downloading [POEdit](https://poedit.net/). Not a requirement, but it's a nice QoL tool.

Finally, if you plan on running the PHPUnit tests, run `composer install`. Otherwise, this demo does not use Composer.

## Usage
Theoretically, you can run this demo locally if you manage to get `gettext` linked up.

```
$ php -S localhost:8001
```

Visit `localhost:8001/i18n-demo.php` to see the default output `hello world! i have 5 books`

This demo comes with two languages, Spanish (es) and French (fr). You can update your language settings in your browser to either of those two languages and refresh the demo page to see the translations.

Alternatively, you can force translation with the `?lang=` query param (e.g., `localhost:8001/i18n-demo.php?lang=fr`).

## Making Changes
Feel free to add additional translation strings in `i18n-demo.php`.

Statements without plurality can be added with `gettext(string $message)` or with the shorthand `_(string $message)`.

> `_("The cow goes Moo");`

Statements with plurality need to be added with `ngettext(string $singular, string $plural, int $number)`.

> `ngettext("The cow goes Moo", "The cows go Moo", 2);` 

Once you've made the changes, run `make lang-source` from the project root. This will create a new PO Template (.pot) file in `locale/_templates/raw.pot`. You can use POEdit to update the existing `.po` files in `es/` and `fr/`, or via the cli:

> `$ make lang-update LOC=<folder name>`

You can now head over to the updated `.po` file and fill in any blank `msgstr` strings. Compile the finished `.po` file to a binary `.mo` file. POEdit will do this automatically on saving. Otherwise, run:
 
 > `$ make lang-compile LOC=<folder name>`

The translations should appear immediately on your browser.

## Adding Languages
To add a language, run:
 
 > `$ make lang-new LOC=<language code>`
 
 with the [proper locale code](https://gist.github.com/jasef/337431c43c3addb2cbd5eb215b376179). It is suggested you use POEdit to create new `.po` files since it will set up proper meta-data for you. You can reuse the `.pot` file to template out the messages you need to translate and the rest of the steps are the same as updating an existing `.po` file.

Don't forget to add the new locale code into the `VALID_LANGUAGES` array in `locale.php`!


