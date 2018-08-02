<?php

namespace Cookbook\Database;

/**
 * Class QueryBuilder - it makes queries to database
 */
class QueryBuilder
{
    protected $pdo;

    public function __construct($pdo)
    {
        $this->pdo = $pdo;
    }

    /**
     * returns list of recipes
     */
    public function getAll()
    {
        $query = $this->pdo->prepare("SELECT * FROM `recipes`");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_NAMED );
    }

    /**
     * returns one full recipe
     * @param string $table
     * @param string $id
     */
    public function getOne($table, $id)
    {
        // get all recipe data
        // get all ingredients and amounts on recipe
        $query = $this->pdo->prepare("SELECT * FROM {$table} WHERE id='{$id}'");
        $query->execute();
        // to test
        $q = $this->pdo->prepare("SELECT ingredient_id, ingredient_count FROM `pivot` WHERE recipe_id='{$id}'");
        $q->execute();
//        return $query->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * adds a new recipe to the db
     * @param $payload
     */
    public function addRecipe($payload)
    {
        //TODO: needs to add
        // - one row to recipes
        // - all new ingredients if needed (`for` loop)
        // - connections in pivot table (`for` loop)

        // and $query->debugDumpParams();
    }

    /**
     * updates one recipe
     * @param $payload
     */
    public function update($payload)
    {
        //TODO: may need to update
        // - one row in recipes
        // - connections in pivot table

        // and $query->debugDumpParams();
    }

    /**
     * deletes one recipe
     * @param $recipe_id
     */
    public function destroy($recipe_id)
    {
        $query = $this->pdo->prepare("DELETE FROM `recipes` WHERE id='{$recipe_id}'");
        $query->execute();
        $query->debugDumpParams();
        $q = $this->pdo->prepare("DELETE FROM `pivot` WHERE recipe_id='{$recipe_id}'");
        $q->execute();
        $q->debugDumpParams();
    }
}