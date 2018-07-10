<?php
namespace Presenter\Welcome;

/**
 * The welcome 404 presenter.
 *
 * @package  app
 * @extends  Presenter
 */
class NotFound extends \Presenter
{
    /**
     * Prepare the view data, keeping this in here helps clean up
     * the controller.
     *
     * @return void
     */
    public function view()
    {
        $messages = ['Aw, crap!', 'Bloody Hell!', 'Uh Oh!', 'Nope, not here.', 'Huh?'];
        $this->title = $messages[array_rand($messages)];
    }
}
