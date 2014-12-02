Yii 2 Errbit error handler
==========================
Logs errors to [errbit](https://github.com/errbit/errbit)

Installation
------------

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
php composer.phar require --prefer-dist nkovacs/yii2-errbit "*"
```

or add

```
"nkovacs/yii2-errbit": "*"
```

to the require section of your `composer.json` file.


Usage
-----

Replace the default error handler with either `\nkovacs\errbit\WebErrorHandler` or `\nkovacs\errbit\ConsoleErrorHandler`:

```php
...
    'components' => [
        'errorHandler' => [
            'class' => 'nkovacs\errbit\ConsoleErrorHandler',
            'errbit' => [
                'api_key' => 'your api key',
                'host' => 'errbit.example.org',
            ],
        ],
    ],
...
```

or

```php
...
    'components' => [
        'errorHandler' => [
            'class' => 'nkovacs\errbit\ConsoleErrorHandler',
            'errbit' => [
                'api_key' => 'your api key',
                'host' => 'errbit.example.org',
            ],
        ],
    ],
...
```

You can pass additional options to errbitPHP:

```php
...
    'components' => [
        'errorHandler' => [
            'class' => 'nkovacs\errbit\ConsoleErrorHandler',
            `errbit` => [
                'api_key' => 'your api key',
                'host' => 'errbit.example.org',
                'environment_name' => 'development',
            ]
        ],
    ],
...
```

