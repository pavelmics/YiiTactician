<?php

class TestControllerBaseCommandHandler
{
    public function handle($command)
    {
        return TestControllerBaseCommand::EXPECTED_RESULT;
    }

    public function customHandler($command)
    {
        return $this->handle($command);
    }

    public function returnCommandParamsHandler($command)
    {
        return $command->params;
    }

} 