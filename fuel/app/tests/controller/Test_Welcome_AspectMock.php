<?php

use AspectMock\Test as Aspect;
use Service\Remote;
use GuzzleHttp\Client;
use Fuel\Core\HttpNotFoundException;
use Fuel\Core\Response;

/**
 * Tests for Welcome controller
 *
 * @group App
 * @group Controller
 */
class Test_Welcome_AspectMock extends Base_Test
{
    public function test_index_return_view()
    {
        $service = Aspect::double(Remote::class, ['getIp' => '127.0.0.1']);

        $response = Request::forge('welcome/index')
            ->set_method('GET')
            ->execute()
            ->response();
        $view = $response->body();

        // Then
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->status);
        $this->assertInstanceOf(View::class, $view);
        $this->assertContains('welcome/index', $this->getObjectProperty($view, 'file_name'));
        $this->assertArrayHasKey('data', $view->get());
    }

    public function test_use_new_return_data()
    {
        $service = Aspect::double(Remote::class, ['nonStatic' => 'ok']);

        $response = Request::forge('welcome/new')
            ->set_method('GET')
            ->execute()
            ->response();

        $service->verifyInvoked('nonStatic', ['ip']);
        $this->assertEquals('ok', $response->body());
    }

    public function test_index_return_400_bad_request()
    {
        // Given
        $service = Aspect::double(Remote::class, ['getIp' => false]);

        // When
        $response = Request::forge('welcome/index')
            ->set_method('GET')
            ->execute()
            ->response();

        // Then
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(400, $response->status);
    }

    public function test_index_post_return_default_string()
    {
        $response = Request::forge('welcome/index')
            ->set_method('POST')
            ->execute()
            ->response();

        $this->assertEquals('Reverse string', $response->body());
    }

    public function test_index_post_return_correct_string()
    {
        $response = Request::forge('welcome/index')
            ->set_method('POST')
            ->set_post('message', 'Hello world!')
            ->execute()
            ->response();

        $this->assertEquals('!dlrow olleH', $response->body());
    }

    public function test_hello_return_presenter()
    {
        $response = Request::forge('welcome/hello')
            ->set_method('GET')
            ->execute()
            ->response();
        $presenter = $response->body();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->status);
        $this->assertInstanceOf(Presenter::class, $presenter);
        $this->assertContains('welcome/hello', $this->getObjectProperty($presenter->get_view(), 'file_name'));
    }

    public function test_return_404()
    {
        $response = Request::forge('welcome/404')
            ->set_method('GET')
            ->execute()
            ->response();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(404, $response->status);
        $this->assertInstanceOf(Presenter::class, $response->body());
        $this->assertContains('welcome/notfound', $this->getObjectProperty($response->body()->get_view(), 'file_name'));
    }

    public function test_redirect()
    {
        // Replace Response::redirect() with a test double which only returns true
        // NOTE: using full class name (with namespace) when double a class
        // e.g. using 'Fuel\Core\Response' instead of 'Response'
        $res = Aspect::double(Response::class, ['redirect' => true]);

        // Execute a request to 'test/redirect'
        Request::forge('welcome/redirect')
            ->set_method('GET')
            ->execute()
            ->response();

        // Confirm Response::redirect() was invoked with arguments below
        $res->verifyInvoked('redirect', ['welcome/404']);
    }
}
