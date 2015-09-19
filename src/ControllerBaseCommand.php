<?php

namespace YiiTactician;


abstract class ControllerBaseCommand
{
    /**
     * Command params
     * @var array
     */
    public $params;

    /**
     * Default handle method
     * @var string
     */
    protected $_handleMethod;

    /**
     * @param array $params
     * @param string $handleMethod
     */
    public function __construct($params = [], $handleMethod = 'handle')
    {
        $this->params = $params;
        $this->_handleMethod = $handleMethod;
    }

    /**
     * @return string
     */
    public function getHandlerMethod()
    {
        return $this->_handleMethod;
    }

    /**
     * @param $methodName
     */
    public function setHandlerMethod($methodName)
    {
        $this->_handleMethod = $methodName;
    }
}