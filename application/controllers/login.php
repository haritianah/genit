<?php 
/**
* 
*/
class login extends CI_Controller
{
	public function index()
	{
		if (isset($_SESSION['auth'])) {
			redirect('home');
		}
		$this->form_validation->set_rules('user','Username', 'required');
		$this->form_validation->set_rules('pass','Pass', 'required');
		if ($this->form_validation->run()) {
			$username= set_value('user');
			$pass= set_value('pass');
			$req = $this->db->where('user', $username)
							->limit(1)
							->get('login');
			$result = $req->row();
			if($req->num_rows()==1){
				if (password_verify($pass,$result->password)){
					$this->session->set_userdata('auth',$req->row());
					redirect('home');
				}else{
					$this->session->set_flashdata('error', 'Mot de passe incorrect');
				redirect('login');
				}
			}else{
				$this->session->set_flashdata('error', 'Cet utilisateur n\'existe pas');
				redirect('login');
			}
		}else{
			$data['title']="Se connecter";
			$this->template->view('login',$data);
		}
	}
	
}
 ?>
