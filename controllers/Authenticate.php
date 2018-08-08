<?php
 
namespace Cookbook\Controllers;
use \Cookbook\Core\Application;

class Authenticate {
    public function register()
    {
        return view('sign');
    }

    public function createuser()
    {
        // TODO: prevention from repetition
        $credentials = $_POST;
        $credentials['password'] = $this->hash($credentials);
        Application::get('database')->addUser($credentials);
        return redirect('/login');
    }

    private function hash($credentials)
    {
        $password = $credentials['password'];
        $password = crypt($password, '$1$yammy$') . "\n";
        return $password;
    }

    public function login()
    {
        return view('login');
    }

    public function validate()
    {
        $credentials = $_POST;
        $email = $credentials['email'];
        $user = Application::get('database')->getOneUser($email);
        if(!$user){
            return redirect("/login");
        }

        $password = $this->hash($credentials);

        if($password === $user->password) {
            $_SESSION['auth'] = $user;
            return redirect('/');
        }else{
            return redirect('/login');
        }
    }

    public function logout()
    {
        unset($_SESSION["auth"]);
        return redirect('/');
    }

}