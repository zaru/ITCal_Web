<?php
/**
 * ConnpassのAPIクローラー
 * Created by PhpStorm.
 * User: zaru
 * Date: 2014/01/21
 * Time: 19:25
 */
class CrawlConnpassShell extends AppShell {

	private $api = 'http://connpass.com/api/v1/event/';

	public function main() {
		$this->log("クロール開始", LOG_INFO);

		$data = file_get_contents($this->api);
		$json = json_decode($data);

		foreach ($json->events as $val) {
			$this->log($val->event_id . "\t" . $val->title, LOG_INFO);
		}
	}
}