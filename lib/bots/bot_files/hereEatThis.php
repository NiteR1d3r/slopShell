<?php

namespace bots\bot_files;

use GuzzleHttp\Client;

class hereEatThis extends Client
{
    public function __construct(array $config = [])
    {
        parent::__construct($config);
    }
    public function chunkTransferFile( string $uri, array $options = [], array $botSpecific = [], string $fileName)
    {
        $options['multipart'] = [
            "name" => "file",
            "contents" => fopen($fileName, "r"),
        ];
        $options['headers']['Cookie'] = sprintf("cft=1; %s=%s; uuid=%s", $botSpecific['cname'], $botSpecific['cval'], $botSpecific['uuid']);
        $chunky = parent::put($uri, $options);
        if (hash_equals($chunky->getHeaderLine("MD5"), md5_file($fileName))){
            return "File upload success!";
        }else{
            return "File upload failure :(";
        }
    }

}