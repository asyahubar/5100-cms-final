<?php

namespace Cookbook\Controllers;

use Cookbook\Core\Application;

class ApiController
{
    /**
     * returns and outputs all recipes
     * @return JSON
     */
    public function recipes()
    {
        $recipes = Application::get('database')->getAll();
        $recipes = json_encode($recipes);
        echo $recipes;
        return $recipes;
    }

    public function recipe()
    {
        
    }

    public function ingredient()
    {
        
    }
}