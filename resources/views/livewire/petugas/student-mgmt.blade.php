<div>
    @if(session('sukses'))
    <div class="alert alert-success alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fa fa-check"></i> Sukses!</h5>
    {{session('sukses')}}
    </div>
    @endif
    @if(session('gagal'))
    <div class="alert alert-danger alert-dismissible">
    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
    <h5><i class="icon fa fa-times"></i> Gagal!</h5>
    {{session('gagal')}}
    </div>
    @endif
    <div class="row justify-content-between">
        <div class="col-lg-3">
            <a class="btn btn-primary btn-sm mb-3" data-toggle="modal" data-target="#add"><i class="fa fa-plus"> Tambah</i></a>
        </div>
        <div class="row justify-content-end">
        <div class="col-lg-6">
            <a class="btn btn-danger btn-sm mb-3" data-toggle="modal" data-target="#notacc"><i class="fa fa-times">disallow</i></a>
        </div>
        <div class="col-lg-6">
            <a class="btn btn-success btn-sm mb-3" data-toggle="modal" data-target="#acc"><i class="fa fa-check">allow</i></a>
        </div>
            
        </div>
    </div>
    <div class="row">
    <div class="col-lg-3 mb-1">
                <select wire:model='result' class="form-control">
                    <option value="10">10</option>
                    <option value="20">20</option>
                    <option value="50">50</option>
                    <option value="100">100</option>
                </select>
            </div>
            <div class="col-lg-3 mb-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Nama" wire:model="cari">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                  </div>
            </div>
            <div class="col-lg-3 mb-1">
                <div class="input-group mb-3">
                    <input type="text" class="form-control" placeholder="Cari Kelas" wire:model="carikelas">
                    <div class="input-group-append">
                      <span class="input-group-text"><i class="fa fa-search"></i></span>
                    </div>
                  </div>
            </div>
    </div>
    <table class="table table-striped">
        <tr>
            <th>No</th>
            <th>NIS</th>
            <th>Nama Lengkap</th>
            <th>Username</th>
            <th>Kelas</th>
            <th>Jenis Kelamin</th>
            <th>No Hp</th>
            <th>Acc</th>
            <th>Aksi</th>
        </tr>
        <?php $no=1;?>
        @foreach ($data as $d)
            <tr>
                <td>{{ $no++ }}</td>
                <td>{{ $d->nis }}</td>
                <td>{{ $d->name }}</td>
                <td>{{$d->username}}</td>
                <td>{{ $d->nama_kelas }}</td>
                <td>{{ $d->jenkel == 'l' ? 'Laki-laki' : 'Perempuan' }}</td>
                <td>{{ $d->no_hp }}</td>
                <td>
                  @if ($d->acc == 'y')
                <i class="fa fa-check-circle" aria-hidden="true"></i>
                @else
                <i class="fa fa-times-circle" aria-hidden="true"></i>
                @endif
                </td>
                <td>
                    <a class="btn btn-success btn-sm mb-1" data-toggle="modal" data-target="#edit" wire:click="edit({{ $d->nis }})"><i class="fa fa-edit"></i></a>
                    <a class="btn btn-danger btn-sm mb-1" data-toggle="modal" data-target="#k_hapus" wire:click="k_hapus({{ $d->id }})"><i class="fa fa-trash"></i></a>
                  </td>
            </tr>
        @endforeach
    </table>

            {{ $data->links() }}

    <div class="modal fade" id="add" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Add Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="">NIS</label>
                <input type="number" wire:model="nis" class="form-control">
                <div class="text-danger">
                    @error('nis')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Nama Lengkap</label>
                <input type="text" wire:model="name" class="form-control">
                <div class="text-danger">
                    @error('nama')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Jenis Kelamin</label>
                <select wire:model="jenkel" class="form-control">
                    <option value="">Pilih Gender</option>
                    <option value="l">Laki-laki</option>
                    <option value="p">Perempuan</option>
                </select>
                <div class="text-danger">
                    @error('jenkel')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Kelas</label>
                <select wire:model="id_kelas" class="form-control">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                    <option value="{{$k->id_kelas}}">{{$k->nama_kelas}}</option>
                    @endforeach
                </select>
                <div class="text-danger">
                    @error('id_kelas')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">No Hp</label>
                <input type="number" wire:model="no_hp" class="form-control">
                <div class="text-danger">
                    @error('no_hp')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Acc</label>
                <select wire:model="acc" class="form-control">
                    <option value="">Acc?</option>
                    <option value="y">Ya</option>
                    <option value="n">Tidak</option>
                </select>
                <div class="text-danger">
                    @error('acc')
                        {{$message}}
                    @enderror
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary suksestambah" wire:click="insert()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


    <div class="modal fade" id="edit" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Edit Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              <div class="form-group">
                <label for="">NIS</label>
                <input type="number" wire:model="nis" class="form-control" readonly>
                <div class="text-danger">
                    @error('nis')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Nama Lengkap</label>
                <input type="text" wire:model="name" class="form-control">
                <div class="text-danger">
                    @error('nama')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Jenis Kelamin</label>
                <select wire:model="jenkel" class="form-control">
                    <option value="">Pilih Gender</option>
                    <option value="l">Laki-laki</option>
                    <option value="p">Perempuan</option>
                </select>
                <div class="text-danger">
                    @error('jenkel')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Kelas</label>
                <select wire:model="id_kelas" class="form-control">
                    <option value="">Pilih Kelas</option>
                    @foreach ($kelas as $k)
                    <option value="{{$k->id_kelas}}">{{$k->nama_kelas}}</option>
                    @endforeach
                </select>
                <div class="text-danger">
                    @error('id_kelas')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">No Hp</label>
                <input type="number" wire:model="no_hp" class="form-control">
                <div class="text-danger">
                    @error('no_hp')
                        {{$message}}
                    @enderror
                </div>
              </div>
              <div class="form-group">
                <label for="">Acc</label>
                <select wire:model="acc" class="form-control">
                    <option value="">Acc?</option>
                    <option value="y">Ya</option>
                    <option value="n">Tidak</option>
                </select>
                <div class="text-danger">
                    @error('acc')
                        {{$message}}
                    @enderror
                </div>
              </div>
            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="update()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      <div class="modal fade" id="k_hapus" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Delete Data</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                Apakah Kamu yakin menghapus data ini?

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="delete()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <div class="modal fade" id="acc" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Acc Semua Siswa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                Sebelum meng Acc semua User, pastikan semua data siswa benar beserta kelasnya. Apakah anda yakin untuk melanjutkan?

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="accAll()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->
      <div class="modal fade" id="notacc" wire:ignore.self>
        <div class="modal-dialog">
          <div class="modal-content">
            <div class="modal-header">
              <h4 class="modal-title">Acc Semua Siswa</h4>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
                Apakah anda yakin untuk melanjutkan?

            </div>
            <div class="modal-footer justify-content-between">
              <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
              <button type="button" class="btn btn-primary" wire:click="notAccAll()">Save changes</button>
            </div>
          </div>
          <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
      </div>
      <!-- /.modal -->


      

      <script>
        window.addEventListener('closeModal', event => {
            $('#add').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#edit').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_hapus').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#k_bayar').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#req').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#acc').modal('hide');
        })
        window.addEventListener('closeModal', event => {
            $('#notacc').modal('hide');
        })
      </script>

</div>
