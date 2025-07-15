<?php
namespace Flores\Gs\Models;

use Flores\Gs\Core\Crud;

class StudentModel implements Crud {
    public int $id;
    public string $name;
    public string $course;
    public int $year_level;

    public function __construct(int $id,string $name,string $course,int $year_level){
        $this->id=$id;
        $this->name=$name;
        $this->course=$course;
        $this->year_level=$year_level;
    }
    public function create(){

    }
    public function read(){

    }
    public function update(){

    }
    public function delete(){
        
    }

}