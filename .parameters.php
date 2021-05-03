<?php
if (!defined("B_PROLOG_INCLUDED") || B_PROLOG_INCLUDED!==true) die();
$arComponentParameters = [
    'PARAMETERS' => [
        'PLACE_ID' => [
            "PARENT" => "BASE",
            "NAME" => 'ИД места на google map (можно получиьт по ссылке https://developers.google.com/maps/documentation/places/web-service/place-id)',
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "REFRESH" => "N",
            "MULTIPLE" => "N",
            "VALUES" => [],
            "ADDITIONAL_VALUES" => "N",
            "SIZE" => "1",
        ],
        'MAP_KEY' => [
            "PARENT" => "BASE",
            'NAME' => 'Ключ к google api(если не задан, берется из настроек модуля управления структурой)',
            "TYPE" => "STRING",
            "DEFAULT" => "",
            "REFRESH" => "N",
            "MULTIPLE" => "N",
            "ADDITIONAL_VALUES" => "N",
            "SIZE" => "1",
        ],
        'ENABLE_COMPONENT' => [
            "PARENT" => "BASE",
            'NAME' => 'Включить компонент',
            "TYPE" => "LIST",
            "DEFAULT" => "Y",
            "REFRESH" => "N",
            "MULTIPLE" => "N",
            "VALUES" => [
                'Y' => 'Да',
                'N' => 'Нет',
            ],
            "ADDITIONAL_VALUES" => "N",
            "SIZE" => "1",
        ],
        'CACHE_TIME' => [
            "PARENT" => "BASE",
            'NAME' => 'Время кеширования',
            "TYPE" => "STRING",
            "DEFAULT" => "36000",
            "REFRESH" => "N",
            "MULTIPLE" => "N",
            "ADDITIONAL_VALUES" => "N",
            "SIZE" => "1",
        ]
    ]
];