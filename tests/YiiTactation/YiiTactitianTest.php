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
        $this->assertEquals(TestCommand::EXPECTED_RESULT
            , Yii::app()->commandBus->handle(new TestCommand())
        );
	}

	/**
	 * @expectedException League\Tactician\Exception\MissingHandlerException
	 */
	public function testCommandWithoutHandler()
	{
		Yii::app()->commandBus->handle(new TestCommandWithoutHandler());
	}

    /**
     * @expectedException League\Tactician\Exception\CanNotInvokeHandlerException
     */
	public function testCommandWithoutHandlerMethod()
	{
		Yii::app()->commandBus->handle(new TestCommandWithoutHandlerMethod());
	}

    // ControllerBaseCommand

    public function testControllerBaseCommand()
    {
        $this->assertEquals(TestControllerBaseCommand::EXPECTED_RESULT
            , Yii::app()->commandBus->handle(new TestControllerBaseCommand())
        );

        // test existed method method
        $command = new TestControllerBaseCommand([], 'customHandler');
        $this->assertEquals(TestControllerBaseCommand::EXPECTED_RESULT
            , Yii::app()->commandBus->handle($command)
        );

        // test params passing to the commandHandler
        $params = ['test' => 1];
        $command = new TestControllerBaseCommand($params
            , 'returnCommandParamsHandler');
        $result = Yii::app()->commandBus->handle($command);
        $this->assertEquals($params, $result);
    }

    /**
     * @expectedException League\Tactician\Exception\CanNotInvokeHandlerException
     */
    public function testInvokeNotExistedMethodAtControllerBaseCommandHandler()
    {
        Yii::app()->commandBus->handle(new TestControllerBaseCommand(
            []
            , 'notExitsMethod')
        );
    }

}