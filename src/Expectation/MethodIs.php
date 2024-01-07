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

class MethodIs implements ExpectationInterface
{

    public MatcherInterface $matcher;


    public function __construct(string|MatcherInterface $matcher)
    {
        if ($matcher instanceof MatcherInterface) {
            $this->matcher = $matcher;
        } else {
            $this->matcher = new StringMatcher($matcher);
        }

    }//end __construct()


    public function is_expected(RequestInfo $request): bool
    {
        return $this->matcher->is_matched($request->getRequestMethod());

    }//end is_expected()


}//end class
