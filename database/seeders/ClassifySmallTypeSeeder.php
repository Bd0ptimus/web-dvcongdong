<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\classify_types;
use App\Models\classify;

class ClassifySmallTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types=[
            [
                "type_name" => "Giấy tờ",
                "classify" =>"Dịch vụ"
            ],
            [
                "type_name" => "Y tế",
                "classify" =>"Dịch vụ"
            ],
            [
                "type_name" => "Giáo dục",
                "classify" =>"Dịch vụ"
            ],
            [
                "type_name" => "Du lịch",
                "classify" =>"Dịch vụ"
            ],
            [
                "type_name" => "Điện tử",
                "classify" =>"Dịch vụ"
            ],
        ];

        DB::beginTransaction();
        try{
            foreach($types as $type){
                classify_types::updateOrCreate([
                    "type_name"=>$type['type_name'],
                    "classify_id"=>classify::where('classify_name',$type['classify'])->first()->id,
                ]);
            }
            DB::commit();
        }catch(\Exception $e){
            Log::debug('classify snall type seeder : '.$e);
            DB::rollBack();
        }
    }
}
