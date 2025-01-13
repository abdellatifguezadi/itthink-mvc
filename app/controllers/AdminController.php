<?php
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/categories.php');
require_once(__DIR__ . '/../models/projet.php');
require_once(__DIR__ . '/../models/testo.php');


class AdminController extends BaseController
{
   private $UserModel;
   private $CatModel;
   private $ProjetModel;
   private $testoModel;

   public function __construct()
   {
 
      if (!isset($_SESSION['user_loged_in_id']) || $_SESSION['user_loged_in_role'] != "1") {
         header("Location: /login");
         exit;
      }

      $this->UserModel = new User();
      $this->CatModel = new Category();
      $this->ProjetModel = new projet();
      $this->testoModel = new testo();
   }

   public function index()
   {
      $statistics = $this->UserModel->getStatistics();
      $this->renderDashboard('admin/index', ["statistics" => $statistics]);
   }

   public function categories()
   {

      $this->renderDashboard('admin/categories');
   }
   public function testimonials()
   {

      $this->renderDashboard('admin/testimonials');
   }
   public function projects()
   {

      $this->renderDashboard('admin/projects');
   }

   public function handleUsers()
   {
      // Récupérer les paramètres de filtrage et recherche
      $filter = isset($_GET['filter']) ? trim($_GET['filter']) : 'all';
      $userToSearch = isset($_GET['userToSearch']) ? trim($_GET['userToSearch']) : '';

      // Valider le filtre
      $validFilters = ['all', 'clients', 'freelancers'];
      if (!in_array($filter, $validFilters)) {
         $filter = 'all';
      }

      // Récupérer les utilisateurs filtrés
      $users = $this->UserModel->getAllUsers($filter, $userToSearch);

      // Rendre la vue avec les résultats
      $this->renderDashboard('admin/users', [
         "users" => $users,
         "currentFilter" => $filter,
         "searchTerm" => $userToSearch
      ]);
   }


   public function changeStatus()
   {
      $idUser = $_POST['block_user_id'];
      $this->UserModel->changeStatus($idUser);
      $this->handleUsers();
   }


   public function removeUser()
   {
      $id = $_POST['remove_user'];
      $this->UserModel->removeUser($id);
      $this->handleUsers();
   }


   public function hundelcat()
   {
      $Cat = $this->CatModel->allCategory();
      $this->renderDashboard('admin/categories', ["categories" => $Cat]);
   }

   public function addUpdatCat()
   {

      $this->CatModel->addUpdatCat();
      $this->hundelcat();
   }

   public function addUpdatSubCat()
   {

      $this->CatModel->addUpdatSubCat();
      $this->hundelcat();
   }
   public function deleteCat()
   {

      $this->CatModel->deleteCat();
      $this->hundelcat();
   }
   public function deleteSubCat()
   {

      $this->CatModel->deleteSubCat();
      $this->hundelcat();
   }


   public function handleProjet()
   {
      $filter_by_cat = isset($_GET['filter_by_cat']) ? $_GET['filter_by_cat'] : 'all';
      $filter_by_sub_cat = isset($_GET['filter_by_sub_cat']) ? $_GET['filter_by_sub_cat'] : 'all';
      $projectToSearch = isset($_GET['projectToSearch']) ? $_GET['projectToSearch'] : '';
      $filter_by_status = isset($_GET['filter_by_status']) ? $_GET['filter_by_status'] : '';
      
      $projects = $this->ProjetModel->showProjects($filter_by_cat, $filter_by_sub_cat, $filter_by_status, $projectToSearch);
      $categories = $this->CatModel->allCategory();
      $subcategories = $this->CatModel->getAllSubCategories();
      
      $this->renderDashboard('admin/projects', [
         "projects" => $projects, 
         "categories" => $categories,
         "subcategories" => $subcategories
      ]);
   }

   public function removeProject()
   {
      $idProject = $_POST['id_projet'];
      $this->ProjetModel->removeProject($idProject);
      $this->handleProjet();
   }

   public function handleTesto()
   {
      $testo = $this->testoModel->testimonials();
      $this->renderDashboard('admin/testimonials', ["clientTestimonials" => $testo]);
   }

   public function removeTesto(){
      
      $idtesTimonial = $_POST['id_temoignage'];
      $this->testoModel->removeTesto($idtesTimonial);
      
      $this->handleTesto();
      
   }
}
