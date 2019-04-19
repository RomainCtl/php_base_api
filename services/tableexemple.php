<?php
include_once("./utils/feeder.php");
include_once("./utils/get_file_trait.php");

class TableExemple extends Feeder {
    use get_file_trait;

    protected $url;
    protected $folder;
    protected $files;

    public function __construct() {
        $this->url = "https://domain.ext/path/to/files/";
        $this->folder = getcwd()."/export/csv/";
        $this->files = array("File1.CSV", "File2.CSV", "File3.CSV", "File4.CSV", "File5.CSV");
    }

    public function get_url() {
        return $this->url;
    }

    public function get_folder() {
        return $this->folder;
    }

    public function get_files() {
        return $this->files;
    }
}

?>