<?php
/** @noinspection PhpUndefinedFieldInspection */

use ZeroToProd\ServiceModel\Model;
use ZeroToProd\ServiceModel\Schema;

test('new model', function () {
    expect(is_a(new Model, Model::class))->toBeTrue();
});
test('without a schema', function () {
    $model = new Model(['id' => 1]);

    expect($model->id)->toBeNull();
});

test('with schema', function () {
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
