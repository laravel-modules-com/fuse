<?php

test('cannot run db:build on production', function () {
    config(['app.env' => 'production']);

    $this->artisan('db:build')
        ->expectsOutput('This command is disabled on production.')
        ->assertSuccessful();
});
