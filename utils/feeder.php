<?php
abstract class Feeder {
    abstract public function get_url();
    abstract public function get_folder();
    abstract public function get_files();

    public function run() {
        /**
         * @brief function that download and write in file all need files
         */
        $result = True;
        $file_errors = array();
        foreach ($this->get_files() as $filename) {
            $content = $this->get_content($this->get_url().$filename);
            if (!$this->put_content($content, $filename)) {
                error_log("Error on write file ".$filename." (from : ".$this->url.$filename.")\n", 3, "./log/errors.log");
                array_push($file_errors, $filename);
                $result = False;
            }
        }
        if ($result)
            header("HTTP/1.1 200 OK");
        else {
            header('HTTP/1.1 500 Internal Server Error');
            die ("Error on update file");
        }
    }

    protected function put_content($data, $name) {
        /**
         * @brief function to create or write file
         *
         * @param array $data content of file to write
         * @param string $name filename to write
         *
         * @return int number of bytes that were written to the file, or FALSE on failure
         */
        if (!is_dir($this->get_folder()) && !mkdir($this->get_folder())) {
            header('HTTP/1.1 512 Internal Server Error'); // local convention : 512 mean that serveur fail to create folder
            die ("Internal Server Error");
        }
        return file_put_contents($this->get_folder().$name, $data);
    }

    protected function get_content($url, $login="MyLogin", $password="MySecretPassword") {
        /**
         * @brief function that download data from another server
         *
         * @param string $url url of the file to download
         * @param string $login to auth on this server
         * @param string $password to auth on this server
         *
         * @return array content of file downloaded
         */
        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HEADER, false);
        curl_setopt($curl, CURLOPT_HTTPAUTH, CURLAUTH_NTLM);
        curl_setopt($curl, CURLOPT_USERPWD, "AD\\".$login.":".$password); # NTML auth
        $data = curl_exec($curl);
        curl_close($curl);

        return $data;
    }
}

?>