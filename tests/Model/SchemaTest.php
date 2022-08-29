<?php
/** @noinspection PhpUndefinedFieldInspection */

use ZeroToProd\ServiceModel\Model;
use ZeroToProd\ServiceModel\Schema;
test('use schema property the model', function () {
    $test_value = '1';

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerType('id');
        }
    };
    $model = new class extends Model {
        protected string $schema = TestSchema::class;
    };

    $model = new $model(['id' => $test_value], $schema);

    expect($model->id)->toBe($test_value);
});
class TestSchema extends Schema {
    public function __construct()
    {
        $this->registerType('id');
    }
}
test('use schema property in constructor', function () {
    $test_value = '1';

    $schema = new class extends Schema {
        public function __construct()
        {
            $this->registerType('id');
        }
    };

    $model = new Model(['id' => $test_value], $schema);

    expect($model->id)->toBe($test_value);
});
