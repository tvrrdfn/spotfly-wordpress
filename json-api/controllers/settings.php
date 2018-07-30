<?php

class JSON_API_Settings_Controller {
	public function my_from() {
		return array(
			"data" => get_option('my-from-info'),
		);
	}
}
?>