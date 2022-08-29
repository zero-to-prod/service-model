<?php
/** @noinspection PhpUndefinedFieldInspection */

use App\Models\Order;

test('test an order', function () {
    $model = new Order(['id' => 1, 'plus_one' => 1]);

    expect($model->plus_one)->toBe(2);
});