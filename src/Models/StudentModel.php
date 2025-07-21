<?php
namespace Flores\Gs\Models;

use Flores\Gs\Core\Crud;
use Flores\Gs\Core\Database;

class StudentModel extends Database implements Crud {
    public int $id;
    public string $name;
    public string $course;
    public int $year_level;
    public string $sections;

    public function __construct(){
        parent:: __construct();
        $this->id=0;
        $this->name="";
        $this->course="";
        $this->year_level=0;
        $this->sections="";
    
    
    }
    public function create(){
       
    }


    public function read(){
        try{
           $sql = "SELECT * FROM students";
           $results = $this->conn->query($sql);
           return $results->fetch_all(MYSQLI_ASSOC);

           }catch (\Throwable $th){
            echo $th->getMessage();
        }

    }
    public function update($id){

        
    }
    public function delete($id){
        
    }

}