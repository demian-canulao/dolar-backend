<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Carbon\Carbon;
use App\Models\DollarValue;

class DollarService
{
    protected $baseUrl = "https://mindicador.cl/api/dolar/";


    public function syncYear(int $year):int
    {
        $url = $this->baseUrl . $year;

        $res = Http::timeout(10)->retry(3, 100)->get($url);

        if(!$res->ok()){
            throw new \RuntimeException("Error al obtener datos {$url} (status {$res->status()})");
        }

        $json = $res->json();

        if(!isset($json['serie']) || !is_array($json['serie'])){
            return 0;
        }

        $rows = [];

        foreach($json['serie'] as $item){
            $date = Carbon::parse($item['fecha'])->toDateString();
            $value = (float) ($item['valor'] ?? 0);

            $rows[] = [
                'date' => $date,
                'value' => $value,
                'source' => 'mindicador',
                'updated_at' => now(),
                'created_at' => now()
            ];

        }

        if(empty($rows)){
            return 0;
        }

        $uniqueBy = ['date'];

        $update = ['value', 'source', 'updated_at'];

        DollarValue::upsert($rows, $uniqueBy, $update);

        return count($rows);
    }


    public function syncYears(int $fromYear, int $toYear):int
    {
        $count = 0;
        for($y = $fromYear; $y <= $toYear; $y++){
            $count += $this->syncYear($y);
        }

        return $count;

    }

}
