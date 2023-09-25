### Laravel installation commands
- Go to: https://panjeh.medium.com/how-to-install-specific-laravel-version-using-composer-f30df54632b5
- composer create-project laravel/laravel="9.*" ProjectName
- php artisan key:generate


### Encrypt .env
- Info link: https://blog.laravel.com/laravel-new-environment-encryption-commands
- LARAVEL_ENV_ENCRYPTION_KEY=base64:UR9bH745sqGV62phOAVuxC8/MNh7PzjuB4DbHDn7w2c=

-  php artisan env:encrypt --key=3UVsEgGVK36XN82KKeyLFMhvosbZN1aF
-  php artisan env:decrypt --key=3UVsEgGVK36XN82KKeyLFMhvosbZN1aF


### install sunctum
- composer require laravel/sanctum
- php artisan vendor:publish --provider="Laravel\Sanctum\SanctumServiceProvider"
- php artisan migrate
- php artisan serve


### Install voyager
- https://github.com/thedevdojo/voyager\
- composer require tcg/voyager
- php artisan voyager:install --with-dummy


