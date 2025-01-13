<?php
require_once(__DIR__ . '/../models/User.php');
require_once(__DIR__ . '/../models/projet.php');
require_once(__DIR__ . '/../models/categories.php');
require_once(__DIR__ . '/../models/offres.php');
require_once(__DIR__ . '/../models/testo.php');


class ClientController extends BaseController
{
    private $UserModel;
    private $ProjetModel;
    private $CatModel;
    private $offresModel;
    private $testoModel;

    public function __construct()
    {
        // Vérifier si l'utilisateur est connecté et est un client
        if (!isset($_SESSION['user_loged_in_id']) || $_SESSION['user_loged_in_role'] != "2") {
            header("Location: /login");
            exit;
        }

        $this->UserModel = new User();
        $this->ProjetModel = new projet();
        $this->CatModel = new Category();
        $this->offresModel = new offres();
        $this->testoModel = new testo();
    }



    public function index()
    {
        $user_id = $_SESSION['user_loged_in_id'];
        $statistics = $this->UserModel->getStatisticsUser($user_id);
        $this->renderDashboard('client/index', ["statistics" => $statistics]);
    }

    public function handleProjetUser()
    {
        $user_id = $_SESSION['user_loged_in_id'];

        $filter_by_cat = isset($_GET['filter_by_cat']) ? $_GET['filter_by_cat'] : 'all';
        $filter_by_sub_cat = isset($_GET['filter_by_sub_cat']) ? $_GET['filter_by_sub_cat'] : 'all';
        $projectToSearch = isset($_GET['projectToSearch']) ? $_GET['projectToSearch'] : '';
        $filter_by_status = isset($_GET['filter_by_status']) ? $_GET['filter_by_status'] : '';
        $projects = $this->ProjetModel->showUserProjects($user_id, $filter_by_cat, $filter_by_sub_cat, $filter_by_status, $projectToSearch);
        $categories = $this->CatModel->allCategory();
        $subcategories = $this->CatModel->getAllSubCategories();
        $this->renderDashboard('client/project', [
            "projects" => $projects,
            "categories" => $categories,
            "subcategories" => $subcategories
        ]);
    }


    public function dropProject()
    {
        $idProject = $_POST['id_projet'];
        $this->ProjetModel->removeProject($idProject);
        $this->handleProjetUser();
    }

    public function addUpdateUserProjet()
    {

        $this->ProjetModel->addUpdateUserProjet();
        $this->handleProjetUser();
    }

    public function handleoffres()
    {
        $offres = $this->offresModel->getOffres();
        
        $id_offre_having_testimonial = $this->offresModel->getClientTestimonialsIds();
        
        $this->renderDashboard('client/offres', [
            "offres" => $offres,
            "id_offre_having_testimonial" => $id_offre_having_testimonial
        ]);
    }

    public function acceptOffres(){
        $idOffres = $_POST['id_offre'];
        $this->offresModel->acceptOffre($idOffres);
        $this->handleoffres();
    }

    public function handleTesto()
    {
        $testo = $this->testoModel->testimonials();
        $this->renderDashboard('client/testimonials', ["clientTestimonials" => $testo]);
    }

    public function addUpdateTesto()
    {
        $commentaire = trim($_POST['commentaire_input']);
        $id_offre = $_POST['offre_id_input'];
        $id_temoignage = empty($_POST['testimonial_id_input']) ? 0 : trim($_POST['testimonial_id_input']);
        $user_id = $_SESSION['user_loged_in_id'];

        $this->testoModel->addOrModifyTestimonial(
            $id_temoignage,
            $commentaire,
            $user_id,
            $id_offre
        );
        
        $this->handleTesto();
    }

    public function removeUserTesto(){
        $id_testo = $_POST['id_temoignage'];
        $this->testoModel->removeTestimonial($id_testo);
        $this->handleTesto();
    }
}
