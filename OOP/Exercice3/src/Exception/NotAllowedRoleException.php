<?php
declare(strict_types=1);
namespace Exception;

use Throwable;

class NotAllowedRoleException extends \RuntimeException
{
    public function __construct(array $roles, string $label, string $message = "", int $code = 0, Throwable $previous = null)
    {
        $tmpMessage = 'The role '.$label.' is not allowed';
        $tmpMessage .= 'only '.implode(', ', $roles).' are allowed ';
        $tmpMessage .= $message;

            parent::__construct($tmpMessage, $code, $previous);
    }
}