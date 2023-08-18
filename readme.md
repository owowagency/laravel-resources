![banner-dark](./assets/banner-dark.svg#gh-dark-mode-only)
![banner-light](./assets/banner-light.svg#gh-light-mode-only)

<br>

<p align="center">
    <img src="https://img.shields.io/packagist/v/owowagency/laravel-resources">
    <img src="https://github.com/owowagency/laravel-resources/actions/workflows/test.yml/badge.svg">
</p>


<p align="center">
    Sick and tired of having to create the same controller over and over? <br>
    Look no further! OWOW presents "Laravel Resources". <br>
    A package that makes creating API endpoints feel like breeze.
</p>

# 📖 Table of contents

1. [Installation](#%EF%B8%8F-installation)
1. [Usage](#-usage)
1. [Contributing](#-contributing)
1. [License](#-license)
1. [OWOW](#owow)

# ⚙️ Installation

```bash
composer require owowagency/laravel-resources
```

# 🛠 Usage

This package adds a few new features to the already existing `apiResource` method, `model` and `requests`.

`model` will be used to determine what model is being be handled. <br>
`requests` should contain the form requests that are used to validate incoming data during creation and updating.

## Route registration

```php
use App\Http\Requests\Posts\StoreRequest;
use App\Http\Requests\Posts\UpdateRequest;
use App\Models\Post;
use OwowAgency\LaravelResources\Controllers\ResourceController;

Route:apiResource(
    'posts',
    ResourceController::class,
    [
        'model' => Post::class,
        'requests' => [
            'store' => StoreRequest::class,
            'update' => UpdateRequest::class,
        ],
    ],
);
```

## Customizing controllers

All methods in the [`ResourceController`](https://github.com/owowagency/laravel-resources/blob/master/src/Controllers/ResourceController.php) can be overwritten. We made it a little easier by adding methods like `indexModel`, and `updateModel`. You will not have to worry about validating, authorization, or returning the models as response.

```php
use OwowAgency\LaravelResources\Controllers\ResourceController;

class PostController extends ResourceController
{
    /**
     * Returns models instances used for the index action.
     * 
     * @return mixed
     */
    public function indexModel()
    {
        return Post::where('title', 'LIKE', request('search'))->paginate();
    }

    /**
     * Updates and returns the model instance for the update action.
     * 
     * @param  \Illuminate\Http\Request  $request
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @return void
     */
    public function updateModel(Request $request, Model $model)
    {
        $model->update(['user_id' => \Auth::user()->id]);
    }
}
```

## Eloquent API resources

This package will always try to return the API resource representation of the specified model. It applies auto discovery to determine what resource to use.

By default it will use the following pattern to discover the resource class:

```
App\Http\Resources\{class_baseName($modelClass)}Resource
```

In case of a `Post` model that will become:

```
App\Http\Resources\PostResource
```

## Configuration

Configuration can be published with:

```bash
php artisan vendor:publish --tag=laravelresources
```

```php
return [

    /**
     * Is used for auto discovery of http resources. Allows for placing
     * resources under a different namespace.
     */
    'resource_namespace' => 'App\\Http\\Resources',

    /**
     * Configure resources that do not follow the default auto discovery rules.
     * 
     * Eg:
     * [Post::class => SpecialPostResource::class]
     */
    'resource_factory' => [],

];
```

# 🫶 Contributing

Please see [CONTRIBUTING](./CONTRIBUTING.md) for details.

# 📜 License

The MIT License (MIT). Please see [License File](./LICENSE) for more information.

<br>
<br>

<img id="owow" src="https://user-images.githubusercontent.com/45201651/176249441-e83226be-7281-4ddb-ad4a-9100f8862d4e.svg#gh-light-mode-only" width="150">
<img id="owow" src="https://user-images.githubusercontent.com/45201651/176249444-ceede6f9-3c2e-481d-87c3-3a72ca497e65.svg#gh-dark-mode-only" width="150">

This package has been brought to you with much love by the wizkids of [OWOW](https://owow.io/). Do you like this package? We’re still looking for new talent and Wizkids. So do you want to contribute to open source, while getting paid? [Apply now](https://owow.io/careers)
