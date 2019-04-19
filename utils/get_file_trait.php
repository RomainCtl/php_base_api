<?php
trait get_file_trait {
    public function get($name) {
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename="'.$name.'"');
        header('Expires: 0');
        header('Cache-Control: must-revalidate');
        header('Pragma: public');
        header('Content-Length: ' . filesize($this->get_folder().$name));

        readfile($this->get_folder().$name); # return csv file content
        exit;
    }
    abstract public function get_folder();
}
?>