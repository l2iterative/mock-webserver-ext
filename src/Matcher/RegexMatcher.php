<?php
namespace L2Iterative\MockWebServerExt\Matcher;

// This file is extensively based on
// https://github.com/InterNations/http-mock/blob/main/src/Matcher/RegexMatcher.php
class RegexMatcher implements MatcherInterface
{

    public string $regex;


    public function __construct(string $regex)
    {
        $this->regex = $regex;

    }//end __construct()


    public function is_matched(string $str): bool
    {
        return preg_match($this->regex, $str);

    }//end is_matched()


}//end class
