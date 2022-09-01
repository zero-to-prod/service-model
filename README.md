# Schema-based models for your data

## Usage

This package provides a way to describe attributes on a model.
By passing an associative array to the models' constructor, the attributes are automatically handled based on the schema defined on the model.

Custom typecasts can be registered in the schema.

```php
$order = new Order(['id' => '1', 'name' => 'John Doe']);

$order->id; // (int) 1 
$order->name: // (string) 'JOHN DOE'
```

```php
use ZeroToProd\ServiceModel\Model;

class Order extends Model
{
    protected string $schema = OrderSchema::class;
}
```

```php
use ZeroToProd\ServiceModel\AttributeType;
use ZeroToProd\ServiceModel\Schema;

class OrderSchema extends Schema
{
    public function __construct()
    {
        $this->registerAttribute(name: 'id', type: AttributeType::int);
        $this->registerAttribute(name: 'name', cast: TitleCast::class);
    }
}
```

```php
use ZeroToProd\ServiceModel\CastsAttributes;

class TitleCast implements CastsAttributes
{
    public function get($value): string
    {
        return strtoupper($value);
    }

    public function set($value): string
    {
        return strtoupper($value);
    }
}
```
## Features

Renaming
```php
/* In Schema */
$this->registerAttribute(name: 'id',  rename: 'object_id');

$model = new Model(['id' => 1]);

$model->id; // null
$model->object_id; // (int) 1
```

Aliasing
```php
/* In Schema */
$this->registerAttribute(name: 'id',  alias: 'object_id');

$model = new Model(['id' => 1]);

$model->id; // (int) 1
$model->object_id; // (int) 1
```

Native PHP Types:
- `int`
- `string`
- `DatetimeImmutable`

Dynamic Attribute Registration
```php
$model = new Model();
$model->int; // null

$model->registerAttribute(name: 'id', type: AttributeType::int, cast: IntCast::class, value: '1');
$model->id; // (int) 1
```
Ignores unregistered attributes when passed to the constructor.
```php
$model = new Model(['registered' => true, 'unregistered' => false]);

$model->registered; // true
$model->unregistered; // null
```

Dynamic set/get
```php
$model = new Model();

$model->name; // null
$model->name = 'John Doe';
$model->name; // 'John Doe'
```
To Array
```php
$model = new Model();
$model->toArray(); // []

$model = new Model(['name' => 'John Doe']);
$model->toArray(); // ['name' => 'John Doe']
```
