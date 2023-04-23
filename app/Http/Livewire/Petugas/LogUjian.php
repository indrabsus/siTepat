<?php

namespace App\Http\Livewire\Petugas;

use App\Models\LogExam;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class LogUjian extends Component
{
    use WithPagination;
    public $ids, $nama_kelas;
    public $cari = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = LogExam::where('nama', 'like','%'.$this->cari.'%')
        ->orderBy('id_log', 'desc')
        ->paginate($this->result);
        
        return view('livewire.petugas.log-ujian', compact('data'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function k_hapus($id){
        $data = LogExam::where('id_log',$id)->first();
        $this->ids = $data->id_log;
    }
    public function delete(){
        LogExam::where('id_log', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}
