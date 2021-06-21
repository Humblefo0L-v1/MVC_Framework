<?php  

    class Controller{

        //Loading the model 
        public function model($model){
            //Require the model file once
            require_once '../app/models/' . $model . '.php';
            //creating instance of the model
            return new $model();
        }

        //Loading the views if it exists
        public function view($view, $data=[]){
            if (file_exists('../app/views/' . $view . '.php')) {
                require_once '../app/views/' . $view . '.php';
            }else{
                die("Page does not exist!");
            }
        }
    }