<?php

declare(strict_types=1);

namespace Efabrica\RevoltCurlClient;


/**
 * A pushed response with its request headers.
 *
 * @author Alexander M. Turek <me@derrabus.de>
 *
 * @internal
 */
final class RevoltPushedResponse
{
    public function __construct(
        public RevoltCurlResponse $response,
        public array $requestHeaders,
        public array $parentOptions,
        public \CurlHandle $handle,
    ) {
    }
}
