# Action

## Introduction

This class intends to make programatic and dynamic functions calls. 

## How to use

To use the `Action` class, just use the `factory` method, to build a new object, passing the parameters to use on this function.
At the end, just execute the instance's `exec` method, passing optionally the additional parameters.  

The URI patterns you can use are:


| Type | Example |
| --------------- | ---------------------- |
| Simple function | 'mySampleFunction()' |
| Class method    | '\namespace\MyClass::functionName()' |
| REST call*       | 'POST;https://user!password@my_domain.com:8081/api/v99/xpto?v1=1&v2=2#xpto' |  

* Not implemented yet


### Simple function

Make a call to a *global* function. 

#### Example

```php

function multiply($x,$y) {
    return $x * $y;
}

$action = Action::factory('multiply()');

$response = $action->exec(2,5);

// result = 10

```

### Class method

Instantiate a class object, and execute the assigned method.


#### Constructor

If your class have a constructor method, and require any parameter, you can suply it on 3rd parameter of `factory` method:

```php

$action = Action::factory('MyClass::myFunction()',[],['constructor'=>[1,'string',false]]);


```

On above the case, the values `1`, `'string'` and `false` will be applied on `MyClass` constructor. 


#### Examples

```php

class MyClass {


    public function myFunction($id, $fieldName) {
        // ...
        return [
            'id' => $id,
            'field_name'=> $fieldName
        ];
    }

}


$action = Action::factory('MyClass::myFunction()', [1, 'name']);

$response = $action->exec();

print_r($response);
 
```

Will display: 

```
Array 
(
    [id] => 1
    [field_name] => name
)

```