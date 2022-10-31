<?php
/**
 *
*/
class fiche extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		$this->load->model('model_fiche');
		$this->load->model('model_etudiants');
		$this->load->model('model_note');
        app::connect(true);
	}

    public function original($id)
	{
		$id = urldecode($id);
        $etudiant = $this->model_etudiants->get_info_etudiant($id);
        nonInscrit($etudiant->inscrit);
        // Main variables
		$data['id_etudiant'] = $id;
        $data['etudiant']= $etudiant;
        $data['sexe']=$this->model_etudiants->get_sexe_etudiant($etudiant->sexe,$etudiant->nom,$etudiant->prenom);
        $data['title']="Fiche ".ucfirst($etudiant->prenom);
        $data['semestres']=$this->model_fiche->get_semestre($etudiant->niveau);
        $data['countsem']=1;
        // Variable fiche notes
        $data['arrNote']=$this->model_fiche->get_array($etudiant,$etudiant->niveau);
        //Calc resultat matiere
        $this->model_note->calc_resmatEtd($etudiant);
        //Reset old etudiant
        $this->model_fiche->resetSessExpire($id);

		$this->template->view('fiche/fiche',$data);
	}
	public function recherche($id,$niveau)
	{
		$id = urldecode($id);
		$data['id_etudiant']=$id;
	    $data['niveau']=$niveau;
        $etudiant = $this->model_etudiants->get_info_etudiant($id);
        nonInscrit($etudiant->inscrit);
        // Main variables
        $data['id_etudiant'] = $id;
        $data['etudiant']= $etudiant;
        $data['sexe']=$this->model_etudiants->get_sexe_etudiant($etudiant->sexe,$etudiant->nom,$etudiant->prenom);
        $data['title']="Fiche (rt) ".ucfirst($etudiant->prenom);
        $data['semestres']=$this->model_fiche->get_semestre($niveau);
        $data['countsem']=1;
        // Variable fiche notes
        $data['arrNote']=$this->model_fiche->get_array($etudiant,$niveau,true);
        //Calc resultat matiere
        $this->model_note->calc_resmatEtd($etudiant);

        $this->template->view('fiche/fiche_r',$data);
	}
	public function old($id,$niveau="")
	{
		$id = urldecode($id);
		$data['id_etudiant']=$id;
        $data['niveau']=$niveau;
        $etudiant = $this->model_etudiants->get_info_etudiant($id,"oldetudiant");
        // Main variables
        $data['id_etudiant'] = $id;
        $data['etudiant']= $etudiant;
        $data['sexe']=$this->model_etudiants->get_sexe_etudiant($etudiant->sexe,$etudiant->nom,$etudiant->prenom);
        $data['title']="Fiche ancien ".ucfirst($etudiant->prenom);
        $data['semestres']=$this->model_fiche->get_semestre($niveau);
        $data['countsem']=1;
        // Variable fiche notes
        $data['arrNote']=$this->model_fiche->get_array($etudiant,$niveau,true);


        $this->template->view('fiche/fiche_o',$data);
	}

    public function pdf($id,$niveau)
    {
		$id = urldecode($id);
		$data['id_etudiant']=$id;
        $data['niveau']=$niveau;
        $etudiant = $this->model_etudiants->get_info_etudiant($id);
        // Main variables
        $data['id_etudiant'] = $id;
        $data['etudiant']= $etudiant;
        $data['sexe']=$this->model_etudiants->get_sexe_etudiant($etudiant->sexe,$etudiant->nom,$etudiant->prenom);
        $data['title']="Fiche ancien ".ucfirst($etudiant->prenom);
        $data['semestres']=$this->model_fiche->get_semestre($niveau);
        $data['countsem']=1;
        // Variable fiche notes
        $data['arrNote']=$this->model_fiche->get_array($etudiant,$niveau,true);


        $this->template->view('fiche/pdf',$data);
    }
}

 ?>
