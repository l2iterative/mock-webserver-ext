<?php
namespace L2Iterative\MockWebServerExt\Expectation;

/*
 * This file is extensively based on
 * https://github.com/InterNations/http-mock/blob/main/src/Expectation.php
 * https://github.com/InterNations/http-mock/blob/main/src/Matcher/ExtractorFactory.php
 */

use donatj\MockWebServer\RequestInfo;

class QueryParamExists implements ExpectationInterface
{

    public string $method;

    public string $param;


    public function __construct(string $method, string $param)
    {
        $this->method = $method;
        $this->param  = $param;

    }//end __construct()


    public function is_expected(RequestInfo $request): bool
    {
        if ($this->method === 'GET') {
            return isset($request->getGet()[$this->param]);
        } else if ($this->method === 'POST') {
            $headers = $request->getHeaders();

            if (isset($headers['content-type']) === true && $headers['content-type'] === 'application/json') {
                $post = json_decode($request->getInput(), true);
            } else {
                $post = $request->getPost();
            }

            return isset($post[$this->param]);
        } else {
            return false;
        }

    }//end is_expected()


}//end class
