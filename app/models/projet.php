<?php
require_once(__DIR__ . '/../config/db.php');
class projet extends Db
{
    public function __construct()
    {
        parent::__construct();
    }
    

    public function showProjects($filter_by_cat, $filter_by_sub_cat,$filter_by_status, $projectToSearch = '')
    {

        $query = "SELECT p.id_projet, p.titre_projet, p.description,
                         p.id_categorie, p.id_sous_categorie, p.id_utilisateur,
                         p.project_status, c.nom_categorie AS nom_categorie,
                         sc.nom_sous_categorie AS nom_sous_categorie
                FROM projets p
                JOIN categories c ON c.id_categorie = p.id_categorie
                JOIN sous_categories sc ON sc.id_sous_categorie = p.id_sous_categorie
                WHERE 1=1";

        $params = [];

        
        if ($filter_by_cat !== 'all') {
            $query .= " AND c.nom_categorie = :filter_by_cat";
            $params['filter_by_cat'] = $filter_by_cat;
        }

        
        if ($filter_by_sub_cat !== 'all') {
            $query .= " AND sc.nom_sous_categorie = :filter_by_sub_cat";
            $params['filter_by_sub_cat'] = $filter_by_sub_cat;
        }

       
        if (!empty($filter_by_status) && $filter_by_status !== 'all') {
            $query .= " AND p.project_status = :filter_by_status";
            $params['filter_by_status'] = $filter_by_status;
        }

        
        if ($projectToSearch) {
            $query .= " AND p.titre_projet LIKE :search_term";
            $params['search_term'] = "%$projectToSearch%";
        }

        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        
        $projects = $stmt->fetchAll(PDO::FETCH_ASSOC);
        return $projects;
    }
    function removeProject($idProject){
        $removeProject = $this->conn->prepare("DELETE FROM projets WHERE id_projet=?");
        $removeProject->execute([$idProject]);
    }

    public function showUserProjects($user_id, $filter_by_cat, $filter_by_sub_cat, $filter_by_status, $projectToSearch = '')
    {
        $query = "SELECT p.id_projet, p.titre_projet, p.description,
                         p.id_categorie, p.id_sous_categorie, p.id_utilisateur,
                         p.project_status, c.nom_categorie AS nom_categorie,
                         sc.nom_sous_categorie AS nom_sous_categorie
                FROM projets p
                JOIN categories c ON c.id_categorie = p.id_categorie
                JOIN sous_categories sc ON sc.id_sous_categorie = p.id_sous_categorie
                WHERE p.id_utilisateur = :user_id";  

        $params = [':user_id' => $user_id];

        
        if ($filter_by_cat !== 'all') {
            $query .= " AND c.nom_categorie = :filter_by_cat";
            $params[':filter_by_cat'] = $filter_by_cat;
        }

        
        if ($filter_by_sub_cat !== 'all') {
            $query .= " AND sc.nom_sous_categorie = :filter_by_sub_cat";
            $params[':filter_by_sub_cat'] = $filter_by_sub_cat;
        }

        
        if (!empty($filter_by_status) && $filter_by_status !== 'all') {
            $query .= " AND p.project_status = :filter_by_status";
            $params[':filter_by_status'] = $filter_by_status;
        }

        
        if ($projectToSearch) {
            $query .= " AND p.titre_projet LIKE :search_term";
            $params[':search_term'] = "%$projectToSearch%";
        }

        
        $stmt = $this->conn->prepare($query);
        $stmt->execute($params);

        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function dropProject($idProject){
        $removeProject = $this->conn->prepare("DELETE FROM projets WHERE id_projet=?");
        $removeProject->execute([$idProject]);
    }


    public function addUpdateUserProjet()
    {
        if (isset($_POST["save_project"])) {
            $project_title = trim($_POST["project_title_input"]);
            $project_description = trim($_POST["project_description_input"]);
            $project_category = isset($_POST["project_category_input"]) ? trim($_POST["project_category_input"]) : '';
            $project_subcategory = isset($_POST["project_subcategory_input"]) ? trim($_POST["project_subcategory_input"]) : '';
            $project_id = isset($_POST["project_id_input"]) ? trim($_POST["project_id_input"]) : 0;
            $project_status = isset($_POST["project_status"]) ? trim($_POST["project_status"]) : 1;

            try {
                if ($project_id == 0) {
                    // Add new project
                    $query = $this->conn->prepare("
                        INSERT INTO projets (
                            titre_projet, 
                            description, 
                            id_categorie, 
                            id_sous_categorie, 
                            id_utilisateur,
                            project_status
                        ) VALUES (?, ?, ?, ?, ?, ?)
                    ");
                    
                    $query->execute([
                        $project_title,
                        $project_description,
                        $project_category,
                        $project_subcategory,
                        $_SESSION['user_loged_in_id'],
                        $project_status
                    ]);
                } else {
                    // Update existing project
                    $query = $this->conn->prepare("
                        UPDATE projets 
                        SET titre_projet = ?,
                            description = ?,
                            id_categorie = ?,
                            id_sous_categorie = ?,
                            project_status = ?
                        WHERE id_projet = ? 
                        AND id_utilisateur = ?
                    ");
                    
                    $query->execute([
                        $project_title,
                        $project_description,
                        $project_category,
                        $project_subcategory,
                        $project_status,
                        $project_id,
                        $_SESSION['user_loged_in_id']
                    ]);
                }
                return true;
            } catch (PDOException $e) {
                error_log("Error in addUpdateUserProjet: " . $e->getMessage());
                return false;
            }
        }
        return false;
    }
}
