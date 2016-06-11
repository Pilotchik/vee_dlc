<?php
	function sess_update()
	{
		$CI =& get_instance();
		if ($CI->session->userdata('last_activity')< time() - 300) {
		$CI->session->set_userdata('last_activity', time());
	}
}