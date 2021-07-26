<?php

/**
 * Created by PhpStorm.
 * User: Haritiana
 * Date: 30/11/2019
 * Time: 21:18
 */
class etudiant extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        app::connect();
        $this->load->model('model_etudiants');
    }

    public function insert()
    {
        $data['title'] = "Insertion d'étudiants";
        $this->template->view('settings/etudiant/insert',$data);
    }

    public function update($idet)
    {
        empty($idet) ? exit() : true;
        $etudiant = $this->model_etudiants->get_info_etudiant($idet);
        $data['title']= "Modifier étudiant";
        $data['etudiant'] = $etudiant;
        $this->template->view('settings/etudiant/update',$data);
    }

    public function query_update()
    {
        $this->db->set('nom',strtoupper($_POST['nom']));
        $this->db->set('prenom',ucfirst($_POST['prenom']));
        $this->db->set('sexe',$_POST['sexe']);
        $this->db->set('naissance',$_POST['date']);
        $this->db->set('lieu',$_POST['lieu']);
        $this->db->set('adresse',$_POST['adresse']);
        $this->db->set('telephone',$_POST['phone']);
        $this->db->set('inscrit',$_POST['inscrit']);
        $this->db->where('id_etudiant',$_POST['id']);
        $this->db->update('etudiant');
        echo "SUCCESS";
        redirect("settings/etudiant/update/{$_POST['id']}");
    }

	public function deleteold()
	{
		$data['title'] = 'Supprimer les anciens étudiants';
		$data['etudiantToDel'] = $this->model_etudiants->get_statut_old();
		debug($this->model_etudiants->delete_recursive_old());
		if($this->input->method() == 'post'){
			if ($this->input->post('all')){
				die("dd");
			}elseif($this->input->post('select')){
				debug($this->input->post('select'));
			}
		}

		$this->template->view('settings/etudiant/deleteold', $data);
    }

	public function old($niveau="")
	{
		$data['niveau'] = $niveau;
		$data['title'] = 'Ancien étudiants';
		$data['oldEtudiants'] = $this->model_etudiants->get_old_etudiant($niveau);

		$this->template->view('settings/etudiant/etudiant_old',$data);
    }
}
