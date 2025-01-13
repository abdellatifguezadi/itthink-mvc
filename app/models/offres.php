<?php
require_once(__DIR__ . '/../config/db.php');

class offres extends Db
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getOffres()
    {
        $user_id = $_SESSION['user_loged_in_id'];
        
        $query = $this->conn->prepare("
            SELECT 
                o.delai, 
                o.montant, 
                o.id_offre, 
                o.id_utilisateur, 
                o.id_projet, 
                o.status, 
                p.titre_projet,
                p.id_utilisateur as project_owner_id, 
                u.nom_utilisateur as freelancer_name,
                p.id_projet
            FROM projets p
            LEFT JOIN offres o ON p.id_projet = o.id_projet
            LEFT JOIN utilisateurs u ON o.id_utilisateur = u.id_utilisateur
            WHERE p.id_utilisateur = ?
            AND o.id_offre IS NOT NULL
            ORDER BY o.id_offre DESC
        ");
        
        $query->execute([$user_id]);
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    function acceptOffre($idOffre){
        $acceptOffre = $this->conn->prepare("UPDATE offres
                                        SET status=2
                                        WHERE id_offre=?");
        $acceptOffre->execute([$idOffre]);
    }


    public function getClientTestimonialsIds()
    {
        $user_id = $_SESSION['user_loged_in_id'];
        
            $query = $this->conn->prepare("
                SELECT o.id_offre AS id_offre_having_testimonial
                FROM offres o
                INNER JOIN temoignages t ON t.id_offre = o.id_offre
                WHERE t.id_utilisateur = ?
            ");
            $query->execute([$user_id]);
            return $query->fetchAll(PDO::FETCH_COLUMN, 0);
        
    }
}
