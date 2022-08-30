<?php
/** @noinspection PhpUndefinedFieldInspection */

use ZeroToProd\ServiceModel\AttributeType;
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