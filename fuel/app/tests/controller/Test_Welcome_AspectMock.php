<?php

use AspectMock\Test as Aspect;

/**
 * Tests for Controller_Test
 *
 * @group App
 * @group Controller
 */
class Test_Welcome_AspectMock extends BaseTestCase
{
    protected function tearDown()
    {
        Aspect::clean(); // Remove all registered test doubles
    }

    public function test_redirect()
    {
        // replace Response::redirect() with a test double which only returns true
        $req = Aspect::double('Fuel\Core\Response', ['redirect' => true]);

        // generate a request to 'test/redirect'
        $response = Request::forge('welcome/redirect')
            ->set_method('GET')
            ->execute()
            ->response();

        // confirm Response::redirect() was invoked with arguments below
        $req->verifyInvoked('redirect', ['welcome/404']);
    }

}
