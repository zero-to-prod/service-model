<?php
/** @noinspection PhpUndefinedFieldInspection */

use ZeroToProd\ServiceModel\Model;
use ZeroToProd\ServiceModel\Schema;

test('returns null', function () {
    $model = new Model;

    expect($model->toArray())->toBeNull();
});

test('returns array with dynamic get/get', function () {
    $model = new Model;

    $model->id = 1;

    expect($model->toArray())->toBe(['id' => 1]);
});

test('returns an attribute to an array', function () {
    $test_value = '1';

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerType('id');
        }
    };

    $model     = new Model(['id' => '2'], $schema);
    $model->id = '2';

    expect($model->toArray())->toBe(['id' => '2']);
});

test('returns an attribute to an array after dynamic set', function () {
    $test_value = '1';

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerType('id');
        }
    };

    $model = new Model(['id' => $test_value], $schema);

    expect($model->toArray())->toBe(['id' => $test_value]);
});

test('returns two attributes to an array', function () {
    $test_value_id   = '1';
    $test_value_name = '2';

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerType('id');
            $this->registerType('name');
        }
    };

    $model = new Model(['id' => $test_value_id, 'name' => $test_value_name], $schema);

    expect($model->toArray())->toBe(['id' => $test_value_id, 'name' => $test_value_name]);
});