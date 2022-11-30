<?php

namespace App\Services;

use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Str;
use Carbon\Carbon;
use Goutte\Client;
use Symfony\Component\DomCrawler\Crawler;
//model

//repo
use App\Repositories\UserRepository;

use Exception;
class UtilitiesService
{
    public function takeAllCurrencyExchangeForMain(){
        $response=[];
        $response['usd_rub'] = $this->takeLastExchangeAndChangeCurrency(USD_RUB_EXCHANGE_URL, 'span[data-test="instrument-price-last"]', 'span[data-test="instrument-price-change"]');
        $response['usd_vnd'] = $this->takeLastExchangeAndChangeCurrency(USD_VND_EXCHANGE_URL, 'span[data-test="instrument-price-last"]', 'span[data-test="instrument-price-change"]');
        $response['btc_usd'] = $this->takeLastExchangeAndChangeCurrency(BTC_USD_EXCHANGE_URL, 'span[data-test="instrument-price-last"]', 'span[data-test="instrument-price-change"]');
        $response['eth_usd'] = $this->takeLastExchangeAndChangeCurrency(ETH_USD_EXCHANGE_URL, '#last_last', 'span.pid-1061443-pc');

        return $response;
    }

    private function takeLastExchangeAndChangeCurrency($url, $filterForLast, $filterForChange){
        $data['last']='';
        $data['change']='';
        $client = new Client();
        $crawler = $client->request('GET', $url);
        $data['last'] = $crawler->filter($filterForLast)->each(
             function (Crawler $node) {
                return $node->text();

            }
        )[0];
        $data['change'] =  $crawler->filter($filterForChange)->each(
            function (Crawler $node) {
                return $node->text();
            }
        )[0];
        return $data;
    }

}
