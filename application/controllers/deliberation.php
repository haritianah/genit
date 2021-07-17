<?php


class deliberation extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		app::connect(true);
	}

	public function index()
	{
		$this->template->view('deliberation');
	}

	public function special()
	{
		$this->load->model('model_note');
		$data['title']="Notes 10.01";

		$data['results'] = $this->model_note->get_noteParam(array('notes'=>10.01,'notes.annee_etude'=>$_SESSION['annee_etude']),true,true);

		$this->template->view('deliberation/special',$data);
	}
}
