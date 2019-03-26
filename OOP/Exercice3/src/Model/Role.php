<?php
declare(strict_types=1);

namespace Model;

use Exception\NotAllowedRoleException;

class Role
{
    public const ROLE_USER = 'ROLE_USER';

    public const ROLE_ADMIN = 'ROLE_ADMIN';

    private $id;

    protected $label;

    public function __construct($label)

    {
        if (!in_array($label, [self::ROLE_USER, self::ROLE_ADMIN])) {
            throw new NotAllowedRoleException(
                [self::ROLE_USER, self::ROLE_ADMIN],
                $label
            );
        }
        $this->label = $label;
    }

    public function getId()
    {
        return $this->id;
    }

    public function getLabel()
    {
        return $this->label;
    }

    public function setLabel($label)
    {
        if (!in_array($label, [self::ROLE_USER, self::ROLE_ADMIN])) {
            throw new NotAllowedRoleException(
                [self::ROLE_USER, self::ROLE_ADMIN],
                $label
            );
        }
        $this->label = $label;
        return $this;
    }
}

