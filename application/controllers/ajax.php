<?php

class ajax extends CI_Controller{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_ajax');
        $this->load->model('model_matiere');
        $this->load->library('excel');
    }

    public function search_etudiant()
    {
        empty($_POST) ? exit() :true;
        if (!empty($_POST['id'])):
        $results = $this->model_ajax->search_etudiant($_POST['id']);
        foreach ($results as $result) {
            echo '<ul>';
                echo "<a id='{$result->id_etudiant}' onclick='set_idEtudiant($(this))'><li>{$result->nom} {$result->prenom} ({$result->niveau}) </li></a>";
            echo '</ul>';
        }
        endif;
    }

    public function search_matiere()
    {
        empty($_POST) ? exit() :true;
        if (!empty($_POST['mat'])):
        $results = $this->model_ajax->search_matiere($_POST['mat'],$_POST['niveau']);
        foreach ($results as $result) {
            echo '<ul>';
            echo "<a id='{$result->id_matiere}' onclick='set_idMatiere($(this))'><li> {$result->nom_matiere} {$result->niveau_unite}/{$result->semestre} </li></a>";
            echo '</ul>';
        }
        endif;
    }

    public function resultat_update()
    {
        if (!isset($_POST['resultat'])){
            $this->load->model('model_etudiants');
            $resultat = $this->model_ajax->get_resultatMatiere($_POST['id'],$_POST['mat']);
            $data['resultat'] =$resultat;
            $data['etudiant'] = $this->model_etudiants->get_info_etudiant($_POST['id']);
            $data['matiere'] = $this->model_matiere->get_infoMatiere($_POST['mat']);
            $this->load->view('ajax/resmat_etudiant',$data);
        }else{
            $this->model_ajax->update_resultatMatiere($_POST['id'],$_POST['mat'],$_POST['resultat']);
            die('Succes');
        }
    }

    public function excel_note()
    {
        if (isset($_FILES['excelnote']['name'])){
            $path = $_FILES['excelnote']['tmp_name'];
            $object = PHPExcel_IOFactory::load($path);
            $data['object'] = $object;
            $data['firstRow'] = $_POST['firstRow'];
            $data['noteCol'] = $_POST['notecol'];
//            $data['idCol'] = $_POST['idcol'];
            $data['idCol'] = 'A';
            $this->load->view('excel/note',$data);
        }
    }

    public function insert_etudiant()
    {
        $this->load->model('model_etudiants');
        !isset($_FILES['file']['name']) ? exit() : true;
        $path = $_FILES['file']['tmp_name'];
        $object = PHPExcel_IOFactory::load($path);
        $data['object'] = $object;
        if (isset($_POST['firstline'])){
            $data['firstline'] =1;
        }
        $this->load->view('excel/insert_etudiant',$data);
    }

    public function update_prof()
    {
        $query = $this->db->get_where('login',array('user'=>$_POST['user']));
        echo $query->num_rows() == 1 ? "true" : "false";
    }

    public function edit_unit()
    {
        $result ='';
        //check unit
        $checkUnite = $this->model_matiere->check_unitByNum($_POST['num'],false);
        $chk = $checkUnite->num_rows();
        $unite = $checkUnite->row();
        if ($chk==1 && $_POST['numO'] != $_POST['num']){
            $result = "Ce numéro d'unité existé déjà";
            exit();
        }
        $this->db->set('nom_unite',$_POST['nom']);
        $this->db->set('semestre',$_POST['semestre']);
        $this->db->set('niveau_unite',$_POST['niveau']);

        $this->db->where('id_unite',$unite->id_unite);
        $this->db->update('unites');
        $result = 'Unité modifiée';
        echo $result;
    }

    public function edit_matiere()
    {
        $result = '';
        //check unit
        $checkUnite = $this->model_matiere->check_unitByNum($_POST['num'],false);
        $chk = $checkUnite->num_rows();
        $unite = $checkUnite->row();
        if ($chk==0){
            $result = 'Cette unité n\'existe pas';
            exit();
        }
        if (!is_numeric($_POST['credit'])){
            $result = 'Crédit non valide';
            exit();
        }
        $this->db->set('id_unite',$unite->id_unite);
        $this->db->set('nom_matiere',$_POST['nom']);
        $this->db->set('vol_hor',$_POST['vol']);
        $this->db->set('credit',$_POST['credit']);

        $this->db->where('id_matiere',$_POST['mat']);
        $this->db->update('matiere');
        $result = 'Matière modifiée';
        echo $result;

    }

    private function del_mat($idmat)
    {
        //archive notes
        $sql  = "INSERT INTO oldnotes (id_etudiant,id_matiere,id_unite,notes,noteO,session,annee_etude,lastup) SELECT id_etudiant,id_matiere,id_unite,notes,noteO,session,annee_etude,lastup
from notes where id_matiere=?";
        $this->db->query($sql,array($idmat));

        //archive matiere
        $sql= "insert into oldmatiere(id_matiere,id_unite,nom_matiere,vol_hor,credit) select * from matiere where id_matiere=?";
        $this->db->query($sql,array($idmat));

        //DELETE
        $this->db->where('id_matiere',$idmat);
        $this->db->delete('notes');
        $this->db->where('id_matiere',$idmat);
        $this->db->delete('resultat_matiere');
        $this->db->where('id_matiere',$idmat);
        $this->db->delete('matiere');
    }
    public function delete_matiere()
    {
        $this->del_mat($_POST['mat']);
        //archive unite
        $chkunit = $this->db->get_where('oldunites',array('id_unite'=>$_POST['idunit']))->num_rows();
        if ($chkunit==0){
            $unite = $this->model_matiere->get_infoUnite($_POST['idunit']);
            $this->db->set('id_unite',$unite->id_unite);
            $this->db->set('num_unite',$unite->num_unite);
            $this->db->set('nom_unite',$unite->nom_unite);
            $this->db->set('semestre',$unite->semestre);
            $this->db->set('niveau_unite',$unite->niveau_unite);
            $this->db->insert('oldunites');
        }
        echo $result = 'Matière supprimée';
    }
    public function delete_unit()
    {
        $result ='success';
        //archive unites
        $unite = $this->model_matiere->get_infoUnite($_POST['idunit']);
        $chkunit = $this->db->get_where('oldunites',array('id_unite'=>$unite->id_unite))->num_rows();
        if ($chkunit==0){
            $this->db->set('id_unite',$unite->id_unite);
            $this->db->set('num_unite',$unite->num_unite);
            $this->db->set('nom_unite',$unite->nom_unite);
            $this->db->set('semestre',$unite->semestre);
            $this->db->set('niveau_unite',$unite->niveau_unite);
            $this->db->insert('oldunites');
        }
        //Delete all matiere
        $matieres = $this->model_matiere->get_matiere($unite->id_unite);
        foreach ($matieres as $matiere) {
            $this->del_mat($matiere->id_matiere);
        }
        //Delte unite
        $this->db->where('id_unite',$unite->id_unite);
        $this->db->delete('unites');
        echo $result = 'Unité supprimée';
    }
}