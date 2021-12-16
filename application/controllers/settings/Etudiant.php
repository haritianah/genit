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
        $aetudiantToDel = $this->model_etudiants->get_statut_old();
		$data['etudiantToDel'] = $aetudiantToDel;
		$this->model_etudiants->delete_recursive_old();
		if($this->input->method() == 'post'){
			foreach($aetudiantToDel as $etudiant){
				if ($this->input->post('all') || ($this->input->post('select') && in_array($etudiant->id_etudiant, array_keys($this->input->post('select'))))) {
					$this->db->set('id_etudiant', $etudiant->id_etudiant);
					$this->db->set('num_etudiant', $etudiant->num_etudiant);
					$this->db->set('nom', $etudiant->nom);
					$this->db->set('prenom', $etudiant->prenom);
					$this->db->set('sexe', $etudiant->sexe);
					$this->db->set('naissance', $etudiant->naissance);
					$this->db->set('lieu', $etudiant->lieu);
					$this->db->set('adresse', $etudiant->adresse);
					$this->db->set('telephone', $etudiant->telephone);
					$this->db->set('niveau', $etudiant->niveau);
					$this->db->set('annee_etude', $etudiant->annee_etude);
					$this->db->set('photo', $etudiant->photo);
					$this->db->set('etat', $etudiant->etat);
					$this->db->set('old', $etudiant->old);

					$this->db->insert('oldetudiant');
					$this->db->where('id_etudiant', $etudiant->id_etudiant);
					$this->db->delete('etudiant');
				}
			}
			redirect($_SERVER['REQUEST_URI'], 'refresh');
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
