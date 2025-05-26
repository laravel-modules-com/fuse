<?php

use Livewire\Livewire;
use Modules\{Module}\Livewire\Admin\Edit{Model};
use Modules\{Module}\Models\{Model};

beforeEach(function () {
    $this->authenticate();
});

test('can see edit {model } page', function () {
    ${modelCamel} = {Model}::factory()->create();

    $this
        ->get(route('admin.{module-}.edit', ${modelCamel}))
        ->assertOk();
});

test('can update {model }', function () {
    ${modelCamel} = {Model}::factory()->create([
        'name' => 'Original Name',
        'email' => 'original@example.com',
    ]);

    Livewire::test(Edit{Model}::class, ['{model_}' => ${modelCamel}])
        ->set('name', 'Updated Name')
        ->set('email', 'updated@example.com')
        ->call('update')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.{module-}.index'));

    ${modelCamel}->refresh();

    expect(${modelCamel}->name)->toBe('Updated Name')
        ->and(${modelCamel}->email)->toBe('updated@example.com');

    $this->assertDatabaseHas('audit_trails', [
        'title' => 'Updated {Model } Updated Name',
        'link' => route('admin.{module-}.show', ['{model_}' => ${modelCamel}->id]),
        'section' => '{Module }',
        'type' => 'Update',
    ]);
});

test('name cannot be null', function () {
    ${modelCamel} = {Model}::factory()->create();

    Livewire::test(Edit{Model}::class, ['{model_}' => ${modelCamel}])
        ->set('name', '')
        ->call('update')
        ->assertHasErrors('name');
});

test('email cannot be null', function () {
    ${modelCamel} = {Model}::factory()->create();

    Livewire::test(Edit{Model}::class, ['{model_}' => ${modelCamel}])
        ->set('email', '')
        ->call('update')
        ->assertHasErrors('email');
});

test('email must be an email', function () {
    ${modelCamel} = {Model}::factory()->create();

    Livewire::test(Edit{Model}::class, ['{model_}' => ${modelCamel}])
        ->set('email', 'not-an-email')
        ->call('update')
        ->assertHasErrors('email');
});

test('email must be unique except for current {model}', function () {
    ${modelCamel}1 = {Model}::factory()->create([
        'email' => '{modelCamel}1@example.com',
    ]);

    ${modelCamel}2 = {Model}::factory()->create([
        'email' => '{modelCamel}2@example.com',
    ]);

    Livewire::test(Edit{Model}::class, ['{model_}' => ${modelCamel}1])
        ->set('email', '{modelCamel}2@example.com')
        ->call('update')
        ->assertHasErrors('email');

    Livewire::test(Edit{Model}::class, ['{model_}' => ${modelCamel}1])
        ->set('email', '{model}1@example.com')
        ->call('update')
        ->assertHasNoErrors();
});
