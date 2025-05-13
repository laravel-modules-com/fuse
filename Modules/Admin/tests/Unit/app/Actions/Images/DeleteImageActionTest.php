<?php

use Illuminate\Support\Facades\Storage;
use Modules\Admin\Actions\Images\DeleteImageAction;

test('can delete image', function () {

    Storage::fake();

    $path = '2022-07-13.jpg';

    Storage::disk('public')->put($path, 'content');

    app(DeleteImageAction::class)($path);

    Storage::disk('public')->assertMissing($path);
})->skip('to fix');
