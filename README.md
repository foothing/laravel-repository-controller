# Laravel Repository Controller

Easily open an HTTP api over your Laravel database.

## Setup
Install with composer:

`composer require foothing/laravel-repository-controller`

This package will define several routes in a REST-like format
that will perform operations on your database.

Add the service provider in `config/app.php`:

```php
	"providers" => [

		Foothing\RepositoryController\RepositoryControllerServiceProvider::class,

	],
```

In order to enable the routes, you'll need to declare them in
your `routes.php`:

```php
	// ... your app routes

	RouteInstaller::install('api/v1/');
```

> Be careful and place the `RouteInstaller::install()` method at the very
> end of your `routes.php` in order to avoid conflicts.

> IMPORTANT: you will need to change the default Controllers namespace in `RouteServiceProvider` like so:
> `protected $namespace = '';`

Finally, configure your resources in the config file.

```
php artisan vendor:publish --provider="Foothing\RepositoryController\RepositoryControllerServiceProvider" --tag="config"
```

This will add the `resources.php` file in your `config` folder.

```php
'resources' => array(

	// Resources must be in the form 'resourceName' => 'resourceImplementation'
	// The implementation should be a fully qualified namespace to the model.

	'user' => 'App\User',
	'foo'  => 'My\Namespace\Foo',
),
```

This will enable the routes on the specified resources.

## How to use

The `RouteInstaller` will declare the package routes. You can specify
a prefix as an optional `install()` argument. The process will enable
the following routes, which we'll describe in better details later.

|VERB|Url|Notes|
|----|---|-----|
|GET|`[optionalPrefix]/resources/{resource}/{id?}/{args?}`|Read resources|
|POST|`[optionalPrefix]/resources/{resource}`|Create resources|
|PUT|`[optionalPrefix]/resources/{resource}/{id}`|Update resources|
|DELETE|`[optionalPrefix]/resources/{resource}/{id}`|Delete resources|
|PUT|`resources/{resource}/{id?}/link/{relation}/{related}/{relatedId}`|Attach many-to-many|
|DELETE|`resources/{resource}/{id?}/link/{relation}/{related}/{relatedId}`|Detach many-to-many|
|POST|`resources/bulk/{resource}`|Bulk create resources|
|PUT|`resources/bulk/{resource}`|Bulk update resources|

Each api endpoint will return data in `JSON` format.

### Read resources
|Verb|Url|Payload|
|----|---|-------|
|GET |`[optionalPrefix]/resources/{resource}/{id?}/{args?}`| *none*|

**Examples**

- `GET api/v1/resources/user`: will return all users
- `GET api/v1/resources/user/15`: will return user with id = 15
- `GET api/v1/resources/user/15/roles` will return user 15 roles

**Pagination**

This endpoint will handle 2 querystring args for pagination:
- page (pagination page)
- ipp (pagination items-per-page)

The result will be a Laravel paginated result like:
```json
{
	"total":4,
	"per_page":"25",
	"current_page":1,
	"last_page":1,
	"next_page_url":null,
	"prev_page_url":null,
	"from":1,
	"to":4,
	"data":[ the resources array ]
}
```

**Related resources**

You can pass an optional `with` query string argument that will be used
to fetch relations within the requested resource:

`GET api/v1/resources/user/1?with=roles,posts`

**Auto eager loading relations**

Since this package relies on [Laravel Repository](https://github.com/foothing/laravel-repository) you can take advantage
of that package *eager loading* features therefore enabling auto eager-load
features on each resource.

### Create resources
Create the requested resource.

|Verb|Url|Payload|
|----|---|-------|
|POST |`[optionalPrefix]/resources/{resource}`| {resourceData}|

**Example**

`POST api/v1/resources/user`

**POST payload**
```json
{
	name: 'foo',
	email: 'foo@bar.baz'
}
```

**HTTP Response**
```json
{
	id: 1,
	name: 'foo',
	email: 'foo@bar.baz'
}
```

### Update resources
Update the requested resource.

|Verb|Url|Payload|
|----|---|-------|
|PUT |`[optionalPrefix]/resources/{resource}/{id}`| {resourceData}|

**Example**

`PUT api/v1/resources/user/1`

**PUT payload**
```json
{
	id: 1,
	name: 'updating name',
	email: 'foo@bar.baz'
}
```

**HTTP Response**
```json
{
	id: 1,
	name: 'updating name',
	email: 'foo@bar.baz'
}
```

### Delete resources
Delete the requested resource.

|Verb|Url|Payload|
|----|---|-------|
|DELETE |`[optionalPrefix]/resources/{resource}/{id}`| *none*|

**Example**

`DELETE api/v1/resources/user/1`

### Link, bulk create and bulk update
More info coming soon.

## LICENSE
MIT
