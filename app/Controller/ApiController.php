<?php
App::uses('AppController', 'Controller');
/**
 * Created by PhpStorm.
 * User: hiro
 * Date: 2014/02/03
 * Time: 22:14
 *
 * @property Event $Event
 */
class ApiController extends AppController {

	public $uses = array('Event');

	/**
	 * @param int $start
	 */
	public function search() {

		$limit = 20;
		if (isset($this->request->query['start']) && $this->request->query['start'] > 1) {
			$start = $this->request->query['start'] - 1;
		} else {
			$start = 0;
		}

		$this->viewClass = 'Json';

		$params = array(
			'conditions' => array(),
			'limit' => $limit,
			'offset' => $start,
			'order' => 'begin asc',
		);
		$result = $this->Event->find('all', $params);
		$this->set(compact('result'));
		$this->set('_serialize', 'result');
	}
}