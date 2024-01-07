<?php
namespace L2Iterative\MockWebServerExt\Expectation;

/*
 * This file is extensively based on
 * https://github.com/InterNations/http-mock/blob/main/src/Expectation.php
 * https://github.com/InterNations/http-mock/blob/main/src/Matcher/ExtractorFactory.php
 */

use donatj\MockWebServer\RequestInfo;
use L2Iterative\MockWebServerExt\Matcher\MatcherInterface;
use L2Iterative\MockWebServerExt\Matcher\StringMatcher;

class HeaderIs implements ExpectationInterface
{

    public string $name;

    public MatcherInterface $matcher;


    public function __construct(string $name, string|MatcherInterface $matcher)
    {
        $this->name = $name;
        if ($matcher instanceof MatcherInterface === false) {
            $matcher = new StringMatcher($matcher);
        }

        $this->matcher = $matcher;

    }//end __construct()


    public function is_expected(RequestInfo $request): bool
    {
        $headers = $request->getHeaders();
        if (isset($headers[$this->name]) === true) {
            return $this->matcher->is_matched($headers[$this->name]);
        } else {
            return false;
        }

    }//end is_expected()


}//end class
