<?php

namespace App\Http\Livewire\Admin;

use App\Models\Exam;
use App\Models\Group;
use App\Models\LogCheat;
use App\Models\Student;
use Livewire\Component;

class IndexAdmin extends Component
{
    public function render()
    {
        $kelas = Group::count();
        $siswa = Student::count();
        $ujian = Exam::count();
        $curang = LogCheat::count();
        return view('livewire.admin.index-admin', compact('kelas','siswa','ujian','curang'))
        ->extends('layouts.app')
        ->section('content');
    }
}
