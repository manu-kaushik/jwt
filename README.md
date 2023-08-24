# JWT PHP

> Note : This package uses HS256 algorithm only.

## Usage

Requires a 256 bit secret key, needs to be generated manually.

```php
$secret = 'x31thQ9QO0mZb1dKq6uejr9g7YE1uMwf';
```

### Signing a token

```php
$data = [
    'name' => 'John Doe',
    'exp' => '1655683200'
];

$token = JWT::sign($data, $secret);
```

> `exp` claim in the payload should be an epoch timestamp.

### Verifying a token

```php
try {
    $payload = JWT::verify($token, $secret);
} catch (InvalidTokenException $e) {
    // ...
}
```

> If the token is valid, payload of the token is returned.

> `InvalidTokenException` is thrown if the token is invalid or expired.
