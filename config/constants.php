<?php
const ROLE_SUPER_ADMIN=1;
const ROLE_ADMIN=2;
const ROLE_USER=3;

//new feed step
const NEW_FEED_LOAD_STEP=5;
//Post attachment
const POST_LOGO = 1;
const POST_DESCRIPTION_PHOTO = 2;
const POST_DOCUMENTS = 3;

//Classify
const REAL_ESTATE=16;
const SERVICE=17;
const JOB = 18;
const CAR_TRADE=19;
const GARMENT = 20;
const MOM_BABY=21;
const RESTAURANT=22;
const AD=23;

const CLASSIFY_SLUG = [
    'App\Models\real_estate'=> 'Nhà đất',
    'App\Models\service'=> 'Dịch vụ',
    'App\Models\job'=> 'Việc làm',
    'App\Models\car_trade'=> 'Mua bán xe cộ',
    'App\Models\garment'=> 'May mặc',
    'App\Models\mom_baby'=> 'Mẹ và bé',
    'App\Models\restaurant'=> 'Nhà hàng',
    'App\Models\classify_ads'=> 'Rao vặt và quảng cáo',
];

const SERVICE_TYPE_SLUG=[
    'App\Models\service_medical'=>'Y tế',
    'App\Models\service_document' => 'Giấy tờ',
    'App\Models\service_edu' =>'Giáo dục',
    'App\Models\service_travel' => 'Du lịch',
    'App\Models\service_electronic' => 'Điện tử',
];

const REAL_ESTATE_SLUG = 'App\Models\real_estate';
const SERVICE_SLUG = 'App\Models\service';
const JOB_SLUG = 'App\Models\job';
const CAR_TRADE_SLUG = 'App\Models\car_trade';
const GARMENT_SLUG = 'App\Models\garment';
const MOMBABY_SLUG = 'App\Models\mom_baby';
const RESTAURANT_SLUG = 'App\Models\restaurant';
const ADS_SLUG = 'App\Models\classify_ads';

//Classify_type
const SERVICE_DOCUMENT = 6;
const SERVICE_MEDICAL = 7;
const SERVICE_EDU = 8;
const SERVICE_TRAVEL = 9;
const SERVICE_ELECTRONIC = 10;

//Interaction types
const LIKE=1;

