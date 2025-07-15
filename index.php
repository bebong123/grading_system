<?php

use Flores\Gs\Models\StudentModel;
use Flores\Gs\Models\subjectModel;

require 'vendor/autoload.php';

$student1 = new StudentModel(123456,"Bebong","BSIT",1);
var_dump($student1);
$student = new subjectModel;
var_dump($student);

?>