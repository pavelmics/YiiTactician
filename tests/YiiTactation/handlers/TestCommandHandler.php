<?php


class TestCommandHandler
{
	public function handle($command)
    {
        if (!$command instanceof TestCommand) {
            throw new PHPUnit_Framework_AssertionFailedError();
        }
        return TestCommand::EXPECTED_RESULT;
    }
}