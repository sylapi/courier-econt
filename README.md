# Courier-econt

![PHPStan](https://img.shields.io/badge/PHPStan-level%205-brightgreen.svg?style=flat)

## Methody

### Init

```php
    /**
    * @return Sylapi\Courier\Courier
    */
    $courier = CourierFactory::create('Econt',[
        'login' => 'mylogin',
        'password' => 'mypassword',
        'sandbox' => false,
    ]);

```

### CreateShipment

```php
    // ...
```

### PostShipment

```php
    // ...
```

### GetStatus

```php
    // ...
```

### GetLabel

```php
    // ...
```

## ENUMS



## Komendy

| KOMENDA | OPIS |
| ------ | ------ |
| composer tests | Testy |
| composer phpstan |  PHPStan |
| composer coverage | PHPUnit Coverage |
| composer coverage-html | PHPUnit Coverage HTML (DIR: ./coverage/) |
