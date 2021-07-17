<?php
/**
 * Created by PhpStorm.
 * User: Haritiana
 * Date: 07/12/2019
 * Time: 20:00
 */

class model_matiere extends CI_Model
{
    public function get_listMatiere($niveau)
    {
        $this->db->select('matiere.id_matiere,matiere.nom_matiere');
        $this->db->from("matiere");
        $this->db->join('unites', 'unites.id_unite=matiere.id_unite');
        $this->db->where('niveau_unite',$niveau);
        $query = $this->db->get();
        return $query->result();
    }

    public function get_infoMatiere($idmat)
    {
        $this->db->select('matiere.*,niveau_unite');
        $this->db->from('unites');
        $this->db->join('matiere','unites.id_unite=matiere.id_unite');
        $this->db->where('id_matiere',$idmat);
        $query =$this->db->get();
        return $query->row();
    }
    public function get_allMatiere($result =true)
    {
        $query = $this->db->get('matiere');
        return $result==true ? $query->result() : $query;
    }
    public function get_matiere($unite,$result=true)
    {
        $query= $this->db->get_where('matiere',array('id_unite' => $unite));
        return $result== true ? $query->result() : $query;
    }

    public function get_matiereByNiv($niv='',$result=true)
    {
        $this->db->from('unites');
        $this->db->join('matiere','matiere.id_unite=unites.id_unite');
        $this->db->where('niveau_unite',$niv);
        $query = $this->db->get();
        return $result== true ? $query->result() : $query;
    }
    public function get_unite($niveau,$semestre="",$result=true)
    {
        $this->db->order_by('id_unite','ASC');
        $query = $semestre != "" ? $this->db->get_where('unites', array('niveau_unite' => $niveau, 'semestre' => $semestre))
            : $this->db->get_where('unites', array('niveau_unite' => $niveau));
        return $result == true ? $query->result() : $query;

    }
    public function get_infoUnite($idunit)
    {
        $this->db->where('id_unite',$idunit);
        $query = $this->db->get('unites');
        return $query->row();
    }

    public function check_unitByNum($numunit,$result=true)
    {
        $q = $this->db->get_where('unites',array('num_unite'=>$numunit));
        return $result==true ? $q->row() : $q;
    }

    public function insert_matiere($data)
    {
        $this->db->set('id_unite',$data['idunit']);
        $this->db->set('nom_matiere',$data['mat']);
        $this->db->set('vol_hor',$data['volhor']);
        $this->db->set('credit',$data['cred']);

        $this->db->insert('matiere');
    }

    public function insert_resmatMatiere($etudiants)
    {
        //Get last insert matiere
        $this->db->order_by('id_matiere','DESC');
        $this->db->limit('1');
        $q = $this->db->get('matiere');
        $lastinsert = $q->row();
        foreach ($etudiants as $etudiant) {
            $this->db->set('id_etudiant',$etudiant->id_etudiant);
            $this->db->set('id_matiere',$lastinsert->id_matiere);
            $this->db->set('id_unite',$lastinsert->id_unite);
            $this->db->set('resultat','ACQ');
            $this->db->set('annee_etude',$etudiant->annee_etude);
            $this->db->insert('resultat_matiere');
        }
    }

    public function check_noteMatiere($idmat)
    {
        $result = array();
        $this->db->where('annee_etude',$_SESSION['annee_etude']);
        $this->db->where('session','normale');
        $this->db->where('id_matiere',$idmat);
        $chknorm = $this->db->get('notes')->num_rows();
        $this->db->where('annee_etude',$_SESSION['annee_etude']);
        $this->db->where('session','rattrapage');
        $this->db->where('id_matiere',$idmat);
        $chkrat = $this->db->get('notes')->num_rows();

        if ($chknorm!=0){
            $result['N'] = true;
        }
        if ($chkrat!=0){
            $result['R'] = true;
        }

        return $result;
    }
    
}