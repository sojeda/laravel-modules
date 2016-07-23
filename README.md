# Laravel-Modules

[![Latest Version on Packagist](https://img.shields.io/packagist/v/nwidart/laravel-modules.svg?style=flat-square)](https://packagist.org/packages/nwidart/laravel-modules)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/nWidart/laravel-modules/master.svg?style=flat-square)](https://travis-ci.org/nWidart/laravel-modules)
[![Scrutinizer Coverage](https://img.shields.io/scrutinizer/coverage/g/nWidart/laravel-modules.svg?maxAge=2592000&style=flat-square)](https://scrutinizer-ci.com/g/nWidart/laravel-modules/?branch=master)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/25320a08-8af4-475e-a23e-3321f55bf8d2.svg?style=flat-square)](https://insight.sensiolabs.com/projects/25320a08-8af4-475e-a23e-3321f55bf8d2)
[![Quality Score](https://img.shields.io/scrutinizer/g/nWidart/laravel-modules.svg?style=flat-square)](https://scrutinizer-ci.com/g/nWidart/laravel-modules)
[![Total Downloads](https://img.shields.io/packagist/dt/nwidart/laravel-modules.svg?style=flat-square)](https://packagist.org/packages/nwidart/laravel-modules)


- [Upgrade Guide](#upgrade-guide)
- [Installation](#installation)
- [Configuration](#configuration)
- [Naming Convension](#naming-convension)
- [Folder Structure](#folder-structure)
- [Creating Module](#creating-a-module)
- [Artisan Commands](#artisan-commands)
- [Facades](#facades)
- [Entity](#entity)
- [Auto Scan Vendor Directory](#auto-scan-vendor-directory)
- [Publishing Modules](#publishing-modules)

`nwidart/laravel-modules` is a laravel package which created to manage your large laravel app using modules. Module is like a laravel package, it has some views, controllers or models. This package is supported and tested in Laravel 5.

This package is a re-published, re-organised and maintained version of [pingpong/modules](https://github.com/pingpong-labs/modules), which isn't maintained anymore. This package is used in [AsgardCMS](https://asgardcms.com/).

With one big added bonus that the original package didn't have: tests.

<a name="upgrade-guide"></a>
## Upgrade Guide

<a name="installation"></a>
## Instalacion

### Rapida

Para instalar a tráves de composer, solo debes ejecutar el siguiente comando

``` bash
composer require nwidart/laravel-modules
```

#### Agregar Service Provider

Agrega el siguiente provider dentro del archivo `config/app.php`.

```php
'providers' => [
  Nwidart\Modules\LaravelModulesServiceProvider::class,
],
```

Luego, agrega el siguiente alias dentro del array 'aliases` del mismo archivo.

```php
'aliases' => [
  'Module' => Nwidart\Modules\Facades\Module::class,
],
```

Por ultimo, debes publicar el archivo de configuracion ejecutando el siguiente comando.

```
php artisan vendor:publish --provider="Nwidart\Modules\LaravelModulesServiceProvider"
```

#### Autoloading

Por defecto los controladores, entidades o repositorios no son cargados automaticamente. Puedes cargarlos usando la convencion `psr-4`. Por ejemplo:

```json
{
  "autoload": {
    "psr-4": {
      "App\\": "app/",
      "Modules\\": "modules/"
    }
  }
}
```

<a name="configuration"></a>
## Configuración

- `modules` - Se utiliza para guardar los módulos generados.
- `assets` - Se utiliza para guardar los assets de cada uno de los módulos.
- `migration` - Se utiliza para guardar las migraciones de los módulos si publica las migraciones.
- `generator` - Se utiliza para generar las carpetas de los módulos.
- `scan` - Se utiliza para permitir escanear otras carpetas.
- `enabled` - Si esta en `true`, el paquete escaneara otras carpetas. Por defecto este valor esta en `false`
- `paths` - La lista de los path que puede escanear automáticamente el paquete. composer
- `composer`
- `vendor` - Composer vendor name.
- `author.name` - Composer author name.
- `author.email` - Composer author email.
- `cache`
- `enabled` - Si es `true`, the scanned modules (todos los modulos) seran cacheados automaticamente. Por defecto este valor esta enabled `false`
- `key` - El nombre del cache.
- `lifetime` - Tiempod expiracion del cache.

<a name="creating-a-module"></a>
## Creando un Módulo

Para crear un nuevo módulo simplemente ejecuta:

```
php artisan module:make <module-name>
```

- `<module-name>` - Requerido. El nombre del paquete creado.

**Creando un nuevo Módulo**

```
php artisan module:make Blog
```

**Creando Multiples Módulos**

```
php artisan module:make Blog User Auth
```

Por defecto al crear un nuevo módulo, este agregare unos recursos por defecto como lo son un controlador, un seed y un provider automaticamente. Si no lo deseas puedes agregar en el comando un flag `--plain` para generar un modulo plano.

```shell
php artisan module:make Blog --plain
#OR
php artisan module:make Blog -p
```

<a name="naming-convension"></a>
**Naming Convension**

Ya que el autoloading de los modulos se hacen con `psr-4`, se debe usar la convencion de nombres `StudlyCase`.

<a name="folder-structure"></a>
**Estructura de Carpetas**

```
laravel-app/
app/
bootstrap/
vendor/
modules/
  ├── Blog/
      ├── Assets/
      ├── Config/
      ├── Console/
      ├── Database/
          ├── Migrations/
          ├── Seeders/
      ├── Entities/
      ├── Http/
          ├── Controllers/
          ├── Middleware/
          ├── Requests/
          ├── routes.php
      ├── Providers/
          ├── BlogServiceProvider.php
      ├── Resources/
          ├── lang/
          ├── views/
      ├── Repositories/
      ├── Tests/
      ├── composer.json
      ├── module.json
      ├── start.php
```

<a name="artisan-commands"></a>
## Comandos de Artisan

Crear un nuevo Módulo.

```
php artisan module:make blog
```

Usar un Módulo espesifico.

```php
php artisan module:use blog
```

Mostras todos los Módulos en la consola.

```
php artisan module:list
```

Crear un nuevo comando por un módulo en espesifico.

```
php artisan module:make-command CustomCommand blog

php artisan module:make-command CustomCommand --command=custom:command blog

php artisan module:make-command CustomCommand --namespace=Modules\Blog\Commands blog
```

Crear un archivo de migracion para un Módulo.

```
php artisan module:make-migration create_users_table blog

php artisan module:make-migration create_users_table --fields="username:string, password:string" blog

php artisan module:make-migration add_email_to_users_table --fields="email:string:unique" blog

php artisan module:make-migration remove_email_from_users_table --fields="email:string:unique" blog

php artisan module:make-migration drop_users_table blog
```

Migraciones de los Móudlos - Rollback, Reset y Refresh 

```
php artisan module:migrate-rollback

php artisan module:migrate-reset

php artisan module:migrate-refresh
```

Migracion de un solo Módulo - Rollback, Reset y Refresh .

```
php artisan module:migrate-rollback blog

php artisan module:migrate-reset blog

php artisan module:migrate-refresh blog
```

Crear un Seeder para un solo Módulo.

```
php artisan module:make-seed users blog
```

Migracion de un solo Módulo.

```
php artisan module:migrate blog
```

Migración de todos los Módulos.

```
php artisan module:migrate
```

Seeder de un solo Módulo.

```
php artisan module:seed blog
```

Seed de todos los Módulos.

```
php artisan module:seed
```

Creacion de un Controlador para un Módulo espesifico.

```
php artisan module:make-controller SiteController blog
```

Publicar assets de un módulo en el directorio public.

```
php artisan module:publish blog
```

Publicar assets de todos los módulos en el directorio public.

```
php artisan module:publish
```

Crear un Model dentro de un Módulo

```
php artisan module:make-model User blog

php artisan module:make-model User blog --fillable="username,email,password"
```

Crear un Service Provider dentro de un Módulo

```
php artisan module:make-provider MyServiceProvider blog
```

Publicar migraciones de un todos los módulos o de uno solo.

Es muy util cuando se requiere hacer un rollback de todas las migraciones. Asi se puede ejecutar `php artisan migrate` en vez de `php artisan module:migrate` para migrar, valga la redundancia, todas las migraciones.

Para un módulo espesifico.

```
php artisan module:publish-migration blog
```

Para todas las migraciones.

```
php artisan module:publish-migration
```

Publicar archivos de configuracion de un Módulo.

```
php artisan module:publish-config <module-name>
```

- (opcional) `module-name`: El nombre del módulo. Si lo deja en blanco va a publicar los archivos de todos los módulos.
- (opcional) `--force`: Para forzar la publicación, y sobrescribir los archivos ya publicados.

Habilitar un módulo.


```
php artisan module:enable blog
```

Desactivar  un módulo.

```
php artisan module:disable blog
```

Generar una clase middleware

```
php artisan module:make-middleware Auth
```

Actualizar dependencias de un módulo.

```
php artisan module:update ModuleName
```

Actualizar dependencias de todos los módulos.

```
php artisan module:update
```

Muestra en consola todos los módulos.

```
php artisan module:list
```

<a name="facades"></a>
## Facades

Obtener todos los módulos.

```php
Module::all();
```

Obtener todos los módulos en caché..

```php
Module::getCached()
```

Obtener módulos ordenados. Los módulos serán ordenados por la key `priority` en el archivo `module.json`.

```php
Module::getOrdered();
```

Get scanned modules.

```php
Module::scan();
```

Buscar un Módulo.

```php
Module::find('name');
// OR
Module::get('name');
```

Busca un Módulo, si hay uni, retorna una instancia de `Module`, de lo contrario arroja un  `Nwidart\Modules\Exeptions\ModuleNotFoundException`.

```php
Module::findOrFail('module-name');
```

Obtener los paths escaneados

```php
Module::getScanPaths();
```

Obtener todos los módulos como una coleccion.

```php
Module::toCollection();
```

Obtener los Módulos por status, 1 para activos y 0 para inactivos.

```php
Module::getByStatus(1);
```

Verifica un Módulo. Si existe  retorna `true`, de lo contrario manda un `false`.

```php
Module::has('blog');
```

Obtener Módulos Activados

```php
Module::enabled();
```

Obtener Módulos Desactivados.

```php
Module::disabled();
```

Obtener la cantidad de Módulos

```php
Module::count();
```

Obtener module path.

```php
Module::getPath();
```

Registrar los Módulos

```php
Module::register();
```

Boot all available modules.

```php
Module::boot();
```

Get all enabled modules as collection instance.

```php
Module::collections();
```

Get module path from the specified module.

```php
Module::getModulePath('name');
```

Get assets path from the specified module.

```php
Module::getAssetPath('name');
```

Get config value from this package.

```php
Module::config('composer.vendor');
```

Get used storage path.

```php
Module::getUsedStoragePath();
```

Get used module for cli session.

```php
Module::getUsedNow();
// OR
Module::getUsed();
```

Set used module for cli session.

```php
Module::setUsed('name');
```

Get modules's assets path.

```php
Module::getAssetsPath();
```

Get asset url from specific module.

```php
Module::asset('blog:img/logo.img');
```

Install the specified module by given module name.

```php
Module::install('nwidart/hello');
```

Update dependencies for the specified module.

```php
Module::update('hello');
```

<a name="entity"></a>
## Module Entity

Obtner la entidad de un módulo.

```php
$module = Module::find('blog');
```

Obtener nombre

```
$module->getName();
```

Obtener nombre en lowercase.

```
$module->getLowerName();
```

Obtener nombre en  studlycase.

```
$module->getStudlyName();
```

Obtener path.

```
$module->getPath();
```

Obtener extra path.

```
$module->getExtraPath('Assets');
```

Activar 

```
$module->enable();
```

Desactivar

```
$module->disable();
```

Eliminar

```
$module->delete();
```

<a name="namespaces"></a>
## Custom Namespaces

Cuando se crea un nuevo módulo 
When you create a new module it also registers new custom namespace for `Lang`, `View` and `Config`. For example, if you create a new module named blog, it will also register new namespace/hint blog for that module. Then, you can use that namespace for calling `Lang`, `View` or `Config`. Following are some examples of its usage:

Calling Lang:

```php
Lang::get('blog::group.name');
```

Calling View:

```php
View::make('blog::index')

View::make('blog::partials.sidebar')
```

Calling Config:

```php
Config::get('blog.name')
```

## Publishing Modules

Have you created a laravel modules? Yes, I've. Then, I want to publish my modules. Where do I publish it? That's the question. What's the answer ? The answer is [Packagist](http://packagist.org).

<a name="auto-scan-vendor-directory"></a>
### Auto Scan Vendor Directory

Por defecto el directorio `vendor` no es escaneado automaticamente, se necesita actualizar el archivo de configuracion para permitarlo. Cambia el valor de `scan.enabled` a `true`. Por ejemplo:

```php
// file config/modules.php

return [
  //...
  'scan' => [
    'enabled' => true
  ]
  //...
]
```
Con esto puedes verificar los módulos que has instalado usando el comando `module:list`:

```
php artisan module:list
```

<a name="publishing-modules"></a>
## Publishing Modules

After creating a module and you are sure your module module will be used by other developers. You can push your module to [github](https://github.com) or [bitbucket](https://bitbucket.org) and after that you can submit your module to the packagist website.

You can follow this step to publish your module.

1. Create A Module.
2. Push the module to github.
3. Submit your module to the packagist website.
Submit to packagist is very easy, just give your github repository, click submit and you done.


## Credits

- [Nicolas Widart](https://github.com/nwidart)
- [gravitano](https://github.com/gravitano)
- [All Contributors](../../contributors)

## About Nicolas Widart

Nicolas Widart is a freelance web developer specialising on the laravel framework. View all my packages [on my website](https://nicolaswidart.com/projects).


## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
