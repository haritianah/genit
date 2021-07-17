<?php
/**
 * Created by PhpStorm.
 * User: Haritiana
 * Date: 04/12/2019
 * Time: 21:33
 */

class prof extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('model_prof');
        $this->load->model('model_matiere');
    }

    public function index()
    {
        $data['title'] = 'Paramètre prof';

        $this->template->view('settings/prof/index',$data);
    }

    public function insert()
    {
        $data['title'] = 'Insérer un prof';
        $matiereList = $this->model_matiere->get_allMatiere();
        $data['matieres'] = $matiereList;
        $this->template->view('settings/prof/insert',$data);
    }

    public function q_insert()
    {
        $error = array();
        //Check user
        $countUser = $this->db->get_where('login',array('user'=>strtolower($_POST['user'])))->num_rows();
        if ($countUser!=0) $error['user'] = 'Ce Profésseur existe déjà';
        //
        if (empty($_POST['nom']) || empty($_POST['prenom'])) $error['nom'] = 'Veuillez saisir le nom et prénom';
        //
        if (empty($_POST['passwd']) || empty($_POST['Cpasswd'])) $error['passwd'] = 'Entrer votre mot de passe puis confirmer';
        if ($_POST['passwd']!= $_POST['Cpasswd']) $error['passwd'] = 'Votre mot de passe n\'est pas identique';
        if (strlen($_POST['passwd'])<8) $error['passwd'] = 'Le mot de passe doit contenir au moins 8 caractères';
        //
        if (!is_numeric($_POST['matiere']) || empty($_POST['matiere'])) $error['matiere'] = 'Entrez une matière';
        //INSERT
        if (empty($error)){
            $this->model_prof->insert($_POST);
        }else{
            $_SESSION['flash']['danger'] = $error;
            redirect('settings/prof/insert');
        }
    }

    public function update()
    {
        $data['title']= 'Modifier un prof';
        $matiereList = $this->model_matiere->get_allMatiere();
        $data['matieres'] = $matiereList;
        $this->template->view('settings/prof/update',$data);
    }

    public function q_update()
    {
        $error = array();
        $countUser = $this->db->get_where('login',array('user'=>strtolower($_POST['user'])))->num_rows();
        if ($countUser!=1) $error['user'] = 'Ce Profésseur n\'existe pas';
        if (strtolower($_POST['user'])=='admin') $error['user'] = 'Ce compte n\'est pas un prof';
        //
        if (empty($_POST['nom']) || empty($_POST['prenom'])) $error['nom'] = 'Veuillez saisir le nom et prénom';
        //
        if (empty($_POST['passwd']) || empty($_POST['Cpasswd'])) $error['passwd'] = 'Entrer le mot de passe puis confirmer';
        if ($_POST['passwd']!= $_POST['Cpasswd']) $error['passwd'] = 'le mot de passe n\'est pas identique';
        if (strlen($_POST['passwd'])<8) $error['passwd'] = 'Le mot de passe doit contenir au moins 8 caractères';
        //
        if (!is_numeric($_POST['matiere']) || empty($_POST['matiere'])) $error['matiere'] = 'Entrez une matière';
        //INSERT
        if (empty($error)){
            $this->model_prof->update($_POST);
        }else{
            $_SESSION['flash']['danger'] = $error;
            redirect('settings/prof/update');
        }
        debug($_POST);
    }
}