@servers(['web' => ['root@78.47.116.174']])

@setup
$path = "/home/new_pilo";
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

php artisan cache:clear

php artisan up

@endtask
