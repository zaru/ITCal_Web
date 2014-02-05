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
	 * 勉強会の一覧をJSONで返却する
	 *
	 * @param int $_GET['start'] 閲覧開始数
	 * @param int $_GET['count'] 取得数
	 * @param string $_GET['keyword'] キーワード
	 * @param string $_GET['pref'] 都道府県
	 */
	public function search() {

		$limit = (isset($this->request->query['count'])) ? $this->request->query['count'] : 20;
		if (isset($this->request->query['start']) && $this->request->query['start'] > 1) {
			$start = $this->request->query['start'] - 1;
		} else {
			$start = 0;
		}

		$keyword = (isset($this->request->query['keyword'])) ? $this->request->query['keyword'] : null;
		$pref = (isset($this->request->query['pref']) && $this->request->query['pref'] != 'すべて') ? $this->request->query['pref'] : null;

		$this->viewClass = 'Json';

		$params = array(
			'conditions' => array(
				'date >=' => date('Y-m-d'),
				'is_delete' => 0,
			),
			'limit' => $limit,
			'offset' => $start,
			'order' => 'begin asc',
		);

		if ($keyword) {
			$params['conditions']['OR'] = array(
				'title like' => '%' . $keyword . '%',
				'description like' => '%' . $keyword . '%',
			);
		}

		if ($pref) {
			$params['conditions']['pref'] = $pref;
		}

		$result = $this->Event->find('all', $params);
		foreach ($result as $key => $val) {
			$result[$key]['Event']['description'] = strip_tags($val['Event']['description']);
		}
		$this->set(compact('result'));
		$this->set('_serialize', 'result');
	}
}