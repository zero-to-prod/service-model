<?php
/** @noinspection PhpUndefinedFieldInspection */

use App\Models\Order;

test('test an order', function () {
    $model = new Order(['id' => 1, 'name' => 'name']);

    expect($model->id)->toBe(1)
        ->and($model->name)->toBe('NAME');
});