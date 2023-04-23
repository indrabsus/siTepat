<?php

namespace App\Http\Livewire\Petugas;

use App\Models\Exam;
use App\Models\Group;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class ExamMgmt extends Component
{
    public $id_kelas, $waktu, $nama_ujian, $link, $acc, $token;
    use WithPagination;
    public $cari = '';
    public $result = 10;
    public $kelasku = [];
    protected $paginationTheme = 'bootstrap';
    public function render()
    {
        $kelas = Group::all();
        $data = DB::table('exams')
        ->leftJoin('groups','groups.id_kelas','exams.id_kelas')
        ->where('exams.nama_ujian', 'like','%'.$this->cari.'%')
        ->orderBy('exams.created_at', 'desc')
        ->paginate($this->result);
        return view('livewire.petugas.exam-mgmt', compact('data','kelas'))
        ->extends('layouts.app')
        ->section('content');
    }
    public function clearForm(){
        $this->nama_ujian = '';
        $this->id_kelas = '';
        $this->waktu = '';
        $this->link = '';
        $this->acc = '';
        $this->token = '';
    }
    public function insert(){
        $this->validate([
            'nama_ujian' => 'required',
            'kelasku' => 'required',
            'waktu' => 'required',
            'link' => 'required',
            'acc' => 'required',
            'token' => 'required'
        ]);
        for($no=0; $no < count($this->kelasku); $no++){
            Exam::create([
                'nama_ujian' => $this->nama_ujian,
                'id_kelas' => $this->kelasku[$no],
                'waktu' => $this->waktu,
                'link' => $this->link,
                'token' => $this->token,
                'acc' => $this->acc,
            ]);
        }
       
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil ditambahkan');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function edit($id){
        $data = DB::table('exams')
        ->where('id_ujian', $id)
        ->first();
        $this->id_ujian = $data->id_ujian;
        $this->nama_ujian = $data->nama_ujian;
        $this->id_kelas = $data->id_kelas;
        $this->waktu = $data->waktu;
        $this->link = $data->link;
        $this->acc = $data->acc;
    }
    public function update(){
        $this->validate([
            'nama_ujian' => 'required',
            'id_kelas' => 'required',
            'waktu' => 'required',
            'link' => 'required',
            'acc' => 'required'
        ]);
        Exam::where('id_ujian', $this->id_ujian)->update([
            'nama_ujian' => $this->nama_ujian,
            'id_kelas' => $this->id_kelas,
            'waktu' => $this->waktu,
            'link' => $this->link,
            'acc' => $this->acc,
        ]);
        $this->clearForm();
        session()->flash('sukses', 'Data berhasil diubah');
        $this->dispatchBrowserEvent('closeModal');
    }
    public function k_hapus($id){
        $data = Exam::where('id_ujian',$id)->first();
        $this->id_ujian = $data->id_ujian;
    }
    public function delete(){
        Exam::where('id_ujian', $this->id_ujian)->delete();
        session()->flash('sukses', 'Data berhasil dihapus!');
        $this->dispatchBrowserEvent('closeModal');
    }
}
