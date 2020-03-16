@servers(['web' => 'bm@d3.b4m.dev'])

@setup
$date = date('Y-m-d-h-i-s');
$data_dir = "/data/emoxter";
@endsetup

@story('deploy', ['on' => 'web'])
    git
    composer
    build-assets
    link-folders
    restart-horizon
    set-release
@endstory

@task('git')
    cd {{ $data_dir }}
    git clone git@github.com:marcusmyers/emoxter.blog.git {{ $date }}
    ln -sf {{ $data_dir }}/env {{ $date }}/.env
    ln -sf {{ $data_dir }}/storage/ {{ $date }}/storage
@endtask

@task('composer')
    cd {{ $data_dir }}/{{ $date }}
    composer install --no-dev
    php artisan migrate --force
    php artisan cache:clear
    php artisan view:clear
@endtask

@task('link-folders')
    @if ($first_deploy)
        ln -sf {{ $data_dir }}/{{ $date }} {{ $data_dir }}/current
    @else
        new_previous=$(readlink {{ $data_dir }}/current)
        unlink {{ $data_dir }}/current
        ln -sf {{ $data_dir }}/{{ $date }} {{ $data_dir }}/current
        sudo chown -Rf www-data:bm {{ $data_dir }}/current/*
        old_previous=$(readlink {{ $data_dir }}/previous)
        unlink {{ $data_dir }}/previous
        rm -Rf $old_previous
        ln -sf $new_previous {{ $data_dir }}/previous
    @endif
@endtask

@task('build-assets')
    cd {{ $data_dir }}/{{ $date }}
    yarn install
    yarn run production
@endtask

@task('restart-horizon')
    sudo supervisorctl restart aaac_horizon
@endtask

@task('set-release')
    cd {{ $data_dir }}/current
    export SENTRY_AUTH_TOKEN=$(cat {{ $data_dir }}/sentry_auth_token.txt)
    export SENTRY_ORG=mark-myers
    VERSION=$(sentry-cli releases propose-version)
    sentry-cli releases new -p aaac-course-management $VERSION
    sentry-cli releases set-commits --auto $VERSION
    sentry-cli releases deploys $VERSION new -e production
@endtask

@finished
    @slack('https://hooks.slack.com/services/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', '#alerts', 'Successfully deployed eMoxter Website.')
@endfinished