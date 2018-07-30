<?php
 
namespace Cookbook\Controllers;
use \Cookbook\Core\Application;

class Authenticate {
    public function signup()
    {
        return view('signup');
    }

    public function createuser(){
        $credentials = $_POST;
        $credentials->password = $this->hash($credentials);
        Application::get('database')->addNew("users", $credentials);
        return redirect('/');
    }
    private function hash($credentials){
        $password = $credentials['password'];
        $password = crypt($password, '$1$rasmusle$') . "\n";
        return $password;
        
    }

    public function login()
    {

        return view('login');
    }
    public function validate(){
        $credentials = $_POST;
        $email = $credentials['email'];
        $user = Application::get('database')->getOneUser("users", $email);
        if(!$user){
            return redirect("/admin/login");
        }

        $password = $this->hash($credentials);

        if($password === $user->password) {
            $_SESSION['auth'] = $user;
            return redirect('/admin/products');
            
        }else{
            return redirect('/admin/login');
        }


    }
    public function logout()
    {
        unset($_SESSION["auth"]);
        return redirect('/');
    }

}