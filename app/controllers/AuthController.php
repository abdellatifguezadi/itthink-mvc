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

             $user = [$full_name,$hashed_password,$email,$role];

             

             $lastInsertId = $this->UserModel->register($user);

             
            
                 $_SESSION['user_loged_in_id'] = $lastInsertId ;
                 $_SESSION['user_loged_in_role'] = $role;
 
                 if ($lastInsertId && $role == 1) {
                     header('Location: admin/dashboard');
                 } else if ($lastInsertId && $role == 2) {
                     header('Location: client/dashboard');
                 } else if ($lastInsertId && $role == 3) {
                     header('Location: freelancer/dashboard');
                 }                    
                 
                 exit;
             
         }
     }
   }
   public function handleLogin(){


      if ($_SERVER["REQUEST_METHOD"] == "POST"){
          if (isset($_POST['login'])) {
              $email = $_POST['email'];
              $password = $_POST['password'];
              $userData = [$email,$password];
              $user = $this->UserModel->login($userData);
              $role = $user['role'] ; 
            // var_dump($user);die();
              $_SESSION['user_loged_in_id'] = $user["id_utilisateur"];
              $_SESSION['user_loged_in_role'] = $role;
              $_SESSION['user_loged_in_nome'] = $user['nom_utilisateur'];
  
              if ($user && $role == 1) {
                  header('Location: /admin/dashboard');
              } else if ($user && $role == 2) {
                  header('Location: Client/dashboard.php');
              } else if ($user && $role == 3) {
                  header('Location: Freelancer/dashboard.php');
              } 
             
          }
      }
 

   }

   public function logout() {

      
      // if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["logout"])) {
      //  var_dump($_SESSION);die();
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