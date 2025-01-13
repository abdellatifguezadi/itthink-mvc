<?php
require_once(__DIR__ . '/../config/db.php');
class testo extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    function testimonials() {
        // Base query
        $queryStr = "SELECT p.titre_projet, t.commentaire, t.id_temoignage, o.montant, o.delai, o.id_offre
                    FROM temoignages t
                    JOIN offres o ON t.id_offre = o.id_offre
                    JOIN projets p ON o.id_projet = p.id_projet";

        
        $query = $this->conn->prepare($queryStr);
        $query->execute();

        // Fetch and return results
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function removeTesto($idtesTimonial){
        $removeTestimonial = $this->conn->prepare("DELETE FROM temoignages WHERE id_temoignage=?");
        $removeTestimonial->execute([$idtesTimonial]);
    }
    

    function addOrModifyTestimonial($idTemoignage, $commentaire, $idUtilisateur, $idOffre) {
        if ($idTemoignage == 0) {
            $query = $this->conn->prepare("INSERT INTO temoignages (commentaire, id_utilisateur, id_offre) VALUES (?, ?, ?)");
            $query->execute([$commentaire, $idUtilisateur, $idOffre]);
           
            
        } else { // Modify existing testimonial
            $query = $this->conn->prepare("UPDATE temoignages SET commentaire = ? WHERE id_temoignage = ?");
            $query->execute([$commentaire, $idTemoignage]);
        
            
        }
    }

    function removeTestimonial($idtesTimonial){
        $removeTestimonial = $this->conn->prepare("DELETE FROM temoignages WHERE id_temoignage=?");
        $removeTestimonial->execute([$idtesTimonial]);
    }

}