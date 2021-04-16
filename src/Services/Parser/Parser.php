<?php

namespace App\Services\Parser;

use simplehtmldom\HtmlDocument;
use Symfony\Component\HttpClient\HttpClient;

class Parser
{

    public static function getHtmlDocument(string $url): HtmlDocument
    {
        $client   = HttpClient::create();
        $response = $client->request('GET', $url)->getContent();

        return new HtmlDocument($response);
    }
}