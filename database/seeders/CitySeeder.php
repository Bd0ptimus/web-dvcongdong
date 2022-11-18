<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\city;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $cities=[
            "Moskva",
            "Sankt-Peterburg",
            "Yekaterinburg",
            "Volgograd",
            "Vladivostok",
            "Tula",
            "Kazan",
        ];

        DB::beginTransaction();
        try{
            foreach($cities as $city)
            city::updateOrCreate([
                "city" => $city
            ]);
            DB::commit();
        }catch(\Exception $e){
            Log::debug('City seeder : '.$e);
            DB::rollBack();
        }
    }
}
