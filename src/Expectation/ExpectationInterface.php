<?php

namespace L2Iterative\MockWebServerExt\Expectation;

use donatj\MockWebServer\RequestInfo;

interface ExpectationInterface
{


    public function is_expected(RequestInfo $request): bool;


}//end interface
