
@if (session('id_ujian'))
<script>window.location = "{{ route('test') }}";</script>
@endif
@extends('exam.layouts.app')

@section('konten')
<div class="row justify-content-center mt-3">
    <div class="col-lg-8">
        <div class="mb-2">
            <a href="{{route('logout')}}"><i class="fa fa-sign-out" aria-hidden="true"></i> Logout</a>
        </div>
        <div class="card">
            <div class="card-body">
                <h3 class="text-center">List Test yang Aktif</h3>
                <hr>
                <table class="table table-striped table-bordered">
                    <tr>
                        <th class="col-lg-9">Nama Ujian</th>
                        <th class="col-lg-2">Waktu</th>
                        <th class="col-lg-1">Aksi</th>
                    </tr>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{$d->nama_ujian}}</td>
                            <td>{{$d->waktu}} Menit</td>
                            <td><a href="{{ route('token', ['id' => $d->id_ujian]) }}" class="btn btn-success btn-sm">Mulai</a></td>
                           
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>
</div>
@endsection