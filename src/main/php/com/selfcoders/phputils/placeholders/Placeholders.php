<?php
namespace com\selfcoders\phputils\placeholders;

use ArrayObject;
use com\selfcoders\phputils\placeholders\exception\UndefinedPlaceholderException;

class Placeholders extends ArrayObject
{
    /**
     * @param Placeholder $placeholder
     */
    public function append($placeholder)
    {
        /**
         * @var $thisPlaceholder Placeholder
         */
        foreach ($this as &$thisPlaceholder) {
            if (strtolower($thisPlaceholder->getName()) == strtolower($placeholder->getName())) {
                $thisPlaceholder = $placeholder;
                return;
            }
        }

        parent::append($placeholder);
    }

    /**
     * @param Placeholders $placeholders
     */
    public function appendAll(Placeholders $placeholders)
    {
        /**
         * @var $placeholder Placeholder
         */
        foreach ($placeholders as $placeholder) {
            $this->append($placeholder);
        }
    }

    /**
     * @param string $name
     * @return Placeholder|null
     */
    public function getPlaceholder($name)
    {
        /**
         * @var $thisPlaceholder Placeholder
         */
        foreach ($this as $thisPlaceholder) {
            if (strtolower($thisPlaceholder->getName()) == strtolower($name)) {
                return $thisPlaceholder;
            }
        }

        return null;
    }

    /**
     * @param string $name
     * @return mixed
     * @throws UndefinedPlaceholderException
     */
    public function getValueForPlaceholder($name)
    {
        $placeholder = $this->getPlaceholder($name);
        if ($placeholder === null) {
            throw new UndefinedPlaceholderException($name);
        }

        $value = $placeholder->getValue();
        if ($value instanceof Method) {
            return $value->object->{$value->method}();
        } else {
            return $value;
        }
    }

    /**
     * @param $string
     * @param int $recursions
     * @return mixed
     */
    public function replace($string, $recursions = 0)
    {
        $replacementsDone = 0;

        $string = preg_replace_callback(Placeholder::NAME_REGEX, function ($matches) {
            return $this->getValueForPlaceholder($matches[1]);
        }, $string, -1, $replacementsDone);

        if ($recursions and $replacementsDone) {
            $string = $this->replace($string, $recursions - 1);
        }

        return $string;
    }
}