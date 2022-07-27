<?php

declare(strict_types=1);

namespace Devscast\Pexels\Exception;

/**
 * Class NetworkException.
 *
 * @author bernard-ng <bernard@devscast.tech>
 * @template T
 * @phpstan-template T
 */
class NetworkException extends \Exception
{
    public function __construct(
        string $message,
        ?string $type = null,
        public ?int $status = null
    ) {
        if ($this->status !== null) {
            parent::__construct($message . ' (HTTP ' . $status . '/' . $type . ')');
        } else {
            parent::__construct($message);
        }
    }

    public static function create(string $message, string $type, int $status): self
    {
        $message = empty($message) ? 'No message was provided' : $message;
        return match (true) {
            $status === 401 || $status === 429 => new AccountException($message, $type, $status),
            $status >= 400 && $status <= 499 => new ClientException($message, $type, $status),
            $status >= 500 && $status <= 599 => new ServerException($message, $type, $status),
            default => new self($message, $type, $status)
        };
    }
}
