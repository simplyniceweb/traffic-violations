<?php

namespace App\Http\Controllers;

use App\Models\Province;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index() {
        $provinces = Province::with('region')->orderBy('province_name')->paginate(10);
        return view('provinces.index', ['provinces' => $provinces]);
    }
}
