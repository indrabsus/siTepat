<?php

namespace App\Http\Livewire\Petugas;

use App\Models\Group;
use App\Models\LogCheat;
use App\Models\LogExam;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class LogCurang extends Component
{
    use WithPagination;
    public $ids, $nama_kelas;
    public $cari = '';
    public $carikelas = '';
    public $result = 10;
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $data = DB::table('log_cheats')
        ->leftJoin('students','students.id_user', 'log_cheats.id_user')
        ->leftJoin('users','users.id','students.id_user')
        ->leftJoin('groups','groups.id_kelas','students.id_kelas')
        ->leftJoin('exams','exams.id_ujian','log_cheats.id_ujian')
        ->where('name', 'like','%'.$this->cari.'%')
        ->orderBy('id_logc', 'desc')
        ->where('groups.id_kelas', 'like','%'.$this->carikelas.'%')
        ->paginate($this->result);
        $kelas = Group::all();
        
        return view('livewire.petugas.log-curang', compact('data', 'kelas'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function k_hapus($id){
        $data = LogCheat::where('id_logc',$id)->first();
        $this->ids = $data->id_logc;
    }
    public function delete(){
        LogCheat::where('id_logc', $this->ids)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}
