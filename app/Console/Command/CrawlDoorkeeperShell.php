<?php
/**
 * AtndのAPIクローラー
 * Created by PhpStorm.
 * User: zaru
 * Date: 2014/01/21
 * Time: 19:25
 */
App::import('Shell', 'Crawl');

class CrawlDoorkeeperShell extends CrawlShell {

	public $uses = array('Event');

	private $api = 'http://api.doorkeeper.jp/events';
	private $serviceId = 'doorkeeper';

	public function main() {
		$this->log("クロール開始", LOG_INFO);

		$data = file_get_contents($this->api);
		$json = json_decode($data);

		foreach ($json as $event) {
			$val = $event->event;
			$capacity = ($val->ticket_limit) ? $val->ticket_limit : 0;
			$applicant = ($val->participants) ? $val->participants : 0;

			$result = $this->Event->findByEventId($this->serviceId . '_' . $val->id);
			if ($result && isset($result['Event']['id'])) {
				$eventId = $result['Event']['id'];
			} else {
				$eventId = null;
			}

			$params = array(
				'id' => $eventId
				, 'event_id' => $this->serviceId . '_' . $val->id
				, 'service_id' => $this->serviceId
				, 'title' => $val->title
				, 'description' => $val->description
				, 'url' => $val->public_url
				, 'date' => date('Y-m-d', strtotime($val->starts_at))
				, 'begin' => date('Y-m-d H:i:s', strtotime($val->starts_at))
				, 'end' => date('Y-m-d H:i:s', strtotime($val->ends_at))
				, 'capacity' => $capacity
				, 'applicant' => $applicant
				, 'pref' => $this->getPrefId($val->address)
				, 'address' => ($val->address) ? $val->address : ''
				, 'place' => ($val->venue_name) ? $val->venue_name : ''
				, 'lat' => ($val->lat) ? $val->lat : ''
				, 'lon' => ($val->long) ? $val->long : ''
				, 'name' => ''
				, 'is_delete' => 0
			);
			$this->Event->save($params);
		}
	}
}