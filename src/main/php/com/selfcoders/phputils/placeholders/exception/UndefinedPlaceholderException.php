<?php
namespace com\selfcoders\phputils\placeholders\exception;

class UndefinedPlaceholderException extends PlaceholderException
{
    /**
     * @var string
     */
    private $placeholder;

    /**
     * @param string $placeholder
     */
    public function __construct($placeholder)
    {
        $this->placeholder = $placeholder;

        parent::__construct("Placeholder '" . $placeholder . "' is not defined");
    }

    /**
     * @return string
     */
    public function getPlaceholder()
    {
        return $this->placeholder;
    }
}