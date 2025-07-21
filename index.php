<?php

use Flores\Gs\Core\Database;
use Flores\Gs\Models\StudentModel;
use Flores\Gs\Models\subjectModel;

require 'vendor/autoload.php';

$student = new StudentModel();
$listofStudents = $student->read();
print_r($listofStudents);



?>