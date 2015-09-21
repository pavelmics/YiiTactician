
#Yii-Tactician
Yii addapter for [this library](https://github.com/thephpleague/tactician)! It provides an easy way to use the command bus pattern in Yii-based apps.

##Installation
You can install Yii-Tactician via composer by running
`composer require pavelmics/yii-tactician`
or add 
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
Then, define a handler class under one of your handlers path (see configuration section of this readme). The name of handler class must be the same as the name of command class suffixed with "Handler". Аor example for class `TestCommand` we need to define `TestCommandHandler` class:

```
class TestCommandHandler
{
	public function handle(TestCommand $command)
    {
    	// do command staff hire!
        // we can use $command->someParam and $this->someOtherParam
    }
}
```
And now we can use this command in controllers (or wherever you want):
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

###Controller based commands
todo



