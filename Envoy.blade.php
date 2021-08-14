@servers(['web' => ['pilo']])

@setup
$path = "/home/pilo/back";
@endsetup

@task('deploy')
cd {{$path}}

php artisan down


@if ($branch)
git pull origin {{$branch}}
@else
git pull origin master
@endif

@if($composer)
cd {{$path}}
composer update
@endif

@if($migrate)
cd {{$path}}
php artisan migrate
@endif

php artisan optimize

php artisan up

@endtask