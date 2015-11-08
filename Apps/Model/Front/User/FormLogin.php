<?php

namespace Apps\Model\Front\User;

use Ffcms\Core\App;
use Ffcms\Core\Arch\Model;
use Ffcms\Core\Helper\Type\Object;
use Ffcms\Core\Helper\Type\Str;
use Ffcms\Core\Interfaces\iUser;

class FormLogin extends Model
{

    public $login;
    public $password;
    public $captcha;

    private $_captcha = false;

    /**
     * @param bool $captcha
     */
    public function __construct($captcha = false)
    {
        parent::__construct();
        $this->_captcha = $captcha;
    }

    public function rules()
    {
        $rules = [
            [['login', 'password'], 'required'],
            ['login', 'length_min', '2'],
            ['password', 'length_min', '3'],
            ['captcha', 'used']
        ];
        if (true === $this->_captcha) {
            $rules[] = ['captcha', 'App::$Captcha::validate'];
        }
        return $rules;
    }

    public function labels()
    {
        return [
            'login' => __('Login or email'),
            'password' => __('Password'),
            'captcha' => __('Captcha')
        ];
    }

    /**
     * Try user auth after form validate
     * @return bool
     */
    public function tryAuth()
    {
        $password = App::$Security->password_hash($this->password);

        $search = App::$User
            ->where('password', '=', $password)
            ->where(function($query) {
                $query->where('login', '=', $this->login)
                    ->orWhere('email', '=', $this->login);
            });

        if ($search->count() === 1) {
            $object = $search->first();
            // check if accounts is approved
            if ($object->approve_token !== '0' && Str::length($object->approve_token) > 0) {
                return false;
            }
            return $this->openSession($object);
        }

        return false;
    }

    /**
     * Open session and store data token to db
     * @param iUser $userObject
     * @return bool
     */
    public function openSession(iUser $userObject)
    {
        if ($userObject === null || $userObject->id < 1) {
            return false;
        }

        $token = Str::randomLatin(mt_rand(128, 255));

        // write session data
        App::$Session->set('ff_user_id', $userObject->id);
        App::$Session->set('ff_user_token', $token);

        // write token to db
        $userObject->token_data = $token;
        $userObject->save();

        return true;
    }
}