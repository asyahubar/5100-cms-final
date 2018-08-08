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
     * @return object
     */
    public function getAll()
    {
        $query = $this->pdo->prepare("SELECT * FROM `recipes`");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_OBJ);
    }

    /**
     * returns one full recipe
     * @param $table
     * @param $id
     * @return object
     */
    public function getOne($table, $id)
    {
        $q = $this->pdo->prepare("SELECT * FROM {$table} WHERE id='{$id}'");
        $q->execute();
        return $q->fetch(\PDO::FETCH_OBJ);
    }

    /**
     * @param string $title
     * @return array|object
     */
    public function getAllwIngredient($title)
    {
        //TODO: fix. Returns only one recipe even if there`s many
        if (strpos($title, '-')) $title = str_replace('-', ' ', $title);
        if (strpos($title, '+')) $title = str_replace('+', ' ', $title);
        if (strpos($title, '_')) $title = str_replace('_', ' ', $title);
        $que = $this->pdo->prepare("SELECT `recipe_id` FROM `pivot` WHERE `ingredient_id` IN (SELECT id FROM `ingredients` WHERE title='{$title}')");
        $que->execute();
        $arr = $que->fetchAll(\PDO::FETCH_NUM);
        foreach ($arr as $key => $line) {
            $arr[$key] = $line[0];
        }
        $arr = implode(",", $arr);
        $q = $this->pdo->prepare("SELECT * FROM `recipes` WHERE id IN ({$arr})");
        $q->execute();
        $result = $q->fetchAll(\PDO::FETCH_ASSOC);
        return $result;
    }

    /**
     * add a user to the database
     * @param array $credentials
     */
    public function addUser($credentials)
    {
        $sql = sprintf("INSERT INTO `users` (%s) VALUES (%s)",
            implode(", ", array_keys($credentials)),
            ":" . implode(", :", array_keys($credentials))
        );
        $query = $this->pdo->prepare($sql);
        $query->execute($credentials);
    }

    /**
     * @param string $email
     * @return object
     */
    public function getOneUser($email)
    {
        $query = $this->pdo->prepare("SELECT * FROM `users` WHERE email='{$email}'");
        $query->execute();
        return $query->fetch(\PDO::FETCH_OBJ);
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