<?php
require_once(__DIR__ . '/../config/db.php');
class User extends Db
{

    public function __construct()
    {
        parent::__construct();
    }

    public function register($user)
    {

        try {
            // Prepare and execute the insertion query
            $result = $this->conn->prepare("INSERT INTO utilisateurs (nom_utilisateur, mot_de_passe, email, role) VALUES (?, ?, ?, ?)");
            $result->execute($user);
            return $this->conn->lastInsertId();
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function login($userData)
    {

        try {
            $result = $this->conn->prepare("SELECT * FROM utilisateurs WHERE email=?");
            $result->execute([$userData[0]]);
            $user = $result->fetch(PDO::FETCH_ASSOC);

            if ($user && password_verify($userData[1], $user["mot_de_passe"])) {


                return  $user;
            }
        } catch (PDOException $e) {
            echo "Error: " . $e->getMessage();
        }
    }

    public function getStatistics()
    {
        $statistics = [];

        // Total number of users
        $query = $this->conn->prepare("SELECT COUNT(*) AS total_users FROM utilisateurs");
        $query->execute();
        $statistics['total_users'] = $query->fetch(PDO::FETCH_ASSOC)['total_users'];

        // Total number of published projects
        $query = $this->conn->prepare("SELECT COUNT(*) AS total_projects FROM projets");
        $query->execute();
        $statistics['total_projects'] = $query->fetch(PDO::FETCH_ASSOC)['total_projects'];

        // Total number of freelancers
        $query = $this->conn->prepare("SELECT COUNT(*) AS total_freelancers FROM utilisateurs WHERE role = '3'");
        $query->execute();
        $statistics['total_freelancers'] = $query->fetch(PDO::FETCH_ASSOC)['total_freelancers'];

        // Number of ongoing offers (status = 2)
        $query = $this->conn->prepare("SELECT COUNT(*) AS ongoing_offers FROM offres WHERE status = 2");
        $query->execute();
        $statistics['ongoing_offers'] = $query->fetch(PDO::FETCH_ASSOC)['ongoing_offers'];

        return $statistics;
    }

    public function getStatisticsUser($user_id)
    {
        $statistics = [
            'total_projects' => 0,
            'ongoing_projects' => 0,
            'total_offers' => 0,
            'total_testimonials' => 0
        ];

        try {
            // Total des projets de l'utilisateur
            $query = $this->conn->prepare("
                SELECT COUNT(*) AS total_projects 
                FROM projets 
                WHERE id_utilisateur = ?");
            $query->execute([$user_id]);
            $statistics['total_projects'] = $query->fetch(PDO::FETCH_ASSOC)['total_projects'];

            // Projets en cours
            $query = $this->conn->prepare("
                SELECT COUNT(*) AS ongoing_projects 
                FROM projets 
                WHERE id_utilisateur = ? 
                AND project_status = 2");
            $query->execute([$user_id]);
            $statistics['ongoing_projects'] = $query->fetch(PDO::FETCH_ASSOC)['ongoing_projects'];

            // Offres reçues
            $query = $this->conn->prepare("
                SELECT COUNT(*) AS total_offers 
                FROM offres o 
                INNER JOIN projets p ON o.id_projet = p.id_projet 
                WHERE p.id_utilisateur = ?");
            $query->execute([$user_id]);
            $statistics['total_offers'] = $query->fetch(PDO::FETCH_ASSOC)['total_offers'];

            // Témoignages
            $query = $this->conn->prepare("
                SELECT COUNT(*) AS total_testimonials 
                FROM temoignages t 
                INNER JOIN offres o ON t.id_offre = o.id_offre 
                INNER JOIN projets p ON o.id_projet = p.id_projet 
                WHERE p.id_utilisateur = ?");
            $query->execute([$user_id]);
            $statistics['total_testimonials'] = $query->fetch(PDO::FETCH_ASSOC)['total_testimonials'];

        } catch (PDOException $e) {
            error_log("Error in getStatisticsUser: " . $e->getMessage());
        }

        return $statistics;
    }

    public function getAllUsers($filter, $userToSearch = '')
    {
        try {
            // Construction de la requête de base
            $query = "SELECT * FROM utilisateurs WHERE role != 1"; // Exclure les admins

            $params = [];

            // Ajout du filtre par rôle
            if ($filter === 'clients') {
                $query .= " AND role = 2";
            } elseif ($filter === 'freelancers') {
                $query .= " AND role = 3";
            }

            // Ajout de la recherche par nom si fournie
            if (!empty($userToSearch)) {
                $query .= " AND (nom_utilisateur LIKE :search OR email LIKE :search)";
                $params[':search'] = "%$userToSearch%";
            }

            $stmt = $this->conn->prepare($query);
            
            // Exécution de la requête avec les paramètres
            $stmt->execute($params);
            
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
            
        } catch (PDOException $e) {
            // Gestion des erreurs
            error_log("Erreur dans getAllUsers: " . $e->getMessage());
            return [];
        }
    }


    function removeUser($idUser)
    {


        $removeProject = $this->conn->prepare('DELETE FROM projets WHERE id_utilisateur = ?');
        $removeProject->execute([$idUser]);
        $removeUser = $this->conn->prepare("DELETE FROM utilisateurs WHERE id_utilisateur=?");
        $removeUser->execute([$idUser]);
        
    }

    function changeStatus($idUser){

        $stmt = $this->conn->prepare("SELECT is_active FROM utilisateurs WHERE id_utilisateur = ?");
        $stmt->execute([$idUser]);
        $currentStatus = $stmt->fetchColumn();

        $changeStatus = $this->conn->prepare("UPDATE utilisateurs SET is_active=? WHERE id_utilisateur=?");
        $changeStatus->execute([$currentStatus==0?1:0,$idUser]);
    }
    
   
}
