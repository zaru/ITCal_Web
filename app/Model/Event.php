<?php
App::uses('AppModel', 'Model');
/**
 * Created by PhpStorm.
 * User: hiro
 * Date: 2014/02/03
 * Time: 22:33
 */
class Event extends AppModel {
	public $name = 'Event';

	public $virtualFields = array(
		'year' => 'date_format(date, "%Y")',
		'day' => 'date_format(date, "%m-%d")',
	);
}
