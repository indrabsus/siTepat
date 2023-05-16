<?php

namespace App\Http\Livewire\Petugas;

use App\Models\Group;
use App\Models\Payment;
use App\Models\Request;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class StudentMgmt extends Component
{
    public $name, $jenkel, $id_kelas, $no_hp, $nis, $bulan, $id_user, $acc;
    use WithPagination;
    public $cari = '';
    public $carikelas = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = DB::table('students')
        ->leftJoin('users','users.id','students.id_user')
        ->leftJoin('groups','groups.id_kelas','students.id_kelas')
        ->where('users.name', 'like','%'.$this->cari.'%')
        ->where('groups.nama_kelas', 'like','%'.$this->carikelas.'%')
        ->orderBy('students.created_at', 'desc')
        ->paginate($this->result);
        $kelas = Group::all();
        return view('livewire.petugas.student-mgmt', compact('data','kelas'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nis = '';
        $this->name = '';
        $this->jenkel = '';
        $this->id_kelas = '';
        $this->no_hp = '';
        $this->acc = '';
    }
    public function insert(){
        $this->validate([
            'nis' => 'required|unique:students',
            'name' => 'required',
            'jenkel' => 'required',
            'id_kelas' => 'required',
            'no_hp' => 'required',
        ]);
        $user = User::create([
            'name' => ucwords($this->name),
            'username' => rand(100,999).strtolower(str_replace(' ','', $this->name)),
            'password' => bcrypt($this->nis),
            'level' => 'siswa',
            'acc' => $this->acc
        ]);
        Student::create([
            'nis' => $this->nis,
            'id_user' => $user->id,
            'jenkel' => $this->jenkel,
            'id_kelas' => $this->id_kelas,
            'no_hp' => $this->no_hp,
        ]);
        
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $data = DB::table('students')
        ->leftJoin('users','users.id','students.id_user')
        ->where('nis', $id)
        ->first();
        $this->id_user = $data->id_user;
        $this->nis = $data->nis;
        $this->name = $data->name;
        $this->jenkel = $data->jenkel;
        $this->no_hp = $data->no_hp;
        $this->id_kelas = $data->id_kelas;
        $this->acc = $data->acc;
    }
    public function update(){
        $this->validate([
            'nis' => 'required',
            'jenkel' => 'required',
            'id_kelas' => 'required',
            'no_hp' => 'required',
            'acc' => 'required'
        ]);
        User::where('id', $this->id_user)->update([
            'name' => ucwords($this->name),
            'acc' => $this->acc
        ]);
        Student::where('nis', $this->nis)->update([
            'nis' => $this->nis,
            'jenkel' => $this->jenkel,
            'id_kelas' => $this->id_kelas,
            'no_hp' => $this->no_hp,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = User::where('id',$id)->first();
        $this->nis = $data->id;
    }
    public function delete(){
        User::where('id', $this->nis)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
    public function accAll(){
        User::where('id','>',0)->update([
            'acc' => 'y'
        ]);
        session()->flash('sukses', 'User semua sudah di Acc');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
    public function notAccAll(){
        User::where('id','>',0)->update([
            'acc' => 'n'
        ]);
        session()->flash('sukses', 'User semua sudah di tidak di Acc');
        $this->clearForm();
        $this->dispatchBrowserEvent('closeModal');
    }
    
}
