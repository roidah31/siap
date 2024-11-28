@extends('layouts.admin')
@section('content')


<section class="content">
<div class="row">
<div class="col-12">

<div class="box">
 <div class="box-header with-border">
   <h3 class="box-title">Data Aset</h3>
 </div>
 <div class="box-body">
   <div class="table-responsive">
    <button type="button" class="btn btn-primary mb-3 btn-add">
        Tambah baru
    </button>
	
     <table id="example5" class="table table-bordered table-striped" style="width:100%">
     <thead>
        <tr>
          <th>No serial </th>
          <th>Nama Barang</th>
          <th>Fungsi Barang</th>
          <th>Unit</th>
          <th>Lantai</th>
          <th>Ruang</th>
          <th>Semester</th>
          <th>Tahun</th>
          <th>Status</th>
          <th>Nama Penginput</th>
          <th>Unit Penginput</th>
          <th>Masa Hidup</th>
          <th>Penghapusan</th>
          <th>Perbaikan</th>
          <th>Perbaikan ke</th>
          <th>Aksi</th>
        </tr>
     </thead>
     <tbody>
      @foreach($aset as $r)
       <tr>    
          <td>{{$r->no_serial}}</td>
          <td>{{$r->nama_barang}}</td>
          <td>{{$r->fungsi_barang}}</td>
          <td>{{$r->unit}}</td>
          <td>{{$r->lantai}}</td>
          <td>{{$r->ruang}}</td>
          <td>{{$r->semester}}</td>
          <td>{{$r->tahun}}</td>
          <td>
            @if($r->status == 0)
              BAIK
            @elseif($r->status == 1) 
              RUSAK RINGAN
            @elseif($r->status == 2)
              RUSAK BERAT
            @else
              HILANG
            @endif
          </td>
          <td>{{$r->namapenginput}}</td>
          <td>{{$r->kdunitpenginput}}</td>
          <td>{{$r->masahidup}} {{$r->satuan}}</td>   
          <td>{{$r->penghapusan }}</td>
          <td>{{$r->perbaikan}}</td>         
          <td>{{ $r->perbaikanke}}</td>
          <td>
              <button type="button" 
                    class="btn btn-info btn-sm edit-button mb-1" 
                    data-item='{
                        "id": "{{$r->id}}",
                        "no_serial": "{{$r->no_serial}}",
                        "nama_barang": "{{$r->nama_barang}}",
                        "fungsi_barang": "{{$r->fungsi_barang}}",
                        "unit_mitra": "{{$r->unit}}",
                        "kode_gedung": "{{$r->kode_gedung}}",
                        "lantai": "{{$r->lantai}}",
                        "unit": "{{$r->unit}}",
                        "ruang": "{{$r->ruang}}",
                        "semester": "{{$r->semester}}",
                        "tahun": "{{$r->tahun}}",
                        "satuan": "{{$r->satuan}}",
                        "masahidup": "{{$r->masahidup}}",
                        "penghapusan": "{{$r->penghapusan}}",
                        "perbaikan": "{{$r->perbaikan}}",
                        "perbaikanke": "{{$r->perbaikanke}}",
                        "status": "{{$r->status}}"
                    }'>
                <i class="fas fa-edit"></i> Edit
              </button>
            <form action="{{route('aset.destroy',$r->id)}}" method="post" class="d-inline">
                @csrf
                <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Apakah anda yakin ingin menghapus data ini?')">
                    <i class="fas fa-trash"></i> Delete
                </button>
            </form>
          </td>        
       </tr>
      @endforeach
     </tbody>
     <tfoot>
        <tr>
          <th>No serial </th>
          <th>Nama Barang</th>
          <th>Fungsi Barang</th>
          <th>Unit</th>
          <th>Lantai</th>
          <th>Ruang</th>
          <th>Semester</th>
          <th>Tahun</th>
          <th>Status</th>
          <th>Nama Penginput</th>
          <th>Unit Penginput</th>
          <th>Masa Hidup</th>
          <th>Penghapusan</th>
          <th>Perbaikan</th>
          <th>Perbaikan ke</th>
          <th>Aksi</th>
        </tr>
     </tfoot>
   </table>
   </div>
 </div>
</div>
</div> 
</div>
</section>

@include('aset.modal')

@endsection
