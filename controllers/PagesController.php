<?php

namespace Cookbook\Controllers;


use Cookbook\Core\Application;
use \Cookbook\Core\Request;

class PagesController
{
    public function home()
    {
        $recipes = Application::get('database')->getAll();
        $details = Application::get('database')->getAllFull('all');
        return view('home', compact('recipes', 'details'));
    }

    public function create()
    {
        $ingredients = Application::get('database')->getAll('ingredients');
        $measurements = Application::get('database')->getAll('measurements');
        return view('create', compact('ingredients', 'measurements'));
    }

    public function createnew()
    {
        $this->handleUpload();
        Application::get('database')->addRecipe($_POST);
        return redirect('/');
    }

    public function edit()
    {
        $uri = Request::prepare();
        $uriParts = explode('/', $uri);
        $id = $uriParts[1];

        $recipe = Application::get('database')->getOne('recipes', $id);
        $details = Application::get('database')->getAllFull('one', $id, 'recipe_id');
        $ingredients = Application::get('database')->getAll('ingredients');
        $measurements = Application::get('database')->getAll('measurements');
        return view('edit', compact('recipe', 'details', 'ingredients', 'measurements'));
    }

    public function update()
    {
        $uri = Request::prepare();
        $uriParts = explode('/', $uri);
        $id = $uriParts[1];

        $this->handleUpload();
        Application::get('database')->update($_POST, $id);
        return redirect('/');
    }

    public function destroy()
    {
        $uri = Request::prepare();
        $uriParts = explode('/', $uri);
        $id = $uriParts[1];
        Application::get('database')->destroy($id);
        return redirect('/');
    }

    //TODO: delete this
    public function test()
    {
        $test = Application::get('database')->getAllFull();
        echo $test;
    }

    private function handleUpload()
    {
        if($_FILES['image']['error'] != 4) {
            $newName = time()."_".$_FILES['image']['name'];
            $_POST['image'] = $newName;
            move_uploaded_file($_FILES['image']['tmp_name'], getcwd()."/views/img/".$newName);
        }
    }
}