<?php
use YiiTactician\YiiTacticianCommandBus;

include('TestCommands.php');


class YiiTactitianTest extends CTestCase
{
	public function testComponentExist()
	{
		$this->assertTrue(
			Yii::app()->commandBus instanceof YiiTacticianCommandBus
		);
	}

	public function testCommand()
	{
		Yii::app()->commandBus->handle(new TestCommand());
	}

	/**
	 * @expectedException League\Tactician\Exception\MissingHandlerException
	 */
	public function testCommandWithoutHandler()
	{
		Yii::app()->commandBus->handle(new TestCommandWithoutHandler());
	}

	public function testCommandIsExecuted()
	{
		$mock = $this->getMockBuilder('nonexistant')
			->setMockClassName('TestCommandWithoutHandlerHandler')
			->setMethods(['handle'])
			->disableAutoload()
			->getMock();

		// makes sure that method handle is executed
		$mock->expects($this->once())->method('handle');
		Yii::app()->commandBus->handle(new TestCommandWithoutHandler());
	}
}