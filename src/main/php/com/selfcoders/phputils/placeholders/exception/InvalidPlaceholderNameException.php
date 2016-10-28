<?php
namespace com\selfcoders\phputils\placeholders\exception;

class InvalidPlaceholderNameException extends PlaceholderException
{
    /**
     * @var string
     */
    private $name;

    /**
     * @param string $name
     */
    public function __construct($name)
    {
        $this->name = $name;

        parent::__construct("Invalid placeholder name: " . $name);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }
}