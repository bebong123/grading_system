<?php

use Flores\Gs\Core\Database;
use Flores\Gs\Models\StudentModel;
use Flores\Gs\Models\subjectModel;

require 'vendor/autoload.php';

$student = new StudentModel();
//$listofStudents = $student->read();
//print_r($listofStudents);
$student->name="Yl John";
$student->course="BSIT";
$student->id=2005;
$student->year_level=2;
$student->sections="D";

//$insertStudent = $student->create();
$insertStudent = $student->update(35646);
//$student->delete(35646);







?>