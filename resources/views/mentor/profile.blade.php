@extends('layout.mentor')
@section('title')
    Edit Profile
@endsection
@section('content')
    <nav class="breadcrumb">
        <a class="breadcrumb-item" href="{{ url('mentor/dashboard')}}">Dashboard</a>
        <a class="breadcrumb-item">Profile Settings</a>
    </nav>

    @include('layout.dashboard.alert_flash')


    <div class="row">
        @include('components.message')
    </div>

    <div class="row">
        <div class="col-sm-4">
            <div class="card">
                <div class="profile-header-container">
                <div class="text-xs-center">
                    @if(strtolower(Auth::guard('mentor')->user()->jk) == 1)
                        <img src="{{ url('img/avatar/avatar-sibima03.png') }}" class="img-fluid profile-user"  alt="Responsive image">
                    @else
                        <img src="{{ url('img/avatar/avatar-sibima02.png') }}" class="img-fluid profile-user" alt="Responsive image">
                    @endif  
                </div>
                    <hr class="m-b-0">
                    <div class="card-block">
                        <div class="text-xs-center">
                        <h5 class="card-title">{{ Auth::guard('mentor')->user()->nama }}</h5>
                        <p class="font-weight-bold m-b-0">{{ Auth::guard('mentor')->user()->nim }}</p>
                        <p class="font-weight-bold">{{ Auth::guard('mentor')->user()->fakultas }}</p>
                        </div>
                    </div>
            </div>
        </div>
    </div>

    <div class="col-sm-8">
        <div class="card">
            <div class="card-block">
                <form action="{{ url('mentor/profile') }}" method="post">
                    {{ csrf_field() }}
                    <div class="form-group">
                        <label class="control-label">Nama Lengkap </label>
                        <input type="text" placeholder="{{ Auth::guard('mentor')->user()->nama }}" class="form-control" disabled/>
                    </div>
                    <div class="form-group">
                        <label class="control-label">Nomor HP</label>
                        <input name="nomor_hp" type="text" value="{{ Auth::guard('mentor')->user()->no_telp }}" class="form-control" />
                    </div>
                    <div class="form-group">
                        <label class="control-label">Group Kelompok</label>
                        <input name="id_line" type="text" value="{{ Auth::guard('mentor')->user()->line_id }}" class="form-control" placeholder="Masukkan Link Group Anda" />
                    </div>
                    <div>
                        <button type="submit" class="btn btn-primary">Submit Perubahan</button>
                    </div>
                </form>
            </div>
            </div>
        </div>
    </div>
    @include('components.message')


    <div class="col-12">
        <div class="card">
            <div class="card-block">
                <form action="{{ url('mentor/update-cred') }}" method="post" enctype="multipart/form-data">
                    {{ csrf_field() }}

                    <h4 for="">Kredensial Mentor</h4>
                    <div class="form-group">
                      <label for="">Format : Nama Bank - Rekening, <br>
                        -Diutamakan Bank Mandiri, selain Bank Mandiri maka biaya transfer ditanggung mentor <br>
                        -Bilangan Gaji Mentor Menyesuaikan Dengan Kebijakan BPULPS/PPDU</label>
                      <input type="text" placeholder="Contoh : BCA - 1234456654"
                        class="form-control" required name="no_rekening" id="" value="{{Auth::guard('mentor')->user()->no_rekening }}" aria-describedby="helpId" placeholder="Nomor Rekening">
                      <small id="helpId" class="form-text text-muted">Format : Nama Bank - Rekening</small>
                    </div>

                    <img src="" class="img-fluid ${3|rounded-top,rounded-right,rounded-bottom,rounded-left,rounded-circle,|}" alt="">

                    <div class="form-group">
                      <label for="">Upload/Edit Foto KTP</label>
                      <input type="file" class="form-control-file" name="photo_ktp" id="" placeholder="" aria-describedby="fileHelpId">
                      <small id="fileHelpId" class="form-text text-muted">Foto Kredensial KTP Mentor</small>
                    </div>

                    <div class="form-group">
                      <label for="">Upload/Edit Foto KTM</label>
                      <input type="file" class="form-control-file" name="photo_ktm" id="" placeholder="" aria-describedby="fileHelpId">
                      <small id="fileHelpId" class="form-text text-muted">Foto Kredensial KTM Mentor</small>
                    </div>
                    <div class="form-group">
                      <label for="">Upload/Edit Buku Tabungan</label>
                      <input type="file" class="form-control-file" name="photo_tabungan" id="" placeholder="" aria-describedby="fileHelpId">
                      <small id="fileHelpId" class="form-text text-muted">Help text</small>
                    </div>

                    <div class="form-group">
                      <label for="">Apakah Bersedia Lanjut Melakukan Mentoring Di Semester Depan ??</label>
                      <select required class="form-control" name="is_lanjut" id="">
                        <option value="" @if (Auth::guard('mentor')->user()->is_lanjut=="") selected @endif>----Pilih Opsi---</option>
                        <option value="1" @if (Auth::guard('mentor')->user()->is_lanjut==1) selected @endif>Ya</option>
                        <option value="0" @if (Auth::guard('mentor')->user()->is_lanjut==0) selected @endif>Tidak</option>
                      </select>
                    </div>
                    
                    <div>
                        <button type="submit" class="btn btn-primary">Submit Perubahan</button>
                    </div>
                </form>
            </div>

            <div class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th colspan="3">Preview Dokumen</th>
                        </tr>
                        <tr>
                            <th>No</th>
                            <th>Keterangan</th>
                            <th>Foto</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td scope="row">1.</td>
                            <td>Buku Tabungan</td>
                            <td>
                                <img class="card-img-top img-fluid"style=" border-radius:20px !important" src="{{ url('/') . Auth::guard('mentor')->user()->path_rekening }}"
                                alt="Card image cap"
                                onerror="this.src='http://www.pallenz.co.nz/assets/camaleon_cms/image-not-found-4a963b95bf081c3ea02923dceaeb3f8085e1a654fc54840aac61a57a60903fef.png'">
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">2.</td>
                            <td>KTP</td>
                            <td>
                                <img class="card-img-top img-fluid" style=" border-radius:20px !important" src="{{ url('/') . Auth::guard('mentor')->user()->path_ktp  }}"
                                alt="Card image cap"
                                onerror="this.src='http://www.pallenz.co.nz/assets/camaleon_cms/image-not-found-4a963b95bf081c3ea02923dceaeb3f8085e1a654fc54840aac61a57a60903fef.png'">
                            </td>
                        </tr>
                        <tr>
                            <td scope="row">2.</td>
                            <td>KTM</td>
                            <td>
                                <img class="card-img-top img-fluid" style=" border-radius:20px !important" src="{{ url('/') . Auth::guard('mentor')->user()->path_ktm }}"
                                alt="Card image cap"
                                onerror="this.src='http://www.pallenz.co.nz/assets/camaleon_cms/image-not-found-4a963b95bf081c3ea02923dceaeb3f8085e1a654fc54840aac61a57a60903fef.png'">
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>


@endsection