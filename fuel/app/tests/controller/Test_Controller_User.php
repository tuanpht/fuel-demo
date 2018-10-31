<?php

use AspectMock\Test as Aspect;
use Fuel\Core\HttpNotFoundException;
use Fuel\Core\Response;
use Fuel\Core\DB;

/**
 * Tests for Welcome controller
 *
 * @group App
 * @group Controller
 */
class Test_Controller_User extends Base_Test
{
    protected $db_transaction = true;

    public function test_index_return_view()
    {
        $countUsers = 3;
        for ($i = 0; $i < $countUsers; ++$i) {
            $user = new Model_User([
                'name' => 'User ' . $i,
                'email' => "user$i@local.com",
                'password' => '123',
            ]);
            $user->save();
        }

        $response = Request::forge('user/index')
            ->set_method('GET')
            ->execute()
            ->response();
        $templateView = $response->body();

        // Then
        $this->assertInstanceOf(View::class, $templateView);
        $view = $templateView->get('content');
        $this->assertInstanceOf(View::class, $view);
        $this->assertContains('user/index', $this->getObjectProperty($view, 'file_name'));
        $this->assertCount($countUsers, $view->get('users'));
    }

    public function test_view_return_redirect_when_id_null()
    {
        $res = Aspect::double(Response::class, ['redirect' => true]);

        $response = Request::forge('user/view')
            ->set_method('GET')
            ->execute()
            ->response();

        $res->verifyInvoked('redirect', ['user']);
    }
}
