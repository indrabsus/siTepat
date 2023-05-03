<?php

namespace App\Http\Livewire\Petugas;

use App\Models\Graduation;
use App\Models\Group;
use Livewire\Component;
use Livewire\WithPagination;

class GraduationMgmt extends Component
{
    public $ids, $nis, $nama, $link;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = Graduation::where('nama', 'like','%'.$this->cari.'%')
        ->orderBy('id_kelulusan', 'desc')
        ->paginate($this->result);
        return view('livewire.petugas.graduation-mgmt', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nis = '';
        $this->nama = '';
        $this->link = '';
    }
    public function insert(){
        $this->validate([
            'nis' => 'required|unique:graduations',
            'nama' => 'required',
            'link' => 'required'
        ]);
        Graduation::create([
            'nis' => $this->nis,
            'password' => rand(10000,99999),
            'nama' => $this->nama,
            'link' => $this->link 
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $data = Graduation::where('id_kelulusan',$id)->first();

        $this->ids = $data->id_kelulusan;
        $this->nis = $data->nis;
        $this->nama = $data->nama;
        $this->link = $data->link;
    }
    public function update(){
        $this->validate([
            'nama' => 'required',
            'link' => 'required'
        ]);
        Graduation::where('id_kelulusan', $this->ids)->update([
            'nama' => $this->nama,
            'link' => $this->link 
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diedit');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = Graduation::where('id_kelulusan',$id)->first();
        $this->ids = $data->id_kelulusan;
    }
    public function delete(){
        Graduation::where('id_kelulusan', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
    
}
