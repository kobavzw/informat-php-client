# Informat API Wrapper
PHP client library for the Informat school software API. This client allows you to 
- Fetch students
- Fetch registration
- Create new preregistrations

## Usage
The library is built on 3 main 'layers':
- The `Informat` class, which is instantiated with your client ID and secret.
- Directories, which are logical groups of api calls. These can be obtained by function calls on the `Informat` class.
- API calls, these can be instantiated by function calls on the directories.

The code below is a quick example of how you can fetch students
```php
use Koba\Informat\Informat;
use Koba\Informat\Scopes\AllScopesStrategy;

$informat = new Informat(
    'your-client-id',
    'your-client-secret',
    new AllScopesStrategy('000001', '000002', '000003'),
);

 $informat
    ->students()
    ->getStudents('000001')
    ->send();
```
This will return an array of `Student` objects, which has typed (and documented) properties.

### Scopes
Creating the `Informat` object can be done fairly easily as demonstrated above. The scopes paramete might need some extra explanation.

In the example above you see we pass an `AllScopesStrategy` object to the constructor. This is a way to let the API client know which scopes we want to request, which directly impacts which API calls you will be authorized to execute. The library supplies the `AllScopesStrategy`, which will request all possible scopes and the `SpecificScopesStrategy`, which allows you to specify the scopes that will be requested. Both require you to pass the institute numbers for all schools you wnat to access as parameters. The latter might be desirable if your client isn't authorized for all scopes or you want to limit the functionality for security reasons.

You can also create your own scope strategy by implementing the `ScopeStrategyInterface`.

### Calls
There are a couple of 'rules' that should be followed when managing calls
- When creating a call using a function on a directory, all required parameters for the API call need to be passed to the function. The institute number will always be the first parameter as it is required for all API calls.
- All optional paremeters can be set using setters on the API call.
- Setters on the API calls returns the call itself, which means you can easily chain them together.
- An API call will always be executed with the `send` method.

An example to illustrate these points:
```php
$informat
    ->students()
    ->getStudent(
        '000001', // institute number
        'bd26bb65-f54a-488d-866b-e1f9927d6be5' // student id
    )
    ->setReferenceDate(new DateTime())
    ->send();
```

### Advanced
The `Informat` object has some advanced setup options. You can pass an `AccessTokenManagerInterface` object, which allows you to implement your own access token caching solution. The rest of the constructor can be used to pass a [psr-18](https://www.php-fig.org/psr/psr-18/) client interface and [psr-17](https://www.php-fig.org/psr/psr-17/) HTTP response factories. If these options are omitted, the library will autodiscover any suitable implementations. If your project doesn't currently have one, you could take a look at [Guzzle 7](https://docs.guzzlephp.org/en/stable/).