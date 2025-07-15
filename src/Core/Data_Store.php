<?php

namespace Flores\Gs\Core;

class Data_Store {
    private string $filePath;
    public function __construct(string $filePath){
        $this->filePath=$filePath;
        if (!file_exists($this->filePath)){
            file_put_contents($this->filePath, json_encode([]));
        }
        //clear data
        file_put_contents($this->filePath, json_encode([]));

     }
     //create a connection to the datastore
     public function getConnection():
     array {
        $data = file_get_contents($this->filePath);
        return json_encode($data, true) ?? [];

     }
}
?>