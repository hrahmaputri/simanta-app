<?php

namespace App\View\Components;

use App\Http\Controllers\Support\DaftarApi;
use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class filters extends Component
{
    public function __construct()
    {
        //
    }

    public function render(): View|Closure|string
    {
        $jabatan = new DaftarApi();
        $refjab = $jabatan->apiJabatan();

        //return view('components.filters', compact('dskpd'));
        return view(view: 'components.filters', data: compact('refjab'));
    }
}
