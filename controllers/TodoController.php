<?php

class TodoController
{
    private function response($data, $code = 200)
    {
        header('ContentType: application/json', true, $code);
        array_walk_recursive($data, function(&$value){
            if(is_subclass_of($value, \Spatie\DataTransferObject\DataTransferObject::class)) {
                $value = $value->toArray();
            }
        });
        echo json_encode($data);
        exit;
    }

    public function actionList()
    {
        $this->response(Todo::all());
    }

    public function actionAdd()
    {
        try{
            $todo = new TodoDTO($_POST);
        }
        catch(\Spatie\DataTransferObject\Exceptions\UnknownProperties $e) {
            $this->response([], 404);
        }
        if(Todo::add($todo)) {
            $this->response([]);
            return;
        }
        $this->response([], 400);
    }

    public function actionDelete()
    {
        $todo = Todo::findOne($_GET['id']);
        if(!$todo) {
            $this->response([], 404);
        }
        Todo::delete($todo);
        $this->response([]);
    }

    public function actionDone()
    {
        $todo = Todo::findOne($_GET['id']);
        if(!$todo) {
            $this->response([], 404);
        }
        Todo::setDone($todo);
        $this->response([]);
    }
}