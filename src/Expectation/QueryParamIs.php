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

class QueryParamIs implements ExpectationInterface
{

    public string $method;

    public string $param;

    public MatcherInterface $matcher;


    public function __construct(string $method, string $param, string|MatcherInterface $matcher)
    {
        $this->method = $method;
        $this->param  = $param;
        if ($matcher instanceof MatcherInterface === false) {
            $matcher = new StringMatcher($matcher);
        }

        $this->matcher = $matcher;

    }//end __construct()


    public function is_expected(RequestInfo $request): bool
    {
        if ($this->method === 'GET') {
            $get = $request->getGet();

            if (isset($get[$this->param]) === true) {
                return $this->matcher->is_matched($get[$this->param]);
            } else {
                return false;
            }
        } else if ($this->method === 'POST') {
            $headers = $request->getHeaders();

            if (isset($headers['content-type']) === true && $headers['content-type'] === 'application/json') {
                $post = json_decode($request->getInput(), true);
            } else {
                $post = $request->getPost();
            }

            if (isset($post[$this->param]) === true) {
                return $this->matcher->is_matched($post[$this->param]);
            } else {
                return false;
            }
        } else {
            return false;
        }//end if

    }//end is_expected()


}//end class
