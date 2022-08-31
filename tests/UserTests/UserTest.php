<?php
/** @noinspection PhpUndefinedFieldInspection */

use App\Models\Order;

test('test an order', function () {
    $model = new Order([
        'id'       => 1,
        'name' => 'John Doe',
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

    expect($model->name)->toBe('JOHN DOE')
        ->and($model->customer->id)->toBe(123)
        ->and($model->contacts[1]->name)->toBe('Jane Doe');
});