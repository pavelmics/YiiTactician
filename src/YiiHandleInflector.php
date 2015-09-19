<?php

namespace YiiTactician;

use League\Tactician\Handler\MethodNameInflector\MethodNameInflector;


class YiiHandleInflector implements MethodNameInflector
{
    /**
     * @var string
     */
    private $_defaultHanldeMethodName = 'handle';

    /**
     *
     * @param null $defaultHandleName
     */
    public function __construct($defaultHandleName = null)
    {
        if (is_string($defaultHandleName)) {
            $this->_defaultHanldeMethodName = $defaultHandleName;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function inflect($command, $commandHandler)
    {
        $method = false;
        if (is_callable([$command, 'getHandlerMethod'])) {
            $method = $command->getHandlerMethod();
        }

        return is_string($method) ? $method : $this->_defaultHanldeMethodName;
    }
}