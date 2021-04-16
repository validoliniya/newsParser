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
                $header        = $item->plaintext;
                $position      = strripos($header, ',');
                $header        = substr($header, 0, $position);
                $news[$header] = self::parseNewsPage($item->attr['href']);
            }
        }

        return $news;

    }

    public static function parseNewsPage(string $url): array
    {
        $pageElements = [];
        $text         = '';
        $document     = Parser::getHtmlDocument($url);
        $dateSpan     = $document->find(' span [class=article__header__date]', 0);
        if ($dateSpan) {
            $date = new \DateTime();
            $date->setTimestamp(strtotime($dateSpan->attr['content']));
            $pageElements['date'] = $date;
        }

        $mainImage = $document->find(' div [class=article__main-image__wrap] img', 0);
        if ($mainImage) {
            $pageElements['img'] = [$mainImage->attr['src']];
        }

        foreach ($document->find(' div [itemprop=articleBody] p') as $paragraph) {
            $text .= $paragraph->plaintext . PHP_EOL;
        }

        foreach ($document->find(' div [itemprop=articleBody] section') as $section) {
            $text .= $section->plaintext . PHP_EOL;
        }

        $pageElements['text'] = $text;

        return $pageElements;
    }

}