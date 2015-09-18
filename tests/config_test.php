<?php

include('../src/YiiTacticianCommandBus.php');
Yii::$classMap['YiiTactician\YiiTacticianCommandBus'] = '../src/YiiTacticianCommandBus.php';
Yii::setPathOfAlias('app', __DIR__);

return [

	'components' => [
		'commandBus' => [
			'class' => 'YiiTactician\YiiTacticianCommandBus',
			'handlersPath' => [
				'app.YiiTactation.handlers'
			]
		],
	],
];