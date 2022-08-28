<?php
/** @noinspection PhpUndefinedFieldInspection */

use ZeroToProd\ServiceModel\Casts\IntCast;
use ZeroToProd\ServiceModel\Casts\StringCast;
use ZeroToProd\ServiceModel\DataType;
use ZeroToProd\ServiceModel\Model;
use ZeroToProd\ServiceModel\Schema;

test('can override default', function () {
    $test_value = '1';

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerType('id', DataType::int, StringCast::class);
        }
    };

    $model = new Model(['id' => $test_value], $schema);

    expect($model->id)->toBeString();
});

test('typecast to int', function () {
    $test_value = '1';

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerType('id', DataType::int);
        }
    };

    $model = new Model(['id' => $test_value], $schema);

    expect($model->id)->toBeInt();
});

test('typecast to string', function () {
    $test_value = 1;

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerType('id', DataType::string);
        }
    };

    $model = new Model(['id' => $test_value], $schema);

    expect($model->id)->toBeString();
});

test('typecast to immutable time from datetime immutable', function () {
    $test_value = new DateTimeImmutable;

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerType('created_at', DataType::datetime_immutable);
        }
    };

    $model = new Model(['created_at' => $test_value], $schema);

    expect(is_a($model->created_at, DateTimeImmutable::class))->toBeTrue();
});

test('typecast to immutable time from string', function () {
    $test_value = '2020-01-01';

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerType('created_at', DataType::datetime_immutable);
        }
    };

    $model = new Model(['created_at' => $test_value], $schema);

    expect(is_a($model->created_at, DateTimeImmutable::class))->toBeTrue();
});
