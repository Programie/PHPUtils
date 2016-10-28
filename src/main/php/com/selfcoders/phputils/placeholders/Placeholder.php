<?php
namespace com\selfcoders\phputils\placeholders;

use com\selfcoders\phputils\placeholders\exception\InvalidPlaceholderNameException;

class Placeholder
{
    const NAME_REGEX = "/\\{\\{([a-zA-Z0-9_\-]+)\\}\\}/";
    const NAME_PREFIX = "{{";
    const NAME_SUFFIX = "}}";

    /**
     * @var string
     */
    private $name;
    /**
     * @var mixed
     */
    private $value;

    /**
     * @param string $name
     * @param mixed $value
     * @throws InvalidPlaceholderNameException
     */
    public function __construct($name, $value)
    {
        if (!self::validate($name)) {
            throw new InvalidPlaceholderNameException($name);
        }

        $this->name = $name;
        $this->value = $value;
    }

    /**
     * @param string $name
     * @return bool
     */
    public static function validate($name)
    {
        return (bool)preg_match(self::NAME_REGEX, self::NAME_PREFIX . $name . self::NAME_SUFFIX);
    }

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @return mixed
     */
    public function getValue()
    {
        return $this->value;
    }
}