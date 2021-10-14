<?php

class TodoDTO extends \Spatie\DataTransferObject\DataTransferObject
{
    private int $id;
    private string $what;
    private bool $done;
}

class Todo
{
    public static function all() : array
    {
        $st = Db::getConnection()->query("SELECT * FROM todo");
        $results = $st->fetchAll(PDO::FETCH_ASSOC);
        $todos = [];
        foreach($results as $result) {
            $todos[] = new TodoDTO($result);
        }

        return $todos;
    }

    public static function findOne(int $id): TodoDTO|null
    {
        $st = Db::getConnection()->query("SELECT * FROM todo WHERE id=".$id." LIMIT 1");
        $result = $st->fetch(PDO::FETCH_ASSOC);
        if(!$result) {
            return null;
        }
        return new TodoDTO($result);
    }

    public static function setDone(TodoDTO $todo)
    {
        Db::getConnection()->exec("UPDATE todo SET done=TRUE WHERE id=".$todo->toArray()['id']);
    }

    public static function delete(TodoDTO $todo)
    {
        return Db::getConnection()->exec("DELETE FROM todo WHERE id = ".$todo->toArray()['id']);
    }
    public static function add(TodoDTO $todo)
    {
        return Db::getConnection()->exec("INSERT INTO todo () VALUES ('".implode("','",$todo->except('id'))."')");
    }
}
