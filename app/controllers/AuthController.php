<?php 
require_once (__DIR__.'/../models/User.php');
class AuthController extends BaseController {
 
    private $UserModel ;
   public function __construct(){

      $this->UserModel = new User();

      
   }

   public function showRegister() {
      
    $this->render('auth/register');
   }
   public function showleLogin() {
      
    $this->render('auth/login');
   }
   
   public function handleRegister(){

      
      if ($_SERVER["REQUEST_METHOD"] == "POST"){
         if (isset($_POST['signup'])) {
            echo "<pre>";
         //   var_dump($_POST);die();

             $full_name = $_POST['full_name'];
             $email = $_POST['email'];
             $role = $_POST['role'];
             $password = $_POST['password'];
             $hashed_password = password_hash($password, PASSWORD_DEFAULT);

             $user = [$full_name, $hashed_password, $email, $role];

             

             $lastInsertId = $this->UserModel->register($user);

             
            
                 $_SESSION['user_loged_in_id'] = $lastInsertId ;
                 $_SESSION['user_loged_in_role'] = $role;
 
                 if ($lastInsertId) {
                     switch ($role) {
                         case "1": // Admin
                             header('Location: /admin');
                             break;
                         case "2": // Client 
                             header('Location: /client');
                             break;
                         case "3": // Freelancer
                             header('Location: /freelancer/dashboard');
                             break;
                         default:
                             header('Location: /login');
                     }
                     exit;
                 }
             
         }
     }
   }
   public function handleLogin(){


      if ($_SERVER["REQUEST_METHOD"] == "POST"){
          if (isset($_POST['login'])) {
              $email = $_POST['email'];
              $password = $_POST['password'];
              $userData = [$email, $password];
              $user = $this->UserModel->login($userData);
              
              if ($user) {
                  $role = $user['role'];
                  $_SESSION['user_loged_in_id'] = $user["id_utilisateur"];
                  $_SESSION['user_loged_in_role'] = $role;
                  $_SESSION['user_loged_in_nome'] = $user['nom_utilisateur'];

                  // Redirection selon le rôle
                  switch ($role) {
                      case "1": // Admin
                          header('Location: /admin');
                          break;
                      case "2": // Client
                          header('Location: /client');
                          break;
                      case "3": // Freelancer
                          header('Location: /freelancer/dashboard');
                          break;
                      default:
                          header('Location: /login');
                  }
                  exit;
              } else {
                  // Gérer l'échec de connexion
                  header('Location: /login?error=invalid_credentials');
                  exit;
              }
          }
      }
 

   }

   public function logout() {

         if (isset($_SESSION['user_loged_in_id']) && isset($_SESSION['user_loged_in_role'])) {
             unset($_SESSION['user_loged_in_id']);
             unset($_SESSION['user_loged_in_role']);
             session_destroy();
            
             header("Location: /login");
             exit;
         }
   //   }
   }

   
   


}