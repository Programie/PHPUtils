<?php
namespace com\selfcoders\phputils\placeholders;

class Method
{
    /**
     * @var object
     */
    public $object;
    /**
     * @var string
     */
    public $method;

    /**
     * @param object $object
     * @param string $method
     */
    public function __construct($object, $method)
    {
        $this->object = $object;
        $this->method = $method;
    }
}