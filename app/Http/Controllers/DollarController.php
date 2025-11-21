<?php

namespace App\Http\Controllers;

use App\Models\DollarValue;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class DollarController extends Controller
{
    public function index(Request $request)
    {
        $data = $request->validate([
            'from' => ['required', 'date_format:Y-m-d'],
            'to' => ['required', 'date_format:Y-m-d'],
        ]);

        $data = $request->all();

        $start = $data['from'];
        $end = $data['to'];

        if($start > $end){
            throw ValidationException::withMessages(['start' => 'Comienzo debe ser igual o menor a final']);
        }

        $rows = DollarValue::whereBetween('date', [$start, $end])
            ->orderBy('date', 'DESC')
            ->get(['date', 'value']);

        return response()->json($rows);

    }
}
