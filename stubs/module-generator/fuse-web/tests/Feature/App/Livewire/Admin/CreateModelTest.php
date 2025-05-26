<?php

use Livewire\Livewire;
use Modules\{Module}\Livewire\Admin\Create{Model};
use Modules\{Module}\Models\{Model};

beforeEach(function () {
    $this->authenticate();
});

test('can see create {model } page', function () {
    $this
        ->get(route('admin.{module-}.create'))
        ->assertOk();
});

test('can create {model }', function () {
    Livewire::test(Create{Model}::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->call('create')
        ->assertHasNoErrors()
        ->assertRedirect(route('admin.{module-}.index'));

    $this->assertDatabaseHas('{module_}', [
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    ${modelCamel} = {Model}::where('email', 'john@example.com')->first();

    $this->assertDatabaseHas('audit_trails', [
        'title' => 'Created {Model } John Doe',
        'link' => route('admin.{module-}.show', ['{model_}' => ${modelCamel}->id]),
        'section' => '{Module }',
        'type' => 'Create',
    ]);
});

test('name cannot be null', function () {
    Livewire::test(Create{Model}::class)
        ->set('name', '')
        ->set('email', 'john@example.com')
        ->call('create')
        ->assertHasErrors('name');
});

test('email cannot be null', function () {
    Livewire::test(Create{Model}::class)
        ->set('name', 'John Doe')
        ->set('email', '')
        ->call('create')
        ->assertHasErrors('email');
});

test('email must be an email', function () {
    Livewire::test(Create{Model}::class)
        ->set('name', 'John Doe')
        ->set('email', 'not-an-email')
        ->call('create')
        ->assertHasErrors('email');
});

test('email must be unique', function () {
    {Model}::factory()->create([
        'email' => 'john@example.com',
    ]);

    Livewire::test(Create{Model}::class)
        ->set('name', 'John Doe')
        ->set('email', 'john@example.com')
        ->call('create')
        ->assertHasErrors('email');
});
