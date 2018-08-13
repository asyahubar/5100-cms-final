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
     * returns list of recipes by default
     * @param string $table
     * @return object
     */
    public function getAll($table = 'recipes')
    {
        $query = $this->pdo->prepare("SELECT * FROM {$table}");
        $query->execute();
        return $query->fetchAll(\PDO::FETCH_ASSOC);
    }

    /**
     * returns one full recipe
     * @param string $table
     * @param string|integer $idValue
     * @param string $idTitle
     * @return array
     */
    public function getOne($table, $idValue, $idTitle = 'id')
    {
        $q = $this->pdo->prepare("SELECT * FROM {$table} WHERE {$idTitle}='{$idValue}'");
        $q->execute();
        return $q->fetch(\PDO::FETCH_ASSOC);
    }

    /**
     * @param string $table
     * @param string|integer $idValue
     * @param string $idTitle
     * @return mixed
     */
    public function getMany($table, $idValue, $idTitle = 'id')
    {
        $q = $this->pdo->prepare("SELECT * FROM {$table} WHERE {$idTitle} IN ({$idValue})");
        $q->execute();
        return $q->fetchAll(\PDO::FETCH_ASSOC);
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
        $ingredient = $this->getOne('ingredients', $title, 'title');
        $que = $this->pdo->prepare("SELECT `recipe_id` FROM `pivot` WHERE `ingredient_id` IN ($ingredient)");
        $que->execute();
        $arr = $que->fetchAll(\PDO::FETCH_NUM);
        foreach ($arr as $key => $line) {
            $arr[$key] = $line[0];
        }
        $arr = implode(",", $arr);
        $result = $this->getOne('recipes', $arr);
        return $result;
    }

    /**
     * @param string $type
     * @param string $idValue
     * @param string $idTitle
     * @return array|object
     */
    public function getAllFull($type, $idValue = '', $idTitle = '')
    {
        switch ($type) {
            case 'one':
                $pivot = $this->getMany('pivot', $idValue, $idTitle);
                break;
            case 'all':
                $pivot = $this->getAll('pivot');
                break;
            default:
                dd('There is some problem in the first `type` argument');
        }
        $ingredientIds = [];
        $measurementIds = [];
        foreach ($pivot as $key => $val) {
            $ingredientIds[] = $val['ingredient_id'];
            $measurementIds[] = $val['measurement_id'];
        }
        $ingredientIds = implode(",", $ingredientIds);
        $measurementIds = implode(",", $measurementIds);
        $ingredients = $this->getMany('ingredients', $ingredientIds);
        $measurements = $this->getMany('measurements', $measurementIds);
        for ($i = 0; $i < count($pivot); $i++) {
            for ($x = 0; $x < count($ingredients); $x++) {
                if ($pivot[$i]['ingredient_id'] === $ingredients[$x]['id']) {
                    $pivot[$i]['ingredient_title'] = $ingredients[$x]['title'];
                }
            }
            for ($x = 0; $x < count($measurements); $x++) {
                if ($pivot[$i]['measurement_id'] === $measurements[$x]['id']) {
                    $pivot[$i]['measurement_title'] = $measurements[$x]['title'];
                }
            }
        }
        return $pivot;
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
     * @param array $data
     */
    public function addRecipe($data)
    {
        $title = $data['title'];
        $time = $data['time_preparing'];
        $instructions = $data['instructions'];
        $image = isset($data['image']) ? $data['image'] : "";
        $q = $this->pdo->prepare("INSERT INTO `recipes` SET title='{$title}', time_preparing={$time}, instructions='{$instructions}', image='{$image}'");
        $q->execute();
        $qq = $this->pdo->prepare("SELECT * FROM recipes ORDER BY ID DESC LIMIT 1");
        $qq->execute();
        $recipeId = $qq->fetch(\PDO::FETCH_NUM);
        $measurements = [];
        $ingredientCount = [];
        $ingredients = [];
        foreach ($data as $key => $value) {
            if (substr($key, 0, -1) == 'ingredient_count') {
                $n = substr($key, -1);
                $ingredientCount[$n] = $value;
            } elseif (substr($key, 0, -2) == 'ingredient_count') {
                $n = substr($key, -2);
                $ingredientCount[$n] = $value;
            }
            if (substr($key, 0, -1) == 'measurement') {
                $n = substr($key, -1);
                $measurements[$n] = $value;
            } elseif (substr($key, 0, -2) == 'measurement') {
                $n = substr($key, -2);
                $measurements[$n] = $value;
            }
            if (substr($key, 0, -1) == 'ingredient') {
                $n = substr($key, -1);
                $ingredients[$n] = $value;
            } elseif (substr($key, 0, -2) == 'ingredient') {
                $n = substr($key, -2);
                $ingredients[$n] = $value;
            }
        }
        for ($i = 0; $i < count($measurements); $i++) {
            $qu = $this->pdo->prepare("INSERT INTO `pivot` SET recipe_id={$recipeId[0]}, ingredient_id={$ingredients[$i]}, measurement_id={$measurements[$i]}, ingredient_count={$ingredientCount[$i]}");
            $qu->execute();
            $qu = '';
        }
    }

    /**
     * updates one recipe
     * @param array $data
     * @param integer $id
     */
    public function update($data, $id)
    {
        //TODO: may need to update
        $title = $data['title'];
        $time = $data['time_preparing'];
        $instructions = $data['instructions'];
        $image = isset($data['image']) ? $data['image'] : "";
        if ($image === "") {
            $q = $this->pdo->prepare("UPDATE `recipes` SET title='{$title}', time_preparing={$time}, instructions='{$instructions}'  WHERE id='{$id}'");
            $q->execute();
        } else {
            $q = $this->pdo->prepare("UPDATE `recipes` SET title='{$title}', time_preparing={$time}, instructions='{$instructions}', image='{$image}'  WHERE id='{$id}'");
            $q->execute();
        }
        $qq = $this->pdo->prepare("SELECT * FROM recipes ORDER BY ID DESC LIMIT 1");
        $qq->execute();
        $recipeId = $qq->fetch(\PDO::FETCH_NUM);
        $measurements = [];
        $ingredientCount = [];
        $ingredients = [];
        $pivot = [];
        foreach ($data as $key => $value) {
            if (substr($key, 0, -1) == 'ingredient_count') {
                $n = substr($key, -1);
                $ingredientCount[$n] = $value;
            } elseif (substr($key, 0, -2) == 'ingredient_count') {
                $n = substr($key, -2);
                $ingredientCount[$n] = $value;
            }
            if (substr($key, 0, -1) == 'measurement_id') {
                $n = substr($key, -1);
                $measurements[$n] = $value;
            } elseif (substr($key, 0, -2) == 'measurement_id') {
                $n = substr($key, -2);
                $measurements[$n] = $value;
            }
            if (substr($key, 0, -1) == 'ingredient_id') {
                $n = substr($key, -1);
                $ingredients[$n] = $value;
            } elseif (substr($key, 0, -2) == 'ingredient_id') {
                $n = substr($key, -2);
                $ingredients[$n] = $value;
            }
            if (substr($key, 0, -1) == 'ingredient_id') {
                $n = substr($key, -1);
                $ingredients[$n] = $value;
            } elseif (substr($key, 0, -2) == 'ingredient_id') {
                $n = substr($key, -2);
                $ingredients[$n] = $value;
            }
            if (substr($key, 0, -1) == 'pivot_id') {
                $n = substr($key, -1);
                $pivot[$n] = $value;
            } elseif (substr($key, 0, -2) == 'pivot_id') {
                $n = substr($key, -2);
                $pivot[$n] = $value;
            }
        }
        for ($i = 0; $i < count($measurements); $i++) {
            $qu = $this->pdo->prepare("UPDATE `pivot` SET ingredient_id={$ingredients[$i]}, measurement_id={$measurements[$i]}, ingredient_count={$ingredientCount[$i]} WHERE id={$pivot[$i]}");
            $qu->execute();
            $qu->debugDumpParams();
            $qu = '';
        }
    }

    /**
     * deletes one recipe
     * @param $recipe_id
     */
    public function destroy($recipe_id)
    {
        $query = $this->pdo->prepare("DELETE FROM `recipes` WHERE id='{$recipe_id}'");
        $query->execute();
        $q = $this->pdo->prepare("DELETE FROM `pivot` WHERE recipe_id='{$recipe_id}'");
        $q->execute();
    }
}