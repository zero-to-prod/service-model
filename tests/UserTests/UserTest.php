<?php
/** @noinspection PhpUndefinedFieldInspection */

use App\Models\Order;

test('test an order', function () {
    $model = new Order([
        'id'       => 1,
        'plus_one' => 1,
        'customer' => [
            'id'   => 123,
            'name' => 'John Doe'
        ],
        'contacts' => [
            [
                'id'   => 1,
                'name' => 'John Doe'
            ],
            [
                'id'   => 2,
                'name' => 'Jane Doe'
            ],
        ]
    ]);

    expect($model->plus_one)->toBe(2)
        ->and($model->customer->id)->toBe(123)
        ->and($model->contacts[1]->name)->toBe('Jane Doe');
});