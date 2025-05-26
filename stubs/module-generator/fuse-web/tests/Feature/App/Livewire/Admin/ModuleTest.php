<?php

use Livewire\Livewire;
use Modules\{Module}\Livewire\Admin\{Module};
use Modules\{Module}\Models\{Model};

beforeEach(function () {
    $this->authenticate();
});

test('can see {module } page', function () {
    $this
        ->get(route('admin.{module-}.index'))
        ->assertOk();
});

test('can see {module } create page', function () {
    $this
        ->get(route('admin.{module-}.create'))
        ->assertOk();
});

test('can see {module } edit page', function () {
    $this
        ->get(route('admin.{module-}.edit', {Model}::factory()->create()))
        ->assertOk();
});

test('can see {module } show page', function () {
    $this
        ->get(route('admin.{module-}.show', {Model}::factory()->create()))
        ->assertOk();
});

test('can search {module }', function () {
    Livewire::test({Module}::class)
        ->set('name', 'john')
        ->assertSet('name', 'john');
});

test('can set property', function () {
    Livewire::test({Module}::class)
        ->set('sortField', 'name')
        ->assertSet('sortField', 'name');
});

test('can sort {module } in desc', function () {
    {Model}::factory()->create(['name' => 'Andy']);
        {Model}::factory()->create(['name' => 'Dave']);
            {Model}::factory()->create(['name' => 'Zara']);

    Livewire::test({Module}::class)
        ->call('sortBy', 'name')
        ->assertSet('sortField', 'name')
        ->assertSeeInOrder(['Zara', 'Dave', 'Andy']);
});

test('can sort {module } in asc', function () {
    {Model}::factory()->create(['name' => 'Andy']);
        {Model}::factory()->create(['name' => 'Dave']);
            {Model}::factory()->create(['name' => 'Zara']);

    Livewire::test({Module}::class)
        ->call('sortBy', 'name')
        ->call('sortBy', 'name')
        ->assertSet('sortAsc', true)
        ->assertSeeInOrder(['Andy', 'Dave', 'Zara']);
});

test('can filter name', function () {
    {Model}::factory()->create([
        'name' => 'Andy',
        'email' => 'demo@demo.com',
    ]);

    Livewire::test({Module}::class)
        ->set('name', 'Andy')
        ->call('load{ModuleCamel}')
        ->assertOk()
        ->assertSet('openFilter', false)
        ->assertSee('Andy');
});

test('can filter email', function () {
    {Model}::factory()->create([
        'name' => 'Andy',
        'email' => 'demo@demo.com',
    ]);

    Livewire::test({Module}::class)
        ->set('email', 'demo@demo.com')
        ->call('load{ModuleCamel}')
        ->assertOk()
        ->assertSee('demo@demo.com');
});

test('can reset', function () {
    Livewire::test({Module}::class)
        ->call('resetFilters')
        ->assertSet('name', '')
        ->assertSet('email', '')
        ->assertSet('openFilter', false)
        ->assertSet('selected', [])
        ->assertSet('selectAll', false);
});

test('can delete {model }', function () {
    ${model} = {Model}::factory()->create([
        'name' => 'Dave',
        'email' => 'demo45@demo.com',
    ]);

    Livewire::test({Module}::class)
        ->call('delete{ModelCamel}', ${model}->id);

    $this->assertSoftDeleted('{module_}', [
        'id' => ${model}->id,
    ]);
});

test('can export {module } to csv', function () {

    {Model}::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

        {Model}::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    Livewire::test({Module}::class)->call('export{ModuleCamel}')
        ->assertOk();
});

test('can select {module }', function () {
    // Create test {module}
    ${model}1 = {Model}::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    ${model}2 = {Model}::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    Livewire::test({Module}::class)
        ->set('selected', [${model}1->id])
        ->assertSet('selected', [${model}1->id]);
});

test('can select all {module}', function () {
    // Create test {module}
    ${model}1 = {Model}::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    ${model}2 = {Model}::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    $component = Livewire::test({Module}::class);

    // Get the IDs as strings (as they would be in the form)
    $expectedIds = [${model}1->id, ${model}2->id];
    $expectedIds = array_map('strval', $expectedIds);

    $component->set('selectAll', true)
        ->assertSet('selectAll', true)
        ->assertCount('selected', count($expectedIds));

    // Check that all {model} IDs are in the selected array
    foreach ($expectedIds as $id) {
        $component->assertSet('selected', function ($selected) use ($id) {
            return in_array($id, $selected);
        });
    }
});

test('can archive {module} with filters', function () {

    ${model}1 = {Model}::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    ${model}2 = {Model}::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    Livewire::test({Module}::class)
        ->set('name', 'John')
        ->call('archive{ModuleCamel}');

    $this->assertSoftDeleted('{module_}', [
        'id' => ${model}1->id,
    ]);

    $this->assertDatabaseHas('{module_}', [
        'id' => ${model}2->id,
        'deleted_at' => null,
    ]);
});

test('can archive selected {module}', function () {

    ${model}1 = {Model}::factory()->create([
        'name' => 'John Doe',
        'email' => 'john@example.com',
    ]);

    ${model}2 = {Model}::factory()->create([
        'name' => 'Jane Smith',
        'email' => 'jane@example.com',
    ]);

    Livewire::test({Module}::class)
        ->set('selected', [${model}1->id])
        ->call('archive{ModuleCamel}');

    $this->assertSoftDeleted('{module_}', [
        'id' => ${model}1->id,
    ]);

    $this->assertDatabaseHas('{module_}', [
        'id' => ${model}2->id,
        'deleted_at' => null,
    ]);
});
