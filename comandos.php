-- migraciones --
php artisan migrate
php artisan migrate:rollback
php artisan migrate:refresh

-- modelos --
php artisan make:model Rol -m        /* crea modelo y la migracion */