<?php 
class home extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		// $this->load->model('index_model');
		$this->load->model('model_etudiants');
		$this->db->select('annee_etude');
        $query =$this->db->get('maj');
		$_SESSION['annee_etude']=$query->row()->annee_etude;
		app::connect(true);
	}
	public function index()
	{
		$data['title']="Accueil";
		$this->template->view('home',$data);

	}
	public function liste($niveau="")
	{
		if (!empty($niveau) && in_array($niveau, get_niv())) {
			$list=$this->model_etudiants->get_list_etudiant($niveau,2);
			$data['list']=$list;
			$data['title']="Fiche ". $niveau;
			$data['niveau']=$niveau;
			$this->template->view('home',$data);
		}else{
			show_404();
		}
		
	}
}