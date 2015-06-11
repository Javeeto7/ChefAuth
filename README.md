# Chef Authorization
##Recipes, Ingredients and Category Login "Chef-Captcha" for Laravel 5

Powerful package to implement a simple but effective login authorization step. Replace the
normal Word Captcha system with this package. It will provide a very
dynamic and interactive way for users to login with additional security.


## Install

Install this package in through Composer.

```js
{
    "require": {
        "reivaj86/chef-auth": "dev-master"
    }
}
```
    Run

    $ composer update


Add the package ChefAuthServiceProvider to your application service providers in `config/app.php`

```php
'providers' => [
    
    'Illuminate\Foundation\Providers\ArtisanServiceProvider',
    'Illuminate\Auth\AuthServiceProvider',
    ...
    
    'Reivaj86\ChefAuth\ChefAuthServiceProvider',

],
```

Publish the package migrations and config file to your application.

    $ php artisan vendor:publish --provider="Vendor/Reivaj86/ChefAuth/ChefAuthServiceProvider" --tag="config"
    $ php artisan vendor:publish --provider="Vendor/Reivaj86/ChefAuth/ChefAuthServiceProvider" --tag="migrations"

Run migrations.

    $ php artisan migrate

### Configuration file --- chef-auth.php

You can change connection for models, slug separator and there is also a handy cookable feature. Study the config file for more information.

## Usage

First of all, include `HasIngredient` trait and also implement `HasIngredientContract` inside your `User` model.

```php
use Reivaj86\ChefAuth\Contracts\HasIngredientContract;
use Reivaj86\ChefAuthTraits\HasIngredient;

class Recipe extends Model implements HasIngredientContract {

	use HasIngredient;
```

You're set to go. You can create your first recipe, ingredient and category database.

 ```php
 use Reivaj86\ChefAuth\Models\Recipe;

 $recipe = Recipe::create([
     'name' => 'Carbonara',
     'slug' => 'carbonara',
     'img'  => 'assets/imgs/carbonara.png'
     'description' => 'Delicious italian pasta dish' // optional
 ]);

 ```

 You then can create your first ingredient and attach it to a recipe.

```php
use Reivaj86\ChefAuth\Models\Ingredient;
use Reivaj86\ChefAuth\Models\Recipe;

$ingredient = Ingredient::create([
    'name' => 'Eggs',
    'slug' => 'eggs',
    'description' => '' // optional
]);

$recipe = Recipe::find($id)->attachIngredient($ingredient); // Can pass whole object, or only its id
```

You can check if the current recipe has required ingredient.

```php
if ($recipe->cooks('eggs')) // you can pass an id or slug
{
    return 'eggs'; // Or an image (return recipe->img;)

}
```

You can also do this:

```php
if ($recipe->cooksEggs())
{
    return 'eggs';
}

```

And of course, there is a way to check for multiple ingredients:

```php
if ($recipe->cooks('eggs|cheese')) // or $recipe->cooks('eggs, cheese') and also $recipe->cooks(['eggs', 'cheese'])
{
    // if recipe has at least one ingredient
}

if ($recipe->cooks('eggs|cheese', 'All')) // or $user->cooks('eggs, cheese', 'All') and also $recipe->cooks(['eggs', 'cheese'], 'All')
{
    // if recipe has all ingredients
}
```

When you are creating ingredients, there is also optional parameter `img`. It is set to `null` by default, but you can overwrite it and then you can do something like this:
 
```php
if (!$ingredient->img = null)
{
    // code
}
```

Let's talk about categories in general. You can attach a category to an ingredient or directly to a specific ingredient (and of course detach them as well).

```php
use Reivaj86\ChefAuth\Models\Category;
use Reivaj86\ChefAuth\Models\Ingredient;

$category = Category::create([
    'name' => 'Dairy',
    'slug' => 'dairy',
    'description' => 'Dairy products' // optional
]);

Ingredient::find($id)->attachCategory($category);


if ($ingredient->is('dairy') // you can pass an id or slug
{
    return 'Is a Dairy Product!';
}

```

You can check for multiple categories the same way as ingredients.


This condition checks if the current recipe is the owner of provided ingredient. If not, it will be looking inside ingredient categories for a row we created before.

```php
if ($ingredient->steamed('dairy', $product, false)) // now owner check is disabled
{
    $product->save();
}
```


