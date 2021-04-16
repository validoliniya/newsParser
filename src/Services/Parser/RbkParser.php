<?php

namespace App\Services\Parser;

class RbkParser
{
    public static function parseNewsBlock(string $url): array
    {
        $document     = Parser::getHtmlDocument($url);
        $newsFeedList = $document->find('.js-news-feed-list', 0);

        if (empty($newsFeedList)) {
            return [];
        }

        $news = [];
        foreach ($newsFeedList->children as $item) {
            if (isset($item->attr['href'])) {
                $news[$item->plaintext] = self::parseNewsPage($item->attr['href']);
            }
        }

        return $news;

    }

    public static function parseNewsPage(string $url): array
    {
        $pageElements = [];
        $text         = '';
        $imgSources   = [];
        $document     = Parser::getHtmlDocument($url);
        foreach ($document->find(' div [itemprop=articleBody] p') as $paragraph) {
            $text .= $paragraph->plaintext . ' ';
        }

        foreach ($document->find(' div [itemprop=articleBody] img') as $img) {
            $imgSources[] = $img->src;
        }

        $pageElements['text'] = $text;
        $pageElements['img']  = $imgSources;

        return $pageElements;
    }

}