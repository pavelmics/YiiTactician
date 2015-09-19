<?php

class TestCommand
{
    const EXPECTED_RESULT = 'some-result';
}

class TestCommandWithoutHandler {}

class TestCommandWithoutHandlerMethod {}

class TestControllerBaseCommand extends YiiTactician\ControllerBaseCommand
{
    const EXPECTED_RESULT = 'some-result';
}