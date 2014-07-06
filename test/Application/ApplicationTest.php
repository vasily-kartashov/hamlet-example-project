<?php

namespace Application;

use Hamlet\Request\RequestBuilder;
use Hamlet\Response\OKOrNotModifiedResponse;
use UnitTestCase;

class ApplicationTest extends UnitTestCase
{
    public function testRequest()
    {
        $request = (new RequestBuilder())->setPath('/')->setParameter('name', 'Ivan')->getRequest();
        $application = new Application();
        $response = $application->run($request);

        $this->assertTrue($response instanceof OKORNotModifiedResponse);
        /** @var $response OKORNotModifiedResponse */
        $this->assertEqual($response->getEntity()->getContent(), '"Hello, Ivan!"');
    }
}