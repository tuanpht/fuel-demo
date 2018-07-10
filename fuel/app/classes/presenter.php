<?php
// phpcs:disable PSR1.Classes.ClassDeclaration.MissingNamespace
class Presenter extends \Fuel\Core\Presenter
{
    // namespace prefix
    protected static $nsPrefix = 'Presenter\\';

    /**
     * Factory for fetching the Presenter
     *
     * @param   string  $presenter    Presenter full classname
     * @param   string  $method       Method to execute
     * @param   bool    $auto_filter  Auto filter the view data
     * @param   string  $view         View to associate with this presenter
     * @return  Presenter
     */
    public static function forge($presenter, $method = 'view', $autoFilter = null, $view = null)
    {
        is_null($view) and $view = str_replace('\\', DS, strtolower(
            str_replace(static::$nsPrefix, '', $presenter)
        ));

        if (class_exists($presenter)) {
            return new $presenter($method, $autoFilter, $view);
        }

        throw new \OutOfBoundsException('Presenter "' . $presenter . '" could not be found.');
    }
}
