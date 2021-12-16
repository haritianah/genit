<?php 
/**
* 
*/
class template
{
	public function view($views,$data=array())
	{
		$ci = &get_instance();
		$ci->load->view('template/header',$data);
		$ci->load->view($views,$data);
		// $ci->load->view('template/footer', $data);

	}
}

 ?>