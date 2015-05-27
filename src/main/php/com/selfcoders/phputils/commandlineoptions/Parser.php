<?php
namespace com\selfcoders\phputils\commandlineoptions;

class Parser
{
	/**
	 * @var array An array of parsed options
	 */
	private $options = array();

	public function __construct($options)
	{
		$addValueToPreviousOption = false;
		$previousOption = null;

		$options = preg_split("/\s*((?<!\\\\)\"[^\"]*\")\s*|\s+/", $options, -1, PREG_SPLIT_DELIM_CAPTURE | PREG_SPLIT_NO_EMPTY);

		foreach ($options as $option)
		{
			$option = new Option($option);

			if ($addValueToPreviousOption)
			{
				$previousOption->value = $option->value;
				$addValueToPreviousOption = false;
				continue;
			}

			if (!isset($this->options[$option->name]))
			{
				$this->options[$option->name] = array();
			}

			$this->options[$option->name][] = $option;

			if ($option->name and $option->value === "")
			{
				$previousOption = $option;
				$addValueToPreviousOption = true;
			}
		}
	}

	/**
	 * Get an array of options with the given name or the option at the given index.
	 *
	 * @param string $name The name of the option to get
	 * @param int|null $index The index of the option (for multiple options with the same name) or null to get all options
	 *
	 * @return array|Option|null An array containing the Option instances (if index is null), the Option (if index is specified) or null if not found
	 */
	public function getOption($name, $index = null)
	{
		if (!isset($this->options[$name]))
		{
			return null;
		}

		if ($index === null)
		{
			return $this->options[$name];
		}

		if (!isset($this->options[$name][$index]))
		{
			return null;
		}

		return $this->options[$name][$index];
	}

	/**
	 * Get an array of all options.
	 *
	 * @return array An array containing another array for each option name containing all Option instances.
	 */
	public function getOptions()
	{
		return $this->options;
	}
}