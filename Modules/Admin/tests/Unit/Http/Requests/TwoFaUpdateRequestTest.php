<?php

use Modules\Admin\Http\Requests\Auth\TwoFaUpdateRequest;

beforeEach(function () {
    test()->requestData = new TwoFaUpdateRequest();
});

test('rules', function () {
    $rules = [
        'code' => [
            'required',
            'string',
            'min:6',
        ],
    ];

    $this->assertEquals($rules, test()->requestData->rules());
});

test('authenticate', function () {
    $this->assertTrue(test()->requestData->authorize());
});
