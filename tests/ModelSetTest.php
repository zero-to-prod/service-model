<?php
/** @noinspection PhpUndefinedFieldInspection */

use ZeroToProd\ServiceModel\Model;
use ZeroToProd\ServiceModel\Schema;

test('sets a registered attribute', function () {
    $test_value = '1';

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerType('id');
        }
    };

    $model = new Model(['id' => $test_value], $schema);

    expect($model->id)->toBe($test_value);
    $model->id = '2';
    expect($model->id)->toBe('2');
});

test('sets an unregistered attribute', function () {
    $model = new Model();

    $model->unregistered = '2';
    expect($model->unregistered)->toBe('2');
});