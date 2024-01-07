<?php

namespace L2Iterative\MockWebServerExt\Matcher;

// This file is extensively based on
// https://github.com/InterNations/http-mock/blob/main/src/Matcher/StringMatcher.php
class StringMatcher implements MatcherInterface
{

    public string $str;


    public function __construct(string $str)
    {
        $this->str = $str;

    }//end __construct()


    public function is_matched(string $str): bool
    {
        return $str === $this->str;

    }//end is_matched()


}//end class
