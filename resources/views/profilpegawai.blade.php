@extends('widget/main')
@section('container')
<div class="container">
    <div class="row align-items-center">
        <div class="card-header">
            <h4>Profil Pegawai</h4>
        </div>

        <div class="card-body" style="padding-top:40px;text-align:left;">
            <table width="100%" style="font-size:13px;">
                <tr>
                    <td width="20%"><label for="name" class="form-label">Nama</label></td>
                    <td width="5%">:</td>
                    <td width="75%" style="text-align:left;">{{getNamaLengkap($pegawai->nama_pegawai,$pegawai->gelar_depan,$pegawai->gelar_belakang)}}</td>
                </tr>
                <tr>
                    <td><label for="nip" class="form-label">NIP</label></td>
                    <td>:</td>
                    <td>{{$pegawai->nip}}</td>
                </tr>
                <tr>
                    <td><label for="umur" class="form-label">Umur</label></td>
                    <td>:</td>
                    <td>{{$pegawai->umur}} tahun</td>
                </tr>
                <tr valign="top">
                    <td><label for="jabatan" class="form-label">Jabatan</label></td>
                    <td>:</td>
                    <td>{{$pegawai->jabatan}}</td>
                </tr>
                <tr valign="top">
                    <td><label for="uker" class="form-label">Unit Kerja</label></td>
                    <td>:</td>
                    <td>{{$pegawai->skpd}}</td>
                </tr>
            </table>

            <table width="100%" style="margin-top:15px;border: 1px solid #1f1d1d;background-color:rgb(43, 170, 209);">
                <tr>
                    <td>Riwayat Pendidikan</td>
                </tr>
            </table>
            <table width="100%" class="table table-bordered" style="border: 1px solid #1f1d1d;font-size:13px;">

                <tr>
                    <th width="3%">No</th>
                    <th width="10%">Pendidikan</th>
                    <th width="20%">Jurusan</th>
                    <th width="30%">Nama Sekolah</th>
                    <th width="22%">No. Ijazah</th>
                    <th width="12%">Ijazah</th>
                </tr>

                @foreach($pendidikan as $no=>$pd)
                <tr valign="top">
                    @if($id_indikator==3 && $no==0)
                    <td style='text-align:center;color:red;'>{{$no+1}}</td>
                    <td style='color:red;'>{{$pd['nama_tk_pendidikan']}}</td>
                    <td style='color:red;'>{{$pd['nama_detail_pendidikan']}}</td>
                    <td style='color:red;'>{{$pd['nama_sekolah']}}</td>
                    <td style='color:red;'>{{$pd['no_ijazah']}}</td>
                    @else
                    <td style='text-align:center;'>{{$no+1}}</td>
                    <td>{{$pd['nama_tk_pendidikan']}}</td>
                    <td>{{$pd['nama_detail_pendidikan']}}</td>
                    <td>{{$pd['nama_sekolah']}}</td>
                    <td>{{$pd['no_ijazah']}}</td>

                    @endif
                    <td>
                        @if($pd['file_upload'] != '')
                        <a href="{{route('lihatFile',['id_type'=>1,'id_peg'=>$pd['id_pegawai'],'id_riw'=>$pd['id_pendidikan']])}}" class="btn btn-primary btn-sm">Lihat File</a>
                        @else
                        -
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>

            <table width="100%" style="margin-top:15px;border: 1px solid #1f1d1d;background-color:rgb(43, 170, 209);">
                <tr>
                    <td>Riwayat Diklat Struktural</td>
                </tr>
            </table>
            @if($diklat_str != null && count($diklat_str) > 0)
            <table width="100%" class="table table-bordered" style="border: 1px solid #1f1d1d;font-size:13px;">

                <tr>
                    <th width="3%">No</th>
                    <th width="20%">Nama Diklat</th>
                    <th width="12%">Tempat Diklat</th>
                    <th width="22%">Penyelenggara</th>
                    <th width="5%">Tahun</th>
                    <th width="10%">Mulai</th>
                    <th width="10%">Selesai</th>
                    <th width="6%">Jam</th>
                    <th width="10%">Sertifikat</th>
                </tr>
                @php
                $year_sy = date('Y')-1;
                @endphp
                @foreach($diklat_str as $num=>$d)

                <tr>
                    @if($id_indikator==5 && $year_sy==$d['anggaran'])
                    <td style='text-align:center;color:red;'>{{$num+1}}</td>
                    <td style='color:red;'>{{$d['nama_diklat']}}</td>
                    <td style='color:red;'>{{$d['tempat_diklat']}}</td>
                    <td style='color:red;'>{{$d['penyelenggara']}}</td>
                    <td style='color:red;'>{{$d['anggaran']}}</td>
                    <td style='color:red;'>{{$d['mulai']}}</td>
                    <td style='color:red;'>{{$d['selesai']}}</td>
                    <td style='color:red;'>{{$d['lama']}}</td>
                    @else
                    <td style='text-align:center;'>{{$num+1}}</td>
                    <td>{{$d['nama_diklat']}}</td>
                    <td>{{$d['tempat_diklat']}}</td>
                    <td>{{$d['penyelenggara']}}</td>
                    <td>{{$d['anggaran']}}</td>
                    <td>{{$d['mulai']}}</td>
                    <td>{{$d['selesai']}}</td>
                    <td>{{$d['lama']}}</td>
                    @endif
                    <td>
                        @if($d['file_asli'] != '')
                        <a href="{{route('lihatFile',['id_type'=>2,'id_peg'=>$d['id_pegawai'],'id_riw'=>$d['id_riwayat_diklat_struktural']])}}" class="btn btn-primary btn-sm">Lihat File</a>
                        @else
                        -
                        @endif
                    </td>
                </tr>
                @endforeach
            </table>
            @endif
        </div>

        <table width="100%" style="margin-top:15px;border: 1px solid #1f1d1d;background-color:rgb(43, 170, 209);">
            <tr>
                <td>Riwayat Diklat Lainnya</td>
            </tr>
        </table>
        @if($diklat_lainnya != null && count($diklat_lainnya) > 0)
        <table width="100%" class="table table-bordered" style="border: 1px solid #1f1d1d;font-size:13px;">
            <tr>
                <th width="3%">No</th>
                <th width="20%">Nama Diklat</th>
                <th width="12%">Tempat Diklat</th>
                <th width="22%">Penyelenggara</th>
                <th width="5%">Tahun</th>
                <th width="10%">Mulai</th>
                <th width="10%">Selesai</th>
                <th width="6%">Jam</th>
                <th width="10%">Sertifikat</th>
            </tr>
            @foreach($diklat_lainnya as $number=> $ddl)
            <tr>
                @if($id_indikator==5 && $year_sy==$ddl['anggaran'])
                <td style='text-align:center;color:red;'>{{$number+1}}</td>
                <td style='color:red;'>{{$ddl['nama_diklat']}}</td>
                <td style='color:red;'>{{$ddl['tempat_diklat']}}</td>
                <td style='color:red;'>{{$ddl['penyelenggara']}}</td>
                <td style='color:red;'>{{$ddl['anggaran']}}</td>
                <td style='color:red;'>{{$ddl['mulai']}}</td>
                <td style='color:red;'>{{$ddl['selesai']}}</td>
                <td style='color:red;'>{{$ddl['lama']}}</td>
                @else
                <td>{{$number+1}}</td>
                <td>{{$ddl['nama_diklat']}}</td>
                <td>{{$ddl['tempat_diklat']}}</td>
                <td>{{$ddl['penyelenggara']}}</td>
                <td>{{$ddl['anggaran']}}</td>
                <td>{{$ddl['mulai']}}</td>
                <td>{{$ddl['selesai']}}</td>
                <td>{{$ddl['lama']}}</td>
                @endif
                <td>
                    @if($ddl['file_asli'] != '')
                    <a href="{{route('lihatFile',['id_type'=>3,'id_peg'=>$ddl['id_pegawai'],'id_riw'=>$ddl['id_riwayat_diklat_lainnya']])}}" class="btn btn-primary btn-sm">Lihat File</a>
                    @else
                    -
                    @endif
                </td>
            </tr>
            @endforeach
        </table>
        @endif

        <table width="100%" style="margin-top:15px;border: 1px solid #1f1d1d;background-color:rgb(43, 170, 209);">
            <tr>
                <td>Riwayat Hukuman Disiplin</td>
            </tr>
        </table>
        <table width="100%" class="table table-bordered" style="border: 1px solid #1f1d1d;font-size:13px;">
            <tr>
                <th width="3%">No</th>
                <th width="20%">Tingkat Hukuman Disiplin</th>
                <th width="25%">Jenis Hukuman Disiplin</th>
                <th width="12%">Nomor SK</th>
                <th width="10%">Tanggal SK</th>
                <th width="10%">TMT Awal</th>
                <th width="10%">TMT Akhir</th>
                <th width="12%">File SK</th>
            </tr>
            @if($hukdis != null && count($hukdis) > 0)

            @foreach($hukdis as $idx=> $hd)
            <tr>
                @if($id_indikator==9)
                <td style='text-align:center;color:red ;'>{{$idx+1}}</td>
                <td style='color:red;'>{{$hd['jenis_hukuman']}}</td>
                <td style='color:red;'>{{$hd['sub_jenis_hukuman']}}</td>
                <td style='color:red;'>{{$hd['no_sk']}}</td>
                <td style='color:red;'>{{$hd['tgl_sk']}}</td>
                <td style='color:red;'>{{$hd['tmt']}}</td>
                <td style='color:red;'>{{$hd['tmt_akhir']}}</td>
                @else
                <td>{{$idx+1}}</td>
                <td>{{$hd['jenis_hukuman']}}</td>
                <td>{{$hd['sub_jenis_hukuman']}}</td>
                <td>{{$hd['no_sk']}}</td>
                <td>{{$hd['tgl_sk']}}</td>
                <td>{{$hd['tmt']}}</td>
                <td>{{$hd['tmt_akhir']}}</td>
                @endif
                <td>
                    @if($hd['file_upload'] != '')
                    <a href="{{route('lihatFile',['id_type'=>4,'id_peg'=>$hd['id_pegawai'],'id_riw'=>$hd['id_riwayat_hd']])}}" class="btn btn-primary btn-sm">Lihat File</a>
                    @else
                    -
                    @endif
                </td>
            </tr>
            @endforeach
            @else
            <tr>
                <td colspan="8" style="text-align:center;">Tidak ada data</td>
            </tr>
            @endif
        </table>
    </div>

</div>
</div>
<script>
    $(document).ready(function() {
        // alert('tes');
    });
</script>
@endsection