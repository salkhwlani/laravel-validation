# PHP Laravel Validation.

[![Software License][ico-license]](LICENSE.md)
[![Build Status][ico-build]][link-build]
[![Quality Score][ico-code-quality]][link-code-quality]

> A tiny package to use laravel validation outside laravel with support translate error message. this package is extend for [rakit/validation](https://github.com/rakit/validation) so read it's document for more information.

## Features

- Init validation easy with trait.
- Support Multi lang for error messages.
- More come soon.

## Requirements & Installation

> Requires PHP 7.0+

Via Composer

``` bash
$ composer require yemenifree/laravel-validation
```

## Getting Started

To init validation on class add `HasValidator` trait.

```php
use Yemenifree\Validation\Traits\HasValidator;

class SomeController
{
    use HasValidator;
    //
}
```

Then to valid some data you can pass array for data & rules and others options.
 

```php
    $this->valid(array $data, array $rules, array $messages = [], array $aliases = [])
```

For example

```php
    /**
     * Register User
     *
     * @return array
     */
    public function register()
    {
        $isValid = $this->valid(
        [
            'username' => 'salah',
            'password' => 'test'
        ]
        , [
            'username' => 'required',
            'password' => 'required',
        ]);
        
        if(!$isValid){
            // data not valid.
        }

        // every thing right.
    }
```

If you have same response for all form in controller you can handler validation error once by create `InValidCallback` in class.

```php
use Yemenifree\Validation\Traits\HasValidator;

class SomeController
{
    use HasValidator;
    
    /**
     * Register User
     *
     * @return array
     */
    public function register()
    {
        $isValid = $this->valid(
        [
            'username' => 'salah',
            'password' => 'test'
        ]
        , [
            'username' => 'required',
            'password' => 'required',
        ]);
        
        // if data not valid will excute `InValidCallback` in this class.
        if(!$isValid)
        {
            return;
        }
        
        // every thing right.
    }
    
    /**
     * In valid function.
     *
     * @param array $errors
     *
     * @throws InvalidArgumentException
     */
    public function InValidCallback(array $errors)
    {
        // do whatevet you want with errors.
        
        return false;
    }
}
```

You can use custom translate file for validation errors.

```php
    use Yemenifree\Validation\Traits\HasValidator;
    
    class SomeController
    {
        use HasValidator;
        
        public function __construct()
        {
            $this->setValidatorLocal(
            // file name wihout .php
            'ar',
            // path of translate
            'translate/path'
            );
        }
        
        /**
         * Register User
         *
         * @return array
         */
        public function register()
        {
            $isValid = $this->valid(
            [
                'username' => 'salah',
                'password' => 'test'
            ]
            , [
                'username' => 'required',
                'password' => 'required',
            ]);
            
            if(!$isValid)
            {
                // message errors.
                $errors = $this->getValidErrors();
            }
            
            // every thing right.
        }
    }
```

> translate files must return array of messages. see `src/lang/ar.php` for example.

To access to all method of `Validator` use `getValidator()` method.


```php
use Yemenifree\Validation\Traits\HasValidator;

class SomeController
{
    use HasValidator;

    public function __construct()
    {
        // add custom rule.
        $this->getValidator()->addValidator('simple', new SimpleRule());
    }
}
```

> For more information about rules check [rakit/validation](https://github.com/rakit/validation)

## Change log

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security

If you discover any security related issues, please email yemenifree@yandex.com instead of using the issue tracker.

## Credits

- [Rakit/validation](https://github.com/rakit/validation)
- [Salah Alkhwlani][link-author]
- [All Contributors][link-contributors]

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.

[ico-license]: https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square
[ico-code-quality]: https://scrutinizer-ci.com/g/yemenifree/wp-security/badges/quality-score.png?b=master
[ico-build]: https://scrutinizer-ci.com/g/yemenifree/wp-security/badges/build.png?b=master

[link-author]: https://github.com/yemenifree
[link-contributors]: ../../contributors
[link-code-quality]: https://scrutinizer-ci.com/g/yemenifree/wp-security/code-structure
[link-build]: https://scrutinizer-ci.com/g/yemenifree/wp-security/build-status/maste
[link-last-version]: https://api.github.com/repos/yemenifree/wp-security/zipball

