# Thumbor PHP
PHP implementation of URL generator for [Thumbor](http://www.thumbor.org/)  

> This package has laravel support, and brings its conveniences like Facade and Service Provider.  
> At the same time, it was made to be filly functional as framework-agnostic.

Supported PHP versions: `7.4, 8.0, 8.1`  

## Installation

Require this package with composer using the following command:

```bash
composer require beeyev/thumbor-php
```

### Laravel  
This package will be automatically registered using Laravel auto-discovery mechanism.  
Publish the config file of this package with this command. It will generate config file `config/thumbor.php`, look at this file to set the required parameters.
```bash
php artisan vendor:publish --provider="Beeyev\Thumbor\Adapters\Laravel\ThumborServiceProvider" --tag=config
```

## Usage examples
### Laravel using dependency injection
```php
use Beeyev\Thumbor\Thumbor;

class SomeController extends Controller
{
    public function __invoke(Thumbor $thumbor)
    {
        $result = $thumbor->resize(200,500)->get('http://seriouscat.com/serious_cat.jpg');
        return $result;
    }
}
```

### Laravel using facade
```php
use Beeyev\Thumbor\Manipulations\Fit;
use Beeyev\Thumbor\Manipulations\Resize;
use Beeyev\Thumbor\Manipulations\Trim;

class SomeController extends Controller
{
    public function __invoke()
    {
        $result = \Thumbor::resizeWidth(Resize::ORIG)
            ->fit(Fit::FIT_IN)
            ->trim(Trim::BOTTOM_RIGHT)
            ->get('http://seriouscat.com/serious_cat.jpg');
        return $result;
    }
}
```

### Some more framework-agnostic examples
```php
use Beeyev\Thumbor\Thumbor;

class SomeClass
{
    public function SomeMethod()
    {
        $thumbor = new Thumbor('https://thumbor.findtheinvisiblecow.com/', 'secretKey555');
        $thumbor->addFilter('strip_icc');
        $thumbor->addFilter('blur', 1);
        $thumbor->resize(500, 500);
        $thumbor->smartCropEnable();
        $thumbor->imageUrl('http://seriouscat.com/serious_cat.jpg');
        return $thumbor->get();
    }
}
```

## Issues
Bug reports and feature requests can be submitted on the [Github Issue Tracker](https://github.com/beeyev/thumbor-php/issues).

## License
The MIT License (MIT). Please see [License File](https://github.com/beeyev/thumbor-php/raw/master/LICENSE.md) for more information.

---
If you love this project, please consider giving me a ⭐

![](https://visitor-badge.laobi.icu/badge?page_id=beeyev.thumbor-php)
