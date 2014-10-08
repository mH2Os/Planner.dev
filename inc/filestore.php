<?php

 class Filestore {

     private $filename = '';
     private $is_csv = FALSE;

     public function __construct($filename = '')
     {
        $this->filename = $filename;

        // substr to check file extension
        // set is_csv to true if it is a csv file

        if(substr($this->filename, -3) == 'csv') {
            $this->is_csv = TRUE;
        }

     }

    public function read() {
        // check $this->is_csv and call correct

        if($this->is_csv) {
            return $this->read_csv();
        } else {
            return $this->read_lines();
        }
    }

    //
    public function write($array) {
        // check $this->is_csv and call correct

        if($this->is_csv) {
            return $this->write_csv($array);
        } else {
            return $this->write_lines($array);
        }
    }


     /**
      * Returns array of lines in $this->filename
      */
     private function read_lines()
     {
        $items = array();

        if(is_readable($this->filename) && filesize($this->filename) > 0) {
            $handle = fopen($this->filename, "r");
            $contents = trim(fread($handle, filesize($this->filename)));
            $items = explode("\n", $contents);

            fclose($handle);
        }

        return $items;

     }

     /**
      * Writes each element in $array to a new line in $this->filename
      */
     private function write_lines($array)
     {
        $handle = fopen($this->filename, 'w');
        $save = implode("\n", $array);
        fwrite($handle, $save);
        fclose($handle);
     }

     /**
      * Reads contents of csv $this->filename, returns an array
      */
     private function read_csv()
     {
        $address_book = [];
        
        $handle = fopen($this->filename, 'r');

        while (!feof($handle)) {
          $row = fgetcsv($handle);

          if(!empty($row)) {
            $address_book[] = $row;
          }

        }

        fclose($handle);

        return $address_book;
     }

     /**
      * Writes contents of $array to csv $this->filename
      */
     private function write_csv($array)
     {
        $handle = fopen($this->filename, 'w');

        foreach ($array as $fields) {
            fputcsv($handle, $fields);
        }

        fclose($handle);
     }

 }