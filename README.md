# Laravel Model Files

A package for laravel to help attaching files to models (images, pdfs, ... etc).

## Installation

Use the package manager [composer](https://getcomposer.org/) to install Laravel Model Files.

```bash
composer require akanaan/model-files
```

## Usage

The package is very easy to use, just add the trait `HasFiles` to the model and create settings array for the files

```php
<?php

namespace App\Models;

use AKanaan\ModelFiles\Traits\HasFiles;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFiles;

    protected $attaches = [
        'logo' => [
            'disk' => 'public',
            'path' => '/',
        ],
        'images' => [
            'disk' => 'public',
            'path' => 'images',
        ]
    ];
}
```

### Attach, Detach, Retrieve.

#### attaching

```php
<?php
...
$product = Product::findOrFail($id);

$product->attachFile('logo', $request->file('logo'));
$product->attachFiles('images', [
    $request->file('images.0'),
    $request->file('images.1'),
    $request->file('images.2')
    ...
]);
...
```

#### detaching

```php
<?php
...
$product = Product::findOrFail($id);

$product->detachFile('logo');
/*
 * Second param is optional (array of ids of files you want to delete)
 */
$product->detachFiles('images', [1, 2, 3]);
...
```

#### retrieving

```php
<?php
...
$product = Product::findOrFail($id);

// returns instance of AKanaan\ModelFiles\Models\File
$product->retrieveFile('logo');
// returns collection of AKanaan\ModelFiles\Models\File
$product->retrieveFiles('images');
...
```

### Public Url

```php
<?php
...
$product = Product::findOrFail($id);

$logo = $product->retrieveFile('logo');
$publicUrl = $logo->url();
...
```

## License

[MIT](https://choosealicense.com/licenses/mit/)
