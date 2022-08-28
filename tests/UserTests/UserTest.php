<?php
/** @noinspection PhpUndefinedFieldInspection */

use ZeroToProd\ServiceModel\DataType;
use ZeroToProd\ServiceModel\Model;
use ZeroToProd\ServiceModel\Schema;

test('test an order', function () {
    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerType('id', DataType::int);
            $this->registerType('name', DataType::string);
            $this->registerType('due_date', DataType::datetime_immutable);
            $this->registerType('created_at', DataType::datetime_immutable);
            $this->registerType('updated_at', DataType::datetime_immutable);
        }
    };

    $model = new Model(['id' => 1, 'name' => 'order 1'], $schema);


    expect($model->id)->toBe(1);
});