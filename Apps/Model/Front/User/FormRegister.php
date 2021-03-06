<?php

namespace Apps\Model\Front\User;

use Apps\ActiveRecord\Profile;
use Apps\ActiveRecord\User;
use Ffcms\Core\App;
use Ffcms\Core\Arch\Model;
use Ffcms\Core\Helper\Type\Str;

/**
 * Class FormRegister. User registration business logic model
 * @package Apps\Model\Front\User
 */
class FormRegister extends Model
{
    public $email;
    public $login;
    public $password;
    public $repassword;
    public $captcha;

    private $_captcha = false;
    /** @var User|null */
    public $_userObject;
    /** @var Profile|null */
    public $_profileObject;

    /**
     * FormRegister constructor. Build model and set maker if captcha is enabled
     * @param bool $captcha
     */
    public function __construct($captcha = false)
    {
        $this->_captcha = $captcha;
        parent::__construct(true);
    }


    /**
     * Validation rules
     * @return array
     */
    public function rules()
    {
        $rules = [
            [['login', 'password', 'repassword', 'email'], 'required'],
            ['login', 'length_min', '2'],
            ['password', 'length_min', '3'],
            ['email', 'email'],
            ['repassword', 'equal', $this->getRequest('password', $this->getSubmitMethod())],
            ['captcha', 'used']
        ];

        if (true === $this->_captcha) {
            $rules[] = ['captcha', 'App::$Captcha::validate'];
        }

        return $rules;
    }

    /**
     * Labels for form items
     * @return array
     */
    public function labels()
    {
        return [
            'login' => __('Login'),
            'password' => __('Password'),
            'repassword' => __('Repeat password'),
            'email' => __('Email'),
            'captcha' => __('Captcha')
        ];
    }

    /**
     * Try to insert user data in database
     * @param bool $activation
     * @return bool
     * @throws \Ffcms\Core\Exception\SyntaxException
     * @throws \Ffcms\Core\Exception\NativeException
     */
    public function tryRegister($activation = false)
    {
        $check = App::$User->where('login', '=', $this->login)
            ->orWhere('email', '=', $this->email)
            ->count();
        if ($check !== 0) {
            return false;
        }

        $password = App::$Security->password_hash($this->password);
        // create row
        $user = new User();
        $user->login = $this->login;
        $user->email = $this->email;
        $user->password = $password;
        // if need to be approved - make random token and send email
        if ($activation) {
            $user->approve_token = Str::randomLatinNumeric(mt_rand(32, 128)); // random token for validation url
            // send email
            $template = App::$View->render('user/mail/approve', [
                'token' => $user->approve_token,
                'email' => $user->email,
                'login' => $user->login
            ]);

            $sender = App::$Properties->get('adminEmail');

            // format SWIFTMailer format
            $mailMessage = \Swift_Message::newInstance(App::$Translate->get('Default', 'Registration approve', []))
                ->setFrom([$sender])
                ->setTo([$this->email])
                ->setBody($template, 'text/html');
            // send message
            App::$Mailer->send($mailMessage);
        }
        // save row
        $user->save();

        // create profile
        $profile = new Profile();
        $profile->user_id = $user->id;
        // save profile
        $profile->save();

        // set user & profile objects to attributes to allow extending this model
        $this->_userObject = $user;
        $this->_profileObject = $profile;

        return true;
    }
}