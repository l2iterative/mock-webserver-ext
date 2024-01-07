<?php

namespace L2Iterative\MockWebServerExt\Tests;

use donatj\MockWebServer\RequestInfo;
use L2Iterative\MockWebServerExt\ComplexResponse;
use donatj\MockWebServer\Response;
use L2Iterative\MockWebServerExt\Matcher\RegexMatcher;
use PHPUnit\Framework\TestCase;

class IntegrationTest extends TestCase {
    public function test_integration() {
        $complex_response = new ComplexResponse();
        $complex_response->when_path_is('/api/users')
                ->when_method_is('POST')
                ->when_header_is('x-api-key', new RegexMatcher("/^mock/"))
                ->when_header_exists('x-api-version')
                ->when_header_not_exists('x-api-version-old')
                ->when_query_param_is('GET','session_uid', new RegexMatcher('/^s/'))
                ->when_query_param_exists('POST', 'image')
                ->when_query_param_not_exists('POST', 'debug')
                ->then(new Response('{"id": 1, "name": "John Doe"}', [], 200));

        $request = new RequestInfo(
            array(
                'REQUEST_URI' => '/api/users?session_uid=s1',
                'REQUEST_METHOD' => 'POST',
            ),
            array(
                'session_uid' => 's1'
            ),
            array(
                'image' => '1',
            ),
            [],
            [],
            array(
                'x-api-key' => 'mock-api-key',
                'x-api-version' => '0.19.1'
            ),
        'x-api-key=mock-api-key&x-api-version=0.19.1'
        );

        $this->assertEquals(200, $complex_response->getStatus($request));
    }
}