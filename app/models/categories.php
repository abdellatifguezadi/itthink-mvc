<?php
require_once(__DIR__ . '/../config/db.php');
class Category extends Db{
    public function __construct()
    {
        parent::__construct();
    }
    public function allCategory(){
        try {
            $query = $this->conn->prepare("
                SELECT 
                    c.id_categorie,
                    c.nom_categorie,
                    sc.id_sous_categorie,
                    sc.nom_sous_categorie
                FROM 
                    categories c
                LEFT JOIN 
                    sous_categories sc ON c.id_categorie = sc.id_categorie
            ");
            $query->execute();
            $results = $query->fetchAll(PDO::FETCH_ASSOC);
    
            $categories = [];
            foreach ($results as $row) {
                $id_categorie = $row['id_categorie'];
    
                // Initialize category if not present
                if (!isset($categories[$id_categorie])) {
                    $categories[$id_categorie] = [
                        'id_categorie' => $id_categorie,
                        'nom_categorie' => $row['nom_categorie'],
                        'sous_categories' => []
                    ];
                }
    
                // Add subcategories
                if (!empty($row['id_sous_categorie'])) {
                    $categories[$id_categorie]['sous_categories'][] = [
                        'id_sous_categorie' => $row['id_sous_categorie'],
                        'nom_sous_categorie' => $row['nom_sous_categorie']
                    ];
                }
            }
    
            return $categories;
    
        } catch (PDOException $e) {
            echo "Database Error: " . $e->getMessage();
            return [];
        }
    }

    public function addUpdatCat(){
        $category_name = trim($_POST["category_name_input"]);
        $category_id = isset($_POST["category_id_input"]) ? trim($_POST["category_id_input"]) : '';

        if (!empty($category_name)) {
            // create a new category if id not gived
            if($category_id==0){
                try {
                    $AddCategoryQuery = $this->conn->prepare("INSERT INTO categories (nom_categorie) VALUES (:category_name)");
                    $AddCategoryQuery->execute([':category_name' => $category_name]);

                } catch (PDOException $e) {
                    echo "Database Error: " . $e->getMessage();
                }
            }
            // modify category if id gived
            else{
                try {
                    $modifyCategoryQuery = $this->conn->prepare("UPDATE categories SET nom_categorie = ? WHERE id_categorie = ?");
                    $modifyCategoryQuery->execute([$category_name,$category_id]);

                } catch (PDOException $e) {
                    echo "Database Error: " . $e->getMessage();
                }
            }
            
        } 
    }
    public function addUpdatSubCat(){

        $subcategory_name = trim($_POST["subcategory_name_input"]);
                $category_id = $_POST["category_parent_id_input"];
                $subcategory_id = (int)trim($_POST["subcategory_id_input"]);
                
    
                if (!empty($subcategory_name)) {
                    // create a new subcategory if id not gived
                    if($subcategory_id==0){
                        try {
                            $AddSubCategoryQuery = $this->conn->prepare("INSERT INTO sous_categories (nom_sous_categorie, id_categorie) VALUES (:subcategory_name, :category_id)");
                            $AddSubCategoryQuery->execute([':subcategory_name' => $subcategory_name,':category_id' => $category_id]);
    
        
                        } catch (PDOException $e) {
                            echo "Database Error: " . $e->getMessage();
                        }
                    }
                    // modify subcategory if id gived
                    else{
                        try {
                            $modifySubCategoryQuery = $this->conn->prepare("UPDATE sous_categories SET nom_sous_categorie = ? WHERE id_sous_categorie = ?");
                            $modifySubCategoryQuery->execute([$subcategory_name,$subcategory_id]);
        
                        } catch (PDOException $e) {
                            echo "Database Error: " . $e->getMessage();
                        }
                    }
                    
                } 
    
    }

    public function deleteCat(){

        $id_categorie=$_POST['id_categorie'];

        $deleteCategorieQuery=$this->conn->prepare("DELETE FROM categories WHERE id_categorie=?");
        $deleteCategorieQuery->execute([$id_categorie]);

    }
    public function deleteSubCat(){
        $id_sous_categorie=$_POST['id_sub_categorie'];

        $deleteSubCategorieQuery=$this->conn->prepare("DELETE FROM sous_categories WHERE id_sous_categorie=?");
        $deleteSubCategorieQuery->execute([$id_sous_categorie]);
    }

    public function getAllSubCategories()
    {
        try {
            $query = $this->conn->prepare("SELECT * FROM sous_categories ORDER BY nom_sous_categorie");
            $query->execute();
            return $query->fetchAll(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            error_log("Error in getAllSubCategories: " . $e->getMessage());
            return [];
        }
    }
}

