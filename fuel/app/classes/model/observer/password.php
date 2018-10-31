<?php

class Model_Observer_Password extends Orm\Observer
{
    /**
     * @var  string  default property to set the password
     */
    protected static $defaultProperty = 'password';

    /**
     * @var  string  property to set the timestamp on
     */
    protected $property;

    /**
     * Set the properties for this observer instance, based on the parent model's
     * configuration or the defined defaults.
     *
     * @param  string  Model class this observer is called on
     */
    public function __construct($class)
    {
        $props = $class::observers(get_class($this));
        $this->property = $props['property'] ?? static::$defaultProperty;
    }

    public function before_save(Orm\Model $model)
    {
        if (password_needs_rehash($model->{$this->property}, PASSWORD_BCRYPT)) {
            $model->{$this->property} = password_hash($model->{$this->property}, PASSWORD_BCRYPT);
        }
    }
}
