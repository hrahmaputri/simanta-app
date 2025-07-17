<nav id="sidebar">
    <div class="sidebar-header">
        <table width="100%">
            <tr>
                <td style="padding:3px;text-align:center">
                    <img src="{{URL::asset('img/Logo Simeta Putih.png')}}" width="80%" alt="Logo">
                </td>
            </tr>
            <tr>
                <td style='padding:10px;text-align:center;color:white;font-size:20px;'>
                    <p> {{getPengguna(session()->get('id_user'))}}</p>
                </td>
            </tr>
        </table>
    </div>

    @php
    $id_akses = session()->get('id_akses');
    @endphp
    @if($id_akses == 1)
    <ul class="list-unstyled components">
        <li>
            <a href="/sinkronisasi">Sinkronisasi Data</a>
        </li>
    </ul>
    @elseif($id_akses == 2)

    <ul class="list-unstyled components">
        <li>
            <a href="/sinkronisasi">Sinkronisasi Data</a>
        </li>
        <li>
            <a href="/indikator">Data Indikator</a>
        </li>
        <li>
            <a href="/kompetensi">Data Kompetensi</a>
        </li>
        <li>
            <a href="/target">Jabatan Target</a>
        </li>
        <li>
            <a href="/dapeg">Data Pegawai</a>
        </li>
        <li>
            <a href="/charts">Nine Box</a>
        </li>
    </ul>
    @endif

    <ul class="list-unstyled components">
        <li>
            <a href="/editpas">Edit Password</a>
        </li>
        <li>
            <a href="/logout">Keluar</a>
        </li>
    </ul>
</nav>