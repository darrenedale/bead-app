# Bead App

This is a skeleton application using the _bead_ PHP MVC framework. Use it to kickstart your own project.

## Models

Your model classes should extend `Bead\Database\Model` and should be placed in the `app/Models` directory. To create a
basic model class for a table in your app's database, extend `Bead\Database\Model` and provide two static member
variables: `$table` should contain the name of the table in the database and `$properties` should be an array of column
names (array keys) and column types (array values) for each of the columns in the table. This is all that's needed for
a simple table's model.

## Views

A simple layout - `layouts.main` - is provided for you to customise for your app. The home page view uses this layout
for its content. Use layouts to keep pages in your app consistently structured. You can have as many layouts as you need
if different parts of your app need different page structures. You can also use views and layouts for things like email
bodies and downloads.

Views and layouts are ordinary PHP files. You should place them in the `views` directory. You can structure this
directory however you wish, placing layouts and views in subdirectories that suit your app. Views are used by providing
the view name and its data array to the `Bead\View` constructor (e.g. `new View("home", ["foo" => "bar"]))`. If you have
views in subdirectories, use dot-notation for the name of the view. For example, if you have a view named
`views/admin/edit-user.php` you would use it by calling `new View("admin.edit-user")`.

Views are isolated from the rest of the app. They only have access to the data explicitly provided to them, plus the
variable `$app`, which is the `WebApplication` instance. Views access the data provided to them either using the `$data`
variable (which is the array of data provided to the view) or by referencing the keys of the view data as variable
names. For example, if a view is used by calling `new View("home", ["foo" => "bar"])` in the view file the variable
`$foo` will have the value "bar".

## Controllers

Controllers are PHP classes. They don't need to inherit any specific class, they just need some public methods to
connect to routes. Place them in `app/Controllers`. One - `HomeController` - is provided as a simple example. The
controller methods you connect to routes should return an object that implements the `Bead\Contracts\Web\Response`
contract. All views implement this contract.

## Routes

Routes connect URLs with handlers (usually public methods in your controllers). Routes are defined in route files, which
you should place in the `routes/` directory. Route files are plain PHP files that should register route handlers with
the app's `Router`. If you're using the built-in router, this is a simple case of calling one of the register methods on
the provided `Router` instance (e.g. `$router->registerGet()`). Each route file has two variables available to it:
`$router` is the app's `Router` and `$app` is the `WebApplication` instance.

The example `routes/web.php` route file connects the `HomeController`'s `showHomePage()` method to the root URL of your
app (i.e. the home page).

Route files are isolated from the rest of the app - they do not have access to any of the app's variables, only
the `$app` and `$router` variables and PHP's superglobals. Every file inside the `routes/` directory is
automatically loaded when you call `WebApplication::exec()`.

## Config

Your app is configured by the files in the `config/` directory. Config files are plain PHP files that should each return
an array of configuration directives. Configuration is accessed via the `WebApplication::config()` method, using
dot-notation. For example, to access the application's title call `WebApplication::instance()->config("app.title")`.
This call expects the file `config/app.php` to include the key "title" in the array it returns.

You can add as many configuration files as your app's requirements dictate. You cannot, however, place config files in
subdirectories inside `config/`. All config files are loaded automatically as soon as you instantiate your
`WebApplication` object.

## Encryption

The framework has encryption services built in. There are configured in the `crypto.php` config file (see the below for
details on config files). In the default configuration the services are enabled and set up to use sodium, which means
you need to specify an encryption key for your app. It is recommended that you do this by setting the
`BEAD_APP_ENCRYPTION_KEY` environment variable in your app's `.env` file (never commit your .env file to your
repository).
