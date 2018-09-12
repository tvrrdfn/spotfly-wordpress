<?php

class JSON_API_Settings_Controller {
	public function my_from() {
		return array(
			"data" => get_option('my-from-info'),
		);
	}

	public function my_video() {
		return array(
			"data" => get_option('my-video-info'),
		);
	}
}
?>