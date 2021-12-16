<?php 
/**
* 
*/
class model_decision extends CI_Model
{
   public function get_by_etudiant_id(Type $var = null)
   {
       # code...
   }

   public function get_decison_by_etudiant($idEtudiant, $niveauEtudiant)
   {
       $this->db->where('id_etudiant', $idEtudiant);
       $this->db->where('niveau_des', $niveauEtudiant);
       $this->db->order_by('code_de','DESC');
       $this->db->limit(1);
       $query = $this->db->get('decision');
       
       return $query->row();
   }

}