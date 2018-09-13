<?php

use GuzzleHttp\Client;
use GuzzleHttp\Handler\MockHandler;
use GuzzleHttp\HandlerStack;
use GuzzleHttp\Psr7\Response as GuzzleResponse;
use Fuel\Core\HttpNotFoundException;
use Controller\Welcome;

class Test_Welcome extends BaseTestCase
{
    private $guzzleMockHandler;

    private $request;

    public function setUp()
    {
        parent::setUp();

        // Mock http client
        // Ref: http://docs.guzzlephp.org/en/stable/testing.html
        $this->guzzleMockHandler = new MockHandler();
        $client = new Client(['handler' => HandlerStack::create($this->guzzleMockHandler)]);

        // Binding httpclient to mock object
        // Only when test
        Container::add('httpclient', $client);

        // Active base request
        $this->request = Request::forge();
        Request::active($this->request);
    }

    public function test_index_return_view()
    {
        // Given
        $this->request->set_method('get');

        // Queue new request, this request will be called when invoke action_index()
        $this->guzzleMockHandler->append(new GuzzleResponse(200, [], 'Service response data'));

        // When execute route
        $controller = new Welcome($this->request);
        $response = $controller->action_index();
        $view = $response->body();

        // Then
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->status);
        $this->assertInstanceOf(View::class, $response->body());
        $this->assertContains('welcome/index', $this->getObjectProperty($view, 'file_name'));
        $this->assertArrayHasKey('data', $response->body()->get());
    }

    public function test_index_return_400_bad_request()
    {
        // Given
        $this->request->set_method('get');
        $this->guzzleMockHandler->append(new GuzzleResponse(200, [], '')); // Empty response

        // When
        $controller = new Welcome($this->request);
        $response = $controller->action_index();

        // Then
        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(400, $response->status);
    }

    public function test_index_post_return_default_string()
    {
        $this->request->set_method('post');
        $controller = new Welcome($this->request);
        $response = $controller->action_index();

        $this->assertEquals('Reverse string', $response);
    }

    public function test_index_post_return_correct_string()
    {
        $request = $this->request
            ->set_method('post')
            ->set_post('message', 'Hello world!');

        $controller = new Welcome($this->request);
        $response = $controller->action_index();

        $this->assertEquals('!dlrow olleH', $response);
    }

    public function test_hello_return_presenter()
    {
        $controller = new Welcome($this->request);
        $response = $controller->action_hello();
        $presenter = $response->body();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(200, $response->status);
        $this->assertInstanceOf(Presenter::class, $presenter);
        $this->assertContains('welcome/hello', $this->getObjectProperty($presenter->get_view(), 'file_name'));
    }

    public function test_return_404()
    {
        $controller = new Welcome($this->request);
        $response = $controller->action_404();
        $presenter = $response->body();

        $this->assertInstanceOf(Response::class, $response);
        $this->assertEquals(404, $response->status);
        $this->assertInstanceOf(Presenter::class, $presenter);
        $this->assertContains('welcome/notfound', $this->getObjectProperty($presenter->get_view(), 'file_name'));
    }
}
