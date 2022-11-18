<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use App\Models\service;
use App\Models\classify;


class ClassifyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $classifies=[
            [
                "lower"=>"Nhà đất",
                "upper"=>"NHÀ ĐẤT"
            ],
            [
                "lower"=>"Dịch vụ",
                "upper"=>"DỊCH VỤ"
            ],
            [
                "lower"=>"Việc làm",
                "upper"=>"VIỆC LÀM"
            ],
            [
                "lower"=>"Mua bán xe cộ",
                "upper"=>"MUA BÁN XE CỘ"
            ],
            [
                "lower"=>"May mặc",
                "upper"=>"MAY MẶC"
            ],
            [
                "lower"=>"Mẹ và bé",
                "upper"=>"MẸ VÀ BÉ"
            ],
            [
                "lower"=>"Nhà hàng",
                "upper"=>"NHÀ HÀNG"
            ],
            [
                "lower"=>"Rao vặt, quảng cáo",
                "upper"=>"RAO VẶT, QUẢNG CÁO"
            ],
        ];

        DB::beginTransaction();
        try{
            foreach($classifies as $classify)
            classify::updateOrCreate([
                "classify_name" => $classify['lower'],
                "classify_name_upper" => $classify['upper'],
            ]);
            DB::commit();
        }catch(\Exception $e){
            Log::debug('Classify seeder : '.$e);
            DB::rollBack();
        }
    }
}
