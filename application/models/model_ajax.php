<?php
class model_ajax extends CI_Model{
    public function __construct()
    {
        parent::__construct();
    }
    public function search_etudiant($text)
    {
        $this->db->select('id_etudiant,nom,prenom,niveau');
        $this->db->like('nom',$text);
        $this->db->or_like('prenom',$text);
        $query = $this->db->get('etudiant');
        return $query->result();
    }
    public function search_matiere($text,$niveau='')
    {
        $this->db->select('id_matiere,nom_matiere,niveau_unite,semestre');
        $this->db->like('nom_matiere',$text);
//        $this->db->where('niveau_unite',$niveau);
        $this->db->from('matiere');
        $this->db->join('unites','matiere.id_unite = unites.id_unite');
        $this->db->order_by('nom_matiere','DESC');
        $query = $this->db->get();
        return $query->result();
    }

    public function get_resultatMatiere($idet,$idmat)
    {
        $this->db->where('id_etudiant',$idet);
        $this->db->where('id_matiere',$idmat);
        return $this->db->get('resultat_matiere')->row();
    }

    public function update_resultatMatiere($idet,$idmat,$resultat)
    {
        $this->db->set('resultat',$resultat);
        $this->db->where('id_etudiant',$idet);
        $this->db->where('id_matiere',$idmat);
        $this->db->update('resultat_matiere');
    }
}