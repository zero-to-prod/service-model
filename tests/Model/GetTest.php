<?php
/** @noinspection PhpUndefinedFieldInspection */

use ZeroToProd\ServiceModel\Model;
use ZeroToProd\ServiceModel\Schema;

test('gets a registered attribute', function () {
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

test('returns null for an attribute that is unregistered', function () {
    $model = new Model(['id' => 1]);

    expect($model->id)->toBeNull();
});