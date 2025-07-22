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
        $query = $this->conn->prepare("INSERT INTO `students`(`id`, `name`, `course`, `year_level`, `sections`)
         VALUES ('$this->id','$this->name','$this->course','$this->year_level','$this->sections')");
        if($query->execute()){
            echo "Student Inserted";

        }
       
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
       $query = $this->conn->prepare("UPDATE `students` SET id='$this->id',name='$this->name',course='$this->course',year_level='$this->year_level',sections='$this->sections'WHERE id = $id");
       if($query->execute()){
        echo "Student Updated Succesfully\n";
       }
        
      }
    
    public function delete($id){
        $this->id=$id;
        
        $query = $this->conn->prepare("DELETE FROM `students`WHERE id = $this->id");
        if($query ->execute()){
            echo "Student Deleted";
        }
    }
}

