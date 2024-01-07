<?php
namespace L2Iterative\MockWebServerExt\Expectation;

/*
 * This file is extensively based on
 * https://github.com/InterNations/http-mock/blob/main/src/Expectation.php
 * https://github.com/InterNations/http-mock/blob/main/src/Matcher/ExtractorFactory.php
 */

use donatj\MockWebServer\RequestInfo;

class HeaderExists implements ExpectationInterface
{

    public string $name;


    public function __construct(string $name)
    {
        $this->name = $name;

    }//end __construct()


    public function is_expected(RequestInfo $request): bool
    {
        $headers = $request->getHeaders();
        return isset($headers[$this->name]);

    }//end is_expected()


}//end class
