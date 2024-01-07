# An extension to Jesse Donat's `mock-webserver`

<img src="title.png" align="right" alt="a group of actors sitting in a parade" width="300"/>

This minimalistic library is intended to enable `donatj/mock-webserver` to handle more complex request definitions, 
by adapting the interfaces of `InterNations/http-mock` into it. 

Most of the code appears to be a partial rewriting of the `Matcher` and `Expectation` implementation in `InterNations/http-mock`. 
Therefore, credits of the code should go to `InterNations/http-mock`.

## Why extending `donatj/mock-webserver`?

We could have chosen not to use `donatj/mock-webserver` and instead to use `InterNations/http-mock`. 
We did not choose this path because `InterNations/http-mock` is somewhat archived, while `donatj/mock-webserver` is 
actively being maintained. 

Another reason why we prefer `donatj/mock-webserver` is the simpler dependency, as `InterNations/http-mock` appears to use the Symfony framework, which could be a heavy machinery.

## How to use

The test script provides a self-explanatory example.

```php
<?php
$complex_response = new ComplexResponse();
$complex_response
    ->when_path_is('/api/users')
    ->when_method_is('POST')
    ->when_header_is('x-api-key', new RegexMatcher('/^mock/'))
    ->when_header_exists('x-api-version')
    ->when_header_not_exists('x-api-version-old')
    ->when_query_param_is('GET', 'session_uid', new RegexMatcher('/^s/'))
    ->when_query_param_exists('POST', 'image')
    ->when_query_param_not_exists('POST', 'debug')
    ->then(new Response('{"id": 1, "name": "John Doe"}', [], 200));
?>
```
Since `ComplexResponse` implements `ResponseInterface`, it can be a drop-in replacement.


## License

This package is under the MIT license. For more detail, see [LICENSE](./LICENSE).
