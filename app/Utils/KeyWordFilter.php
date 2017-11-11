<?php

namespace App\Utils;

use App\Keyword;

/**
 * Created by PhpStorm.
 * User: 苏锐佳
 * Date: 2016/11/27
 * Time: 20:47
 */
class KeyWordFilter
{
    public function filter($content = '')
    {
        $options = 'Any-Latin; Latin-ASCII; NFD; [:Nonspacing Mark:] Remove; NFC;';

        // 获取所有关键字
        $keywords = Keyword::orderBy('count', 'desc')
            ->orderBy('created_at', 'desc')
            ->get();

        foreach ($keywords as $keyword) {

            // 中文查找
            $tmp = strpos($content, $keyword->name);
            if (!is_bool($tmp)) {
                $keyword->count = $keyword->count + 1;
                $keyword->save();
                return $keyword->name;
            }

            // 中文关键字转拼音
            $keywordPY[0] = transliterator_transliterate($options, $keyword->name);
            $keywordPY[1] = implode('', explode(' ', $keywordPY[0]));
            // 拼音查找
            foreach ($keywordPY as $item) {
                $tmp = stripos($content, $item);
                if (!is_bool($tmp)) {
                    $keyword->count = $keyword->count + 1;
                    $keyword->save();
                    return $keyword->name;
                }
            }
        }

        return -1;

    }
}