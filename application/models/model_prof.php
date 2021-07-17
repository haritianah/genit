<?php
/**
 * Created by PhpStorm.
 * User: Haritiana
 * Date: 04/12/2019
 * Time: 21:40
 */
class model_prof extends CI_Model
{
    public function insert($post)
    {
        $this->db->set('user',$post['user']);
        $this->db->set('nom_user',$post['nom']);
        $this->db->set('prenom_user',$post['prenom']);
        $this->db->set('password',$post['passwd']);
        $this->db->set('id_matiere',$post['matiere']);
        $this->db->insert('login');
        $_SESSION['flash']['success'] = 'Ce professeur a bien été inséré';
        redirect('settings/prof/insert');
    }

    public function update($post)
    {
        $this->db->where('user',$post['user']);
        $this->db->set('nom_user',$post['nom']);
        $this->db->set('prenom_user',$post['prenom']);
        $this->db->set('password',$post['passwd']);
        $this->db->set('id_matiere',$post['matiere']);
        $this->db->update('login');
        $_SESSION['flash']['success'] = 'Ce professeur a bien été modifié';
        redirect('settings/prof/update');
    }
}