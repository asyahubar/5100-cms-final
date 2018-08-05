<?php

namespace Cookbook\Controllers;

use Cookbook\Core\Application;

class ApiController
{
    /**
     * @return JSON
     */
    public function recipes()
    {
        $recipes = Application::get('database')->getAll();
        echo json_encode($recipes);
        return $recipes;
    }

    /**
     * @param $params
     * @return JSON
     */
    public function recipe($params)
    {
        $recipe = Application::get('database')->getOne('recipes', $params);
        echo json_encode($recipe);
        return json_encode($recipe);
    }

    /**
     * @param $params
     * @return JSON
     */
    public function ingredient($params)
    {
        $recipe = Application::get('database')->getAllwIngredient($params);
        echo json_encode($recipe);
        return json_encode($recipe);
    }
}