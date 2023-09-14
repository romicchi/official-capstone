<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Discipline;
use App\Models\College;

class DisciplineController extends Controller
{
    public function createDisciplineAndAssociateWithCollege()
    {
        // Create a new discipline
        $discipline = Discipline::create(['name' => 'Computer Science']);

        // Associate a discipline with a college
        $college = College::find(1);
        $college->disciplines()->attach($discipline->id);

        // You can add any additional logic or return a response here
    }
}
