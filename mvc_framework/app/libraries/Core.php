<?php   

    //Core App Class
    class Core {
        protected $currentController = 'Pages';
        protected $currentMethod = 'index';
        protected $params = [];

        public function __construct(){
            $url = $this->getUrl();

            //Checking whether controller file exists in the controllers folder
            if (file_exists('../app/controllers/' . ucwords($url[0]) . '.php')) {

                //setting up a new controller and overwriting the 'Pages' controller with the new one
                $this-> currentController = ucwords($url[0]);  
                unset($url[0]);

            }

            //Instantiating the new controller
            require_once '../app/controllers/' . $this-> currentController . '.php';
            $this-> currentController = new $this-> currentController;

            //Checking the second part of the URL
            if (isset($url[1])) {
                if (method_exists($this-> currentController, $url[1])) {
                    $this->currentMethod = $url[1];
                    unset($url[1]);
                }
            }

            //Getting the parameters
            $this-> params = $url ? array_values($url) : [];

            //making a callback for array of params
            call_user_func_array([$this->currentController, $this->currentMethod], $this->params);
        }

        public function getUrl(){
            if (isset($_GET['url'])) {
                
                $url = rtrim($_GET['url'],'/');   //removing any spaces or unnecessary characters from the right side of the URL
                $url = filter_var($url, FILTER_SANITIZE_URL);   //filtering URL into respective data types
                $url = explode('/',$url);   //separate the filtered URl into an array
                return $url;
            }
        }
    }
    

