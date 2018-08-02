<?php

namespace Cookbook\Controllers;

use Cookbook\Core\Application;

class ApiController
{
    public function recipes($params = null)
    {
        $recipes = Application::get('database')->getAll();
        echo json_encode($recipes);
        return $recipes;
    }

    public function recipe($params)
    {
        dd($params['id']);
        $recipe = Application::get('database')->getOne('recipes', $params['id']);
        echo json_encode($recipe);
        return json_encode($recipe);
    }

    public function ingredient($params)
    {
        
    }
}