<?php

namespace App\View\Components;

use App\Models\RefJabatan;
use App\Models\RefSkpd;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class filterskpd extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        $dskpd = RefSkpd::where('status', '=', 1)
            ->whereRaw('length(kode_skpd)=3 OR length(kode_skpd)=1')
            ->orderBy('skpd')->get();

        $refjab = RefJabatan::where('status', '=', 1)
            ->select('id_jabatan', 'jabatan')
            ->orderBy('jabatan')->get();

        //return view('components.filters', compact('dskpd'));
        return view(view: 'components.filterskpd', data: compact('dskpd', 'refjab'));
    }
}
