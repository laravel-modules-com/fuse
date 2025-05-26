<?php

use Modules\{Module}\Models\{Model};

beforeEach(function () {
    $this->authenticate();
});

test('can see show {model } page', function () {
    ${modelCamel} = {Model}::factory()->create();

    $this
        ->get(route('admin.{module-}.show', ${modelCamel}))
        ->assertOk();
});
