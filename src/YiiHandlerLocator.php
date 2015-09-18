<?php

namespace YiiTactician;

use League\Tactician\Handler\Locator\HandlerLocator;
use League\Tactician\Exception\MissingHandlerException;


class YiiHandlerLocator implements HandlerLocator
{
	private $_handlersPath;

	protected $_postfix = 'Handler';

	public function __construct(array $handlersPaths)
	{
		$this->_handlersPath = $handlersPaths;

	}

	/**
	 * @inheritdoc
	 */
	public function getHandlerForCommand($commandName)
	{
		$class = $commandName . $this->_postfix;

		if ($this->_loadCommandClass($class)) {
			return new $class();
		}

		throw new MissingHandlerException();
	}

	/**
	 * Uses regular Yii::import to load the command class
	 *
	 * @param $class
	 * @return bool - whether the handler class was found
	 */
	protected function _loadCommandClass($class)
	{
		$result = false;
		if (class_exists($class, false)) {
			$result = true;
		} else {
			foreach($this->_handlersPath as $p) {
				$alias = $p . '.' . $class;
				if (is_file(\Yii::getPathOfAlias($alias).'.php')) {
					\Yii::import($alias, true);
					$result = true;
				}
			}
		}

		return $result;
	}
}