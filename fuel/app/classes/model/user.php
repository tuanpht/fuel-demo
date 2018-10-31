<?php

use Orm\Model;
use Orm\Observer_CreatedAt;
use Orm\Observer_UpdatedAt;

class Model_User extends Model
{
    protected static $_properties = [
        'id',
        'name',
        'email',
        'password',
        'created_at',
        'updated_at',
    ];

    protected static $_observers = [
        Observer_CreatedAt::class => [
            'events' => ['before_insert'],
            'mysql_timestamp' => false,
        ],
        Observer_UpdatedAt::class => [
            'events' => ['before_save'],
            'mysql_timestamp' => false,
        ],
        Model_Observer_Password::class => [
            'events' => ['before_save'],
            'property' => 'password',
        ],
    ];

    public static function validate($factory)
    {
        $val = Validation::forge($factory);
        $val->add_field('name', 'Name', 'required|max_length[255]');
        $val->add_field('email', 'Email', 'required|valid_email|max_length[255]');

        $passwordRule = 'min_length[6]|max_length[255]';

        if ($factory == 'create') {
            $passwordRule = 'required|' . $passwordRule;
        }
        $val->add_field('password', 'Password', $passwordRule);
        $val->add_field(
            'confirm_password',
            'Confirm Password',
            'match_field[password]'
        );

        return $val;
    }
}
