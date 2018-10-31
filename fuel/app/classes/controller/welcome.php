<?php
namespace Controller;

use Controller;
use Response;
use View;
use Input;
use Presenter;
use Presenter\Welcome\Hello;
use Presenter\Welcome\NotFound;
use Container;
use Service\Remote;
use Fuel\Core\Session;

/**
 * The Welcome Controller.
 *
 * A basic controller example.  Has examples of how to set the
 * response body and status.
 *
 * @package  app
 * @extends  Controller
 */
class Welcome extends Controller
{
    /**
     * The basic welcome message
     *
     * @access  public
     * @return  Response
     */
    public function action_index()
    {
        // In case of POST method
        if (Input::method() == 'POST') {
            if ($message = Input::post('message')) {
                return strrev($message);
            }

            return 'Reverse string';
        }

        // Just call a test api
        $data = Remote::getIp();

        if ($data) {
            return Response::forge(View::forge('welcome/index', [
                'data' => $data,
            ]));
        }

        return Response::forge('Request failed', 400);
    }

    /**
     * @access  public
     * @return  Response
     */
    public function action_new()
    {
        // Just call a test api
        $service = new Remote;

        return $service->nonStatic('ip');
    }

    /**
     * A typical "Hello, Bob!" type example.  This uses a Presenter to
     * show how to use them.
     *
     * @access  public
     * @return  Response
     */
    public function action_hello()
    {
        return Response::forge(Presenter::forge(Hello::class));
    }

    /**
     * The 404 action for the application.
     *
     * @access  public
     * @return  Response
     */
    public function action_404()
    {
        return Response::forge(Presenter::forge(NotFound::class), 404);
    }

    public function action_redirect()
    {
        Session::get('abc');
        return Response::redirect('welcome/404');
    }
}
