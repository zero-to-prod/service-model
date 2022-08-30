<?php
/** @noinspection PhpUndefinedFieldInspection */

use ZeroToProd\ServiceModel\AttributeType;
use ZeroToProd\ServiceModel\Casts\IntCast;
use ZeroToProd\ServiceModel\Model;
use ZeroToProd\ServiceModel\Schema;

test('returns an attribute', function () {
    $test_value = '1';

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerAttribute('id');
        }
    };

    $model = new Model(['id' => $test_value], $schema);

    expect($model->id)->toBe($test_value);
});

test('overwrites the same attribute', function () {
    $test_value = '1';

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerAttribute('id');
            $this->registerAttribute('id', AttributeType::int);
        }
    };

    $model = new Model(['id' => $test_value], $schema);

    expect($model->id)->toBe(1);
});

test('dynamically register attribute in one line', function () {
    $model = new Model();

    $model->registerAttribute('id', AttributeType::int, IntCast::class, '1');

    expect($model->id)->toBe(1);
});

test('dynamically register attribute', function () {
    $model = new Model();

    $model->registerAttribute('id', AttributeType::int, IntCast::class);
    $model->id = '1';
    // die(var_dump($model));

    expect($model->id)->toBe(1);
});
test('dynamically register attribute simple', function () {
    $model = new Model();

    $model->registerAttribute('id', AttributeType::int);
    $model->id = '1';
    // die(var_dump($model));

    expect($model->id)->toBe(1);
});
test('dynamically register attribute minimal', function () {
    $model = new Model();

    $model->registerAttribute('id');
    $model->id = '1';
    // die(var_dump($model));

    expect($model->id)->toBe('1');
});
test('returns two attributes', function () {
    $test_value_id   = '1';
    $test_value_name = '2';

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerAttribute('id');
            $this->registerAttribute('name');
        }
    };

    $model = new Model(['id' => $test_value_id, 'name' => $test_value_name], $schema);

    expect($model->id)->toBe($test_value_id)
        ->and($model->name)->toBe($test_value_name);
});