<?php
namespace com\selfcoders\phputils\commandlineoptions;

class Option
{
    /**
     * @var string
     */
    public $name;
    /**
     * @var string
     */
    public $value;

    public function __construct($option)
    {
        $keyValue = preg_split("/(:|=)/", $option, 2);

        if (count($keyValue) == 2) {
            $this->name = $keyValue[0];
            $this->value = $keyValue[1];
        } else {
            $this->value = $keyValue[0];
        }

        // Quotes are included in the value -> remove them
        if (substr($this->value, 0, 1) == "\"" and substr($this->value, -1) == "\"") {
            $this->value = substr($this->value, 1, -1);
        }
    }
}