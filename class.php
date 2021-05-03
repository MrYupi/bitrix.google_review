<?php
if(!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
use \Bitrix\Main\Loader;
use \Bitrix\Main\Application;

class GoogleReviewBitrix extends CBitrixComponent
{


    private function _checkModules()
    {
        if (!Loader::includeModule('main'))
        {
            throw new \Exception('Не загружены модули необходимые для работы модуля');
        }

        return true;
    }

    /**
     * @throws Exception
     */
    public function onPrepareComponentParams($arParams)
    {

        $arParams['MAP_KEY'] = $arParams['MAP_KEY'] ?
            $arParams['MAP_KEY'] :
            \Bitrix\Main\Config\Option::get('fileman', 'google_map_api_key');
        if(!$arParams['PLACE_ID'])
        {
            throw new \Exception('Не задан ID места');
        }
        if(!$arParams['MAP_KEY'])
        {
            throw new \Exception('Не задан ключ для карты');
        }
        return $arParams;
    }

    private function collectData()
    {
        $return = [];
        $url = 'https://maps.googleapis.com/maps/api/place/details/json';
        $options = [
            'socketTimeout' => 10,
            'streamTimeout' => 20,
            'compress'      => true,
        ];
        $query = http_build_query([
            'placeid' => $this->arParams['PLACE_ID'],
            'key' => $this->arParams['MAP_KEY'],
            //TODO поискать что нибудь адекватное для получения языка сайта
            'language' => strtolower(LANGUAGE_ID)
        ]);
        $client = new Bitrix\Main\Web\HttpClient($options);
        $client->setHeader('Content-Type', "application/json");
        $client->setHeader('Content-Language', "ru");
        $client->query('GET', $url . '?' . $query);
        $client->getResult();
        if (in_array($client->getStatus(), [200, 204]))
        {
            $headers = $client->getHeaders();
            if($headers->getContentType() == 'application/json')
            {
                $result = $client->getResult();
                $result = json_decode($result, true);
                if(is_array($result['result']['reviews']) && count($result['result']['reviews']))
                {
                    foreach ($result['result']['reviews'] as $review)
                    {
                        $return[] = $review;
                    }
                }
            }
        }
        return $return;
    }

    public function executeComponent()
    {
        if($this->startResultCache($this->arParams['CACHE_TIME'], false))
        {
            $this->arResult['ITEMS'] = $this->collectData();
        }
        if($this->arParams['LOAD_TEMPLATE'] == 'Y')
        {
            $this->includeComponentTemplate();
        }

    }

    public static function debug($item)
    {
        echo '<pre style="background: black; padding: 10px; color: white">';
        print_r($item);
        echo '</pre>';
    }
}