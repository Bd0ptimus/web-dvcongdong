<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\service_type_name;
class ServiceTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $serviceTypes=[
            "Giấy tờ",
            "Y tế",
            "Giáo dục",
            "Du lịch",
            "Điện tử",
        ];

        DB::beginTransaction();
        try{
            foreach($serviceTypes as $serviceType)
            service_type_name::updateOrCreate([
                "service_name" => $serviceType
            ]);
            DB::commit();
        }catch(\Exception $e){
            Log::debug('service type seeder : '.$e);
            DB::rollBack();
        }
    }
}
