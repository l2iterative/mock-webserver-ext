<?php

namespace L2Iterative\MockWebServerExt\Matcher;

interface MatcherInterface
{


    public function is_matched(string $str): bool;


}//end interface
