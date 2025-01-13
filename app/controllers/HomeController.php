<?php 

class HomeController extends BaseController {

   public function index() {
      if(!isset($_SESSION['user_loged_in_id'])) {
         header("Location: /login");
         exit;
      }

      // Rediriger selon le rôle
      switch($_SESSION['user_loged_in_role']) {
         case "1":
            header("Location: /admin");
            break;
         case "2":
            header("Location: /client"); 
            break;
         case "3":
            header("Location: /freelancer/dashboard");
            break;
         default:
            header("Location: /login");
      }
      exit;
   }
}