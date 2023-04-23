<?php

namespace App\Http\Livewire\Admin;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class UserMgmt extends Component
{
    public $name, $username, $level, $ids;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = User::where('level', '=', 'petugas')
        ->where('name', 'like','%'.$this->cari.'%')
        ->orderBy('id', 'desc')
        ->paginate($this->result);
        return view('livewire.admin.user-mgmt', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->name = '';
        $this->username = '';
    }
    public function insert(){
        $this->validate([
            'name' => 'required',
            'username' => 'required|alpha_dash|unique:users',
        ],[
            'name.required' => 'Nama tidak boleh kosong!',
            'username.required' => 'Username tidak boleh kosong!',
            'username.alpha_dash' => 'Username hanya boleh huruf dan angka!',
            'username.unique' => 'Username sudah digunakan!',
        ]);
        User::create([
            'name' => ucwords($this->name),
            'username' => $this->username,
            'password' => bcrypt('rahasia'),
            'level' => 'petugas',
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $data = User::where('id',$id)->first();

        $this->ids = $data->id;
        $this->name = $data->name;
        $this->username = $data->username;
    }
    public function update(){
        $this->validate([
            'name' => 'required',
        ],[
            'name.required' => 'Nama tidak boleh kosong!',
            'jabatan.required' => 'Level tidak boleh kosong',
        ]);
        User::where('id', $this->ids)->update([
            'name' => ucwords($this->name),
            'username' => $this->username,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = User::where('id',$id)->first();
        $this->ids = $data->id;
    }
    public function delete(){
        User::where('id', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }

    public function k_reset($id){
        $data = User::where('id',$id)->first();
        $this->ids = $data->id;
    }
    public function do_reset(){
        User::where('id', $this->ids)->update([
            'password' => bcrypt('rahasia')
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Password berhasil direset');
        $this->dispatchBrowserEvent('closeModal');
    }
}
