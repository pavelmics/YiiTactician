
#Yii-Tactician
Yii-Tactician is yii addapter for [Tactician command bus library](https://tactician.thephpleague.com/). It provides an easy way to use the command bus pattern in Yii-based apps.

##Installation
You can install Yii-Tactician via composer by running
`composer require pavelmics/yii-tactician`
or just add 
`"pavelmics/yii-tactician": "0.1.1"`
to your composer.json file.

##Configuration
Once the library is installed, modify your application configuration as follows:
```
return [
	...
	'components' => [
    	...
		'commandBus' => [
    		'class' => 'YiiTactician\YiiTacticianCommandBus',
        ],
    ],
    ...
];
```
By default Yii Tactician uses bus_commands directory for storing command handlers, you can change this by configuring `handlersPath` with array of yii-aliases as follow:
```
return [
	...
	'components' => [
    	...
		'commandBus' => [
    		'class' => 'YiiTactician\YiiTacticianCommandBus',
            'handlersPath' => [
            	'application.command_bus.handlers',
                'appliction.modules.command_bus',
            ],
        ],
    ],
    ...
];
```
NOTE: don't use \* aliases, your aliases must point to a dirrectory but not a file!
NOTE2: Also you have to use psr-4 autoload system to use Yii-Tactician (just add `require('path/to/vendor/autoload.php');` to your index.php and console.php).


##Usage

###Basic
Define a command class somewhere in your application, for example:
```
class TestCommand 
{
	public $someParam;
    public $someOtherParam;
    
    public function __construct($someParam, $someOtherParam = 'defaultValue') 
    {
    	$this->someParam = $someParam;
        $this->someOtherParam = $someOtherParam;
    }
}
```
Then, define a handler class under one of your handlers path (see configuration section of this readme). The name of handler class must be the same as the name of command class suffixed with "Handler". For example for class `TestCommand` we need to define `TestCommandHandler` class:

```
class TestCommandHandler
{
	public function handle(TestCommand $command)
    {
    	// do command stuff hire!
        // we can use $command->someParam and $this->someOtherParam
    }
}
```
Now we can use this command in controllers (or wherever you want):
```
...
public function actionCreateSomething()
{
	$someParam = Yii::app()->request->getPost('some_param');
	$command = new TestCommand($someParam);
    $result = Yii::app()->commandBus->handle($command);
    if ($result) {
    	$this->redirect(
        	Yii::app()->createUrl('something/show', ['id' => $result->id])
        );
    } else {
    	$this->render('errorSomething');
    }
}
```

###Controller based handlers
Sometimes we need handle one command in several different ways. Let's say we need to register users. Sometimes users register by email and sometimes by phone number. We need to handle register command almost the same but at the same time a bit different.
To achive this we can define several handler-functions in handler class (like in standart Yii controller). For example:
```
class RegisterCommandHandler
{
	public function byPhone($command)
    {/* code to register by phone */}
    
    public function byEmail($command)
    {/* code to register by email */}
}
```
And then use `YiiTactician\ControllerBaseCommand` to define your command class:
```
class RegisterCommand extends YiiTactician\ControllerBaseCommand 
{}
```
Now you can do something like this:
```
$params = ['email' => 'test@test.com', 'password' => 'pass'];
$command = new RegisterCommand($params, 'byEmail');
\Yii::app()->commandBus->handle($command);

// or
$params = ['phone' => '99-99-99-99'];
$command = new RegisterCommand($params);
$command->setHandlerMethod('byPhone');
\Yii::app()->commandBus->handle($command);
```