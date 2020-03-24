# Leaditin\Code

Provides an API to generate arbitrary code.

[![Build Status][ico-build]][link-build]
[![Code Quality][ico-code-quality]][link-code-quality]
[![Code Coverage][ico-code-coverage]][link-code-coverage]
[![Latest Version][ico-version]][link-packagist]
[![PDS Skeleton][ico-pds]][link-pds]

## Installation

The preferred method of installation is via [Composer](http://getcomposer.org/). Run the following command to install the latest version of a package and add it to your project's `composer.json`:

```bash
composer require leaditin/code
```

## Usage

#### 1. Create Class
 
```php
<?php

use Leaditin\Code\DocBlock;
use Leaditin\Code\Flag;
use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Member\Constant;
use Leaditin\Code\Member\Method;
use Leaditin\Code\Member\Property;
use Leaditin\Code\Tag;
use Leaditin\Code\Type;
use Leaditin\Code\Value;
use Leaditin\Code\Visibility;

$generator = (new Factory())->classGenerator();
$generator
    ->setName('MyClass')
    ->setNamespace('My\Dummy\Namespace')
    ->setExtends('My\Dummy\Class')
    ->implementInterface('My\Dummy\Interface')
    ->useTrait('My\Dummy\Trait')
    ->setDocBlock(
        new DocBlock(
            'Short description',
            'Long description',
            [
                new Tag('author', 'author@domain')
            ]
        )
    )
    ->addConstant(new Constant('CONST_A', 2, new Visibility(Visibility::VISIBILITY_PUBLIC)))
    ->addConstant(new Constant('CONST_B', 3, new Visibility(Visibility::VISIBILITY_PUBLIC)))
    ->addProperty(new Property('name', new Value('Some User'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PROTECTED)))
    ->addProperty(new Property('email', new Value('author@domain'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PROTECTED)))
    ->addMethod(new Method('name', new Flag(Flag::FLAG_PUBLIC), null, 'return $this->name;', null, new Type(Type::TYPE_STRING)))
    ->addMethod(new Method('email', new Flag(Flag::FLAG_PUBLIC), null, 'return $this->email;', null, new Type(Type::TYPE_STRING)));

echo $generator->generate();
```

Will output:

```php
<?php

namespace My\Dummy\Namespace;

/**
 * Short description
 *
 * Long description
 *
 * @author author@domain
 */
class MyClass extends \My\Dummy\Class implements \My\Dummy\Interface
{
    use \My\Dummy\Trait;

    public const CONST_A = 2;
    public const CONST_B = 3;

    /**
     * @var string
     */
    protected $name = 'Some User';

    /**
     * @var string
     */
    protected $email = 'author@domain';

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }
}
```

#### 2. Create Interface

```php
<?php

use Leaditin\Code\DocBlock;
use Leaditin\Code\Flag;
use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Member\Constant;
use Leaditin\Code\Member\Method;
use Leaditin\Code\Type;
use Leaditin\Code\Visibility;

$generator = (new Factory())->interfaceGenerator();
$generator
    ->setName('MyInterface')
    ->setNamespace('My\Dummy\Namespace')
    ->setExtends('My\Dummy\Interface')
    ->setDocBlock(
        new DocBlock(
            'Short description',
            'Long description'
        )
    )
    ->addConstant(new Constant('CONST_A', 2, new Visibility(Visibility::VISIBILITY_PUBLIC)))
    ->addConstant(new Constant('CONST_B', 3, new Visibility(Visibility::VISIBILITY_PUBLIC)))
    ->addMethod(new Method('name', new Flag(Flag::FLAG_PUBLIC), null, null, null, new Type(Type::TYPE_STRING)))
    ->addMethod(new Method('email', new Flag(Flag::FLAG_PUBLIC), null, null, null, new Type(Type::TYPE_STRING)));

echo $generator->generate();

```

Will output...

```php
<?php

namespace My\Dummy\Namespace;

/**
 * Short description
 *
 * Long description
 */
interface MyInterface extends \My\Dummy\Interface
{
    public const CONST_A = 2;
    public const CONST_B = 3;

    /**
     * @return string
     */
    public function name(): string;

    /**
     * @return string
     */
    public function email(): string;
}
```

#### 3. Create Trait

```php
<?php

use Leaditin\Code\DocBlock;
use Leaditin\Code\Flag;
use Leaditin\Code\Generator\Factory;
use Leaditin\Code\Member\Method;
use Leaditin\Code\Member\Property;
use Leaditin\Code\Type;
use Leaditin\Code\Value;

$generator = (new Factory())->traitGenerator();
$generator
    ->setName('MyTrait')
    ->setDocBlock(
        new DocBlock(
            'Short description',
            'Long description'
        )
    )
    ->addProperty(new Property('name', new Value('Some User'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PROTECTED)))
    ->addProperty(new Property('email', new Value('author@domain'), new Type(Type::TYPE_STRING), new Flag(Flag::FLAG_PROTECTED)))
    ->addMethod(new Method('name', new Flag(Flag::FLAG_PUBLIC), null, 'return $this->name;', null, new Type(Type::TYPE_STRING)))
    ->addMethod(new Method('email', new Flag(Flag::FLAG_PUBLIC), null, 'return $this->email;', null, new Type(Type::TYPE_STRING)));

echo $generator->generate();
```

Will output...

```php
<?php

/**
 * Short description
 *
 * Long description
 */
trait MyTrait
{
    /**
     * @var string
     */
    protected $name = 'Some User';

    /**
     * @var string
     */
    protected $email = 'author@domain';

    /**
     * @return string
     */
    public function name(): string
    {
        return $this->name;
    }

    /**
     * @return string
     */
    public function email(): string
    {
        return $this->email;
    }
}
```

## Credits

- [All Contributors][link-contributors]

## License

Released under MIT License - see the [License File](LICENSE) for details.


[ico-version]: https://img.shields.io/packagist/v/leaditin/code.svg
[ico-build]: https://travis-ci.org/leaditin/code.svg?branch=master
[ico-code-coverage]: https://img.shields.io/scrutinizer/coverage/g/leaditin/code.svg
[ico-code-quality]: https://img.shields.io/scrutinizer/g/leaditin/code.svg
[ico-pds]: https://img.shields.io/badge/pds-skeleton-blue.svg

[link-packagist]: https://packagist.org/packages/leaditin/code
[link-build]: https://travis-ci.org/leaditin/code
[link-code-coverage]: https://scrutinizer-ci.com/g/leaditin/code/code-structure
[link-code-quality]: https://scrutinizer-ci.com/g/leaditin/code
[link-pds]: https://github.com/php-pds/skeleton
[link-contributors]: ../../contributors