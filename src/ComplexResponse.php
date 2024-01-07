<?php
namespace L2Iterative\MockWebServerExt;

use donatj\MockWebServer\RequestInfo;
use donatj\MockWebServer\Response;
use donatj\MockWebServer\ResponseInterface;
use L2Iterative\MockWebServerExt\Matcher\MatcherInterface;

class ComplexResponse implements ResponseInterface
{

    public array $expectations;

    public Response $answer;


    public function __construct()
    {
        $this->expectations = [];
        $this->answer       = new Response('', [], 418);

    }//end __construct()


    public function then(Response $answer): self
    {
        $this->answer = $answer;
        return $this;

    }//end then()


    public function when_path_is(string|MatcherInterface $matcher): self
    {
        $this->expectations[] = new Expectation\PathIs($matcher);
        return $this;

    }//end when_path_is()


    public function when_method_is(string|MatcherInterface $matcher): self
    {
        $this->expectations[] = new Expectation\MethodIs($matcher);
        return $this;

    }//end when_method_is()


    public function when_query_param_is(string $method, string $param, string|MatcherInterface $matcher): self
    {
        $this->expectations[] = new Expectation\QueryParamIs($method, $param, $matcher);
        return $this;

    }//end when_query_param_is()


    public function when_query_param_exists(string $method, string $param): self
    {
        $this->expectations[] = new Expectation\QueryParamExists($method, $param);
        return $this;

    }//end when_query_param_exists()


    public function when_query_param_not_exists(string $method, string $param): self
    {
        $this->expectations[] = new Expectation\QueryParamNotExists($method, $param);
        return $this;

    }//end when_query_param_not_exists()


    public function when_header_is(string $name, string|MatcherInterface $matcher): self
    {
        $this->expectations[] = new Expectation\HeaderIs($name, $matcher);
        return $this;

    }//end when_header_is()


    public function when_header_exists(string $name): self
    {
        $this->expectations[] = new Expectation\HeaderExists($name);
        return $this;

    }//end when_header_exists()


    public function when_header_not_exists(string $name): self
    {
        $this->expectations[] = new Expectation\HeaderNotExists($name);
        return $this;

    }//end when_header_not_exists()


    public function getRef(): string
    {
        return md5('ComplexResponse: '.var_dump([$this->answer, $this->expectations], true));

    }//end getRef()


    public function getBody(RequestInfo $request): string
    {
        return $this->getResponse($request)->getBody($request);

    }//end getBody()


    public function getHeaders(RequestInfo $request): array
    {
        return $this->getResponse($request)->getHeaders($request);

    }//end getHeaders()


    public function getStatus(RequestInfo $request): int
    {
        return $this->getResponse($request)->getStatus($request);

    }//end getStatus()


    private function getResponse(RequestInfo $request): Response
    {
        foreach ($this->expectations as $expectation) {
            if ($expectation->is_expected($request) === false) {
                return new Response('', [], 418);
            }
        }

        return $this->answer;

    }//end getResponse()


}//end class
