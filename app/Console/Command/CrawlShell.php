<?php
/**
 * Created by PhpStorm.
 * User: zaru
 * Date: 2014/01/21
 * Time: 20:11
 */
class CrawlShell extends AppShell {

	/**
	 * @param $address
	 *
	 * @return string
	 */
	public function getPrefId($address) {
		$prefLists = array(
			'北海道','青森県','岩手県','宮城県','秋田県','山形県','福島県','茨城県',
			'栃木県','群馬県','埼玉県','千葉県','東京都','神奈川県','新潟県','富山県',
			'石川県','福井県','山梨県','長野県','岐阜県','静岡県','愛知県','三重県',
			'滋賀県','京都府','大阪府','兵庫県','奈良県','和歌山県','鳥取県','島根県',
			'岡山県','広島県','山口県','徳島県','香川県','愛媛県','高知県','福岡県',
			'佐賀県','長崎県','熊本県','大分県','宮崎県','鹿児島県','沖縄県'
		);
		foreach ($prefLists as $pref) {
			if (preg_match("/" . $pref . "/", $address)) {
				return $pref;
			}
		}
		return '東京都';
	}

	public function isOk($text) {

		$word = array(
			'プログラミング',
			'プログラマ',
			'エンジニア',
			'設計',
			'実装',
			'もくもく',
			'コーディング',
			'デザイン',
			'デザイナ',
			'言語',
			'技術',
			'読書会',
			'ハッカソン',
			'Hack',
			'tech',
			'Webサービス',
			'サーバ',
			'コード',
			'インフラ',
			'devops',
			'ネットワーク',
			'フレームワーク',
			'デザインパターン',
			'Webアプリ',
			'スマホアプリ',
			'ゲームアプリ',
			'ツールアプリ',
			'vim',
			'駆動',
			'framework',
			'開発',
			'CSS',
			'Ruby',
			'Python',
			'Java',
			'Objective-C',
			'クラウド',
			'iPhone',
			'Android',
			'SDK',
		);

		if (preg_match("/(" . implode('|', $word) . ")/i", $text)) {
			if (!$this->isNg($text)) {
				return true;
			}
		}

		return false;

	}

	public function isNg($text) {

		$word = array(
			'出会い',
			'貢献',
			'ボランティア',
			'ビジネス',
			'キャリア',
			'恋愛',
			'結婚',
			'就職',
			'転職',
			'就活',
		);

		if (preg_match("/(" . implode('|', $word) . ")/i", $text)) {
			return true;
		}

		return false;

	}

}