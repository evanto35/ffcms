<?php
namespace Extend\Core\Arch;

use Ffcms\Core\App;
use Ffcms\Core\Arch\Widget as NativeWidget;
use Apps\ActiveRecord\App as AppRecord;
use Ffcms\Core\Helper\Type\Str;

/**
 * Class FrontWidget. Special controller type for front widgets.
 * @package Extend\Core\Arch
 */
class FrontWidget extends NativeWidget
{
    public static $name;

    /**
     * Display widget compiled data.
     * @param array|null $params
     * @return null|string
     * @throws \Exception
     */
    public static function widget(array $params = null)
    {
        if (!self::enabled()) {
            return null;
        }

        // call parent method
        return parent::widget($params);
    }

    /**
     * Check if widget is enabled
     * @param string|null $name
     * @return bool
     */
    public static function enabled($name = null)
    {
        // get widget class-namespace callback and single class name
        self::$class = get_called_class();
        self::$name = Str::lastIn(self::$class, '\\', true);

        $wData = AppRecord::getItem('widget', self::$name);
        // widget is not founded, deny run
        if ($wData === null) {
            if (App::$Debug !== null) {
                App::$Debug->addMessage(__('Widget with name %name%[%class%] is not found', ['name' => self::$name, 'class' => self::$class]));
            }
            return null;
        }

        // if widget is disabled - lets return nothing
        return !(bool)$wData->disabled;
    }

}