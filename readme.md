Laravel 5 - Duo Security
=======================

An example of how to implement two factor authentication using Duo Security and Laravel 5. 

Once complete, a user will be asked for their username and password, which is authenticated by Laravel, then if successful, they will be shown a prompt by Duo Security which will require a second kind of authentication. If that is also authenticated, the user will be logged in by Laravel and redirected to the homepage. 

There are therefore 3 stages:
- Laravel login page
- Duo Security login page
- Authenticated homepage

##### Notes
1. [Duo Security](https://www.duosecurity.com/) is a service that offers a way to protect a site using two factor authentication. You can find their PHP code [here](https://github.com/duosecurity/duo_php) which this example repo extends in a minor way.

2. [Laravel](http://laravel.com/) is a PHP MVC framework. You can find it [here](https://github.com/laravel/laravel).

I am not affiliated in any way to either.

##### Instructions

This repo is based on a fresh version of Laravel 5, so to recreate this implementation, i would recommend you start with the same from [here](https://github.com/laravel/laravel) and follow the steps listed below. This repo is a tutorial rather than a finished product to plug in.

---

##### Steps
1. Sign up for a Duo Security account then create a new Web SDK integration. Note the following which you will require later
    - Integration key	
    - Secret key	
    - API hostname

2. Clone a new instance of Laravel

3. Run the following in Terminal `composer create-project --prefer-dist laravel/laravel laravel5duo`

4. Set up some kind of database (I used mySQL) and add the relevant credentials to `env`

5. Run the following artisan command to generate the migration the default laravel Users table - `php artisan migrate`

6. Run the following artisan command to generate a scaffold basic login and registration views and routes `php artisan make:auth`

7. Add a new folder at `app/Libraries` and add the file from this repo from the same location, `Duo.php` (available [here](https://github.com/duosecurity/duo_php/blob/master/src/Web.php)) and change the name space to `App\Libraries`

8. Open `.env` and add add the Intergration key `DUO_IKEY`, Secret Key `DUO_SKEY` and Host `DUO_HOST` values from your Duo Security account, and generate a random 40 char Application Key `DUO_AKEY`

9. Open `routes/web.php`, and add a new post route to overpass the default (`'/login'`) follow the route in this repo

10. Create `resources/views/auth/duo_login.blade.php` and add the code shown in the file of the same name from this repo. This uses Laravel's Blade syntax and is the outer structure for every page.

11. Create `public/js/duo_web_v2.min.js` (available [here](https://github.com/duosecurity/duo_php/tree/master/js/duo_web_v2.min.js))

12. Open `resources/views/layouts/app.blade.php` and add an import to the JS asset library in the `<head>` section.

13. Open `app/Http/Controllers/Auth/LoginController.php` and add the code from file of the same name from this repo.

14. Browse to your webroot and register a user then try to Login using that user. 

15. Follow the Duo security instructions to authenticate using their service
