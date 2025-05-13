<?php

use Illuminate\Foundation\Testing\LazilyRefreshDatabase;

pest()->extend(Tests\TestCase::class)
    ->in(dirname(__DIR__))
    ->beforeEach(function () {
        Http::preventStrayRequests();
    });

uses(LazilyRefreshDatabase::class)->in(dirname(__DIR__));
