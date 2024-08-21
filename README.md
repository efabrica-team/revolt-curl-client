# Revolt Curl Client

This is a fork of `symfony/http-client`'s CurlClient that uses Revolt's async EventLoop to wait for the response instead of blocking the
main thread.

This client was created because native PHP streams that are used by `amphp/http-client` are slow, as our applications were hanging on
`stream_select()` a lot but they weren't hanging on `curl_multi_select()`. Reasons for this are unknown to us, but if you know, 
please share your knowledge and we will place it in this README.

It uses Symfony's @internal classes, so it might break on minor Symfony versions. We will rush to fix it if it does.

## Installation

```bash
composer require efabrica/revolt-curl-client
```

## Usage

```php
use Efabrica\RevoltCurlClient\RevoltCurlClient;

$client = new RevoltCurlClient();
$f1 = async(function () use ($client) {
    echo "Request 1\n";
    $response = $client->request('GET', 'https://httpbin.org/get?1');
    $response->getContent();
    echo "Request 2\n";
    $response2 = $client->request('GET', 'https://httpbin.org/get?2');
    $response2->getContent();
});
$f2 = async(function () use ($client) {
    echo "Request 3\n";
    $response = $client->request('GET', 'https://httpbin.org/get?3');
    $response->getContent();
    echo "Request 4\n";
    $response2 = $client->request('GET', 'https://httpbin.org/get?4');
    $response2->getContent();
});
await([$f1, $f2]);

// Outputs:
// Request 1
// Request 3
// Request 2
// Request 4
```


