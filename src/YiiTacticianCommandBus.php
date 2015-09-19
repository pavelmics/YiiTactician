<?php

namespace YiiTactician;

use League\Tactician\CommandBus as LeagueCommandBus;
use League\Tactician\Handler\CommandHandlerMiddleware;
use League\Tactician\Handler\CommandNameExtractor\ClassNameExtractor;


class YiiTacticianCommandBus extends \CApplicationComponent
{
	/**
	 * @var array
	 */
	public $handlersPath = ['application.bus_commands'];


	/**
	 * @var \League\Tactician\CommandBus
	 */
	protected $_commandBus;


	/**
	 * @inheritdoc
	 */
	public function init()
	{
		parent::init();

		$handlerMiddleware = new CommandHandlerMiddleware(
			new ClassNameExtractor(),
			new YiiHandlerLocator($this->handlersPath),
			new YiiHandleInflector()
		);

		$this->_commandBus = new LeagueCommandBus([$handlerMiddleware]);
	}

	/**
	 * @inheritdoc
	 */
	public function __call($name, $parameters)
	{
		$callable = [$this->_commandBus, $name];

		if (is_callable($callable)) {
			return call_user_func_array($callable, $parameters);
		} else {
			// if $name is not function of CommandBus,
			// just use regular Yii methods to handle __call
			return parent::__call($name, $parameters);
		}
	}
}