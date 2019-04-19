<?php
class Route {
    private $path;
    private $callable;
    private $matches = [];

    public function __construct($path, $callable){
        $this->path = trim($path, '/'); // delete useless '/'
        $this->callable = $callable;
    }

    /* Check if it match and collect url param */
    public function match($url){
        $url = trim($url, '/');
        $path = preg_replace('#:([\w]+)#', '([^/]+)', $this->path);
        $regex = "#^$path$#i";
        if(!preg_match($regex, $url, $matches)){
            return false;
        }
        array_shift($matches); // Delete first param of $matches (all $url) PS: read doc
        $this->matches = $matches;
        return true;
    }

    public function call(){
        return call_user_func_array($this->callable, $this->matches);
    }
}
?>