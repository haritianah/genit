<?php
class notes extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_fiche');
        $this->load->model('model_note');
        $this->load->model('model_etudiants');
        $this->load->model('model_formulaire');
        $this->load->model('model_matiere');
        app::connect(true);
    }

    public function special()
    {
        $data['title'] = "Insertion spéciale";

        $this->template->view('notes/special', $data);
    }

    public function query_spec()
    {
        $matiere = $this->model_matiere->get_infoMatiere($_POST['mat']);
        if (!empty($_POST['mat']) && is_numeric($_POST['mat']) && ($_POST['session'] == 'normale' || $_POST['session'] == 'rattrapage')){
            if (is_numeric($_POST['note']) && $_POST['note']>= 0 && $_POST['note'] <= 20){
                $param = array("id_etudiant"=>$_POST['id'],"id_matiere"=>$matiere->id_matiere,"id_unite"=>$matiere->id_unite,"notes"=>$_POST['note'],
                    "noteO"=>$_POST['note'],"session"=>$_POST['session'], 'annee_etude'=> $_POST['annee']);
            }
        }
        if (isset($param)){
            $this->model_note->insert_note($param);
            $data['result'] = "Note insérée";
            $data['type'] = 'success';
        }else{
            $data['result'] = "Erreur";
            $data['type'] = 'danger';
        }
        echo json_encode($data);

    }
    public function insert($niveau="",$idunit="")
    {
        $data['niveau']=$niveau;
        $data['title']="Insertion notes ".$niveau;
        $data['unites']= $this->model_fiche->get_unite($niveau);
        $data['idunit'] = $idunit;
        if (!empty($idunit)){
            $mat = $this->model_fiche->get_matiere($idunit);
            $data['unite'] = $this->model_matiere->get_infoUnite($idunit);
            $data['matieres']=$mat;
        }
        $this->template->view('notes/insert',$data);
    }
    public function ajax_insert(){
        empty($_POST) ? exit() : true;
        $idunit=$_POST['unit'];
        $idmat=$_POST['matiere'];
        $session=$_POST['session'];
        $annee=$_POST['annee_etude'];
        $niveau = $this->app->getNivByUnite($idunit)->niveau_unite;
        $niveau2 = get_niv2($niveau);
        if ($idmat!=0 && $session!='sel'):
            //calcResmat matiere
            $this->model_note->calc_resmatGlobMatiere($idmat,$annee);
            //DATA VIEWS
            $etudiants = $this->model_etudiants->get_list_etudiant($niveau);
            $data['etudiants']= $etudiants;
            $data['idmat']=$idmat;
            $data['session']=$session;
            $data['idunit']=$idunit;
            $data['niveau']=$niveau;
            $data['annee']=$annee;
            $data['niveau2']=$niveau2;
            $this->load->view('ajax/liste_etudiants',$data);
        endif;
    }
    public function query_insert(){
        empty($_POST) ? exit() : true;
        $idunit=$_POST['unit'];
        $idmat=$_POST['matiere'];
        $session=$_POST['session'];
        $annee=$_POST['annee_etude'];
        $niveau = $this->app->getNivByUnite($idunit)->niveau_unite;
        $niveau2 = get_niv2($niveau);

        if ($idmat!= 0 && $session!= "sel"){
            $etudiants = $this->model_etudiants->get_list_etudiant($niveau);
            $this->model_formulaire->insert_note($etudiants,$_POST,$niveau,$niveau2);
        }
    }

    public function show($niveau='')
    {
        if (!empty($niveau)){
            $data['niveau']= $niveau;
            $data['matieres']= $this->model_matiere->get_listMatiere($niveau);
        }
        $data['title']= "Affichage notes ".$niveau;
        $this->template->view('notes/show',$data);
    }

    public function ajax_show()
    {
       $data['notes'] =$this->model_note->get_listeNoteEtudiant($_POST);
       $data['nomat']= $_POST['nomat'];
       $this->load->view('ajax/liste_note',$data);
    }

    public function update($niveau ='',$code='')
    {
        if ($niveau==='code' && $code!=''){
            $note = $this->model_note->get_noteByCode($code);
            $resmat = $this->model_note->get_resmatByMatiere($note->id_etudiant,$note->id_matiere);
            $data['title'] = 'Modifer note n°'.$code;
            $data['matiere']= $this->model_matiere->get_infoMatiere($note->id_matiere);
            $data['etudiant'] = $this->model_etudiants->get_info_etudiant($note->id_etudiant);
            $data['note'] = $note;
            $data['resmat'] = $resmat;
            $data['code'] = $code;
            $this->template->view('notes/update',$data);
        }else{
            if (!empty($niveau)){
                $data['niveau']= $niveau;
            }
            $data['title']= "Modifier notes ".$niveau;
            $this->template->view("notes/update",$data);
        }

    }

    public function ajax_update()
    {
        $notes = $this->model_note->get_note($_POST['id'],$_POST['mat'],$_POST['annee']);
        $resmat = $this->model_note->get_resmatByMatiere($_POST['id'],$_POST['mat']);
        $data['notes'] = $notes;
        $data['resmat'] = $resmat;
        $matiere = $this->model_matiere->get_infoMatiere($_POST['mat']);
        $data['matiere']= $matiere;
        if ($matiere->niveau_unite == $_POST['niveau'] && !empty($notes)){
            $this->load->view('ajax/update',$data);
        }

    }

    public function query_update($code)
    {
        empty($_POST) ? exit() : true;
        $action = $_POST['action'];
        $note = $_POST['note'];
        switch ($action){
            case "update":
                debug($this->model_note->update_note($code,$note));
                break;
            case 'updateJson':
                $this->model_note->update_note($code,$note,true);
                break;
            case "delib":
                debug($this->model_note->delib_note($code,$note));
                break;
            case "delete":
                debug($this->model_note->delete_note($code,$note));
                break;

        }
    }


}

?>