<?php

namespace Model;

class Role
{
    const ROLE_USER = 'ROLE_USER';
    const ROLE_ADMIN = 'ROLE_ADMIN';
    private $id;
    protected $label;

    public function __construct(string $label)
    {
        $this->setLabel($label);
        return $this;
    }


    public function getId()
    {
        return $this->id;
    }


    /**
     * @return string
     */
    public function getLabel()
    {
        return $this->label;
    }

    /**
     * @param string $label
     * @return Role
     */
    public function setLabel($label)
    {
        $this->label = $label;
        return $this;
    }
}