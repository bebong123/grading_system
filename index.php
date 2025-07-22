<?php

use Flores\Gs\Core\Database;
use Flores\Gs\Models\StudentModel;
use Flores\Gs\Models\subjectModel;

require 'vendor/autoload.php';

$student = new StudentModel();
$listofStudents = $student->read();
print_r($listofStudents);
$student->name="Carl";
$student->course="BSIT";
$student->id=345623;
$student->year_level=2;
$student->sections="D";

//$student->create();
$student->read();
//$student->update(135756);
//$student->delete(135756);







?>