<?php

namespace Apps\ActiveRecord;

use Ffcms\Core\Arch\ActiveModel;
use Ffcms\Core\Cache\MemoryObject;
use Ffcms\Core\Exception\SyntaxException;

class App extends ActiveModel
{

    /**
     * Get all objects with query caching
     * @return \Illuminate\Database\Eloquent\Collection|static
     * @throws SyntaxException
     */
    public static function getAll()
    {
        $object = MemoryObject::instance()->get('app.cache.all');
        // empty?
        if ($object === null) {
            $object = self::all();
            MemoryObject::instance()->set('app.cache.all', $object);
        }

        if ($object === null) {
            throw new SyntaxException('Application table "prefix_app" is empty!!!');
        }

        return $object;
    }

    /**
     * Get localized application name
     * @return string
     * @throws SyntaxException
     */
    public function getLocaleName()
    {
        if ($this->sys_name === null) {
            throw new SyntaxException('Application object is not founded');
        }

        $nameObject = unserialize($this->name);
        $lang = \Ffcms\Core\App::$Request->getLanguage();
        $name = $nameObject[$lang];
        if ($name === null) {
            $name = $this->sys_name;
        }
        return $name;
    }

}