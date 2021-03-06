<?php
/**
 * ZusaarのAPIクローラー
 * Created by PhpStorm.
 * User: zaru
 * Date: 2014/01/21
 * Time: 19:25
 */
App::import('Shell', 'Crawl');

class CrawlZusaarShell extends CrawlShell {

	public $uses = array('Event');

	private $api = 'http://www.zusaar.com/api/event/?count=100';
	private $serviceId = 'zusaar';

	public function main() {
		$this->log("クロール開始", LOG_INFO);

		$data = file_get_contents($this->api);
		$json = json_decode($data);

		foreach ($json->event as $val) {
			if (!isset($val->started_at) || !$val->started_at || !$val->address) {
				continue;
			}

			if (!$this->isOk($val->title) || !$this->isOk($val->description)) {
				continue;
			}

			$capacity = ($val->limit) ? $val->limit : 0;

			$result = $this->Event->findByEventId($this->serviceId . '_' . $val->event_id);
			if ($result && isset($result['Event']['id'])) {
				$eventId = $result['Event']['id'];
			} else {
				$eventId = null;
			}

			$params = array(
				'id' => $eventId
				, 'event_id' => $this->serviceId . '_' . $val->event_id
				, 'service_id' => $this->serviceId
				, 'title' => $val->title
				, 'description' => $val->description
				, 'url' => $val->event_url
				, 'date' => date('Y-m-d', strtotime($val->started_at))
				, 'begin' => date('Y-m-d H:i:s', strtotime($val->started_at))
				, 'end' => date('Y-m-d H:i:s', strtotime($val->ended_at))
				, 'capacity' => $capacity
				, 'applicant' => $val->accepted
				, 'pref' => $this->getPrefId($val->address)
				, 'address' => $val->address
				, 'place' => $val->place
				, 'lat' => ($val->lat) ? $val->lat : ''
				, 'lon' => ($val->lon) ? $val->lon : ''
				, 'name' => $val->owner_nickname
				, 'is_delete' => 0
			);
			$this->Event->save($params);
		}
	}
}