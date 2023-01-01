<?php

//Notifications
const NEXMO_KEY="22bff0b2";
const NEXMO_API_SECRETE = "7HIsWOC2orXt0ZMd";

//User_status
const USER_ACTIVATED = 1;
const USER_SUSPENDED = 0;
//ROLE USER
const ROLE_SUPER_ADMIN=1;
const ROLE_ADMIN=2;
const ROLE_USER=3;

//new feed step
const NEW_FEED_LOAD_STEP=5;
const NUMBER_POST_MOST_ACCESSED = 5;
const NUMBER_COMMENT_IN_STEP = 5;

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
const NOT_INTERACT = 0;
const LIKE=1;


//CHECKING SERVICE
const CAR_TICKET_TYPE=1;
const ADMINISTRATIVE_TYPE=2;
const TAX_DEBT_TYPE=3;
const ENTRY_BAN_TYPE=4;

//CHECKING STATUS
const CHECK_REQUEST_CREATED=1;
const CHECK_REQUEST_COMPLETED=2;

//CHECKING RESPONSE REQUIREMENTS
const RESPONSE_VIA_EMAIL = 1;
const RESPONSE_VIA_PHONE = 2;


//Currency URLs
const USD_RUB_EXCHANGE_URL = "https://www.investing.com/currencies/usd-rub";
const USD_VND_EXCHANGE_URL = "https://www.investing.com/currencies/usd-vnd";
const BTC_USD_EXCHANGE_URL = "https://www.investing.com/crypto/bitcoin/btc-usd";
const ETH_USD_EXCHANGE_URL = "https://www.investing.com/crypto/ethereum";


//Web cookie time valid
const COOKIE_TIME_VALID = 43200;

//Third party types
const SYSTEM = 0;
const GOOGLE = 1;
const FACEBOOK = 2;
const VK = 3;
const ZALO = 4;


//POST COMMENT
const COMMENT_ACCEPTED = 1;
const COMMENT_PENDING=0;
const COMMENT_REJECTED = 2;


//Post Image Path
const POST_IMAGE_DIR = 'storage/post_attachments/';
