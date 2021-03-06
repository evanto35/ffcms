<?php

namespace Apps\Model\Admin\User;

use Apps\ActiveRecord\Role;
use Apps\ActiveRecord\User;
use Ffcms\Core\App;
use Ffcms\Core\Arch\Model;
use Ffcms\Core\Helper\Type\Obj;
use Ffcms\Core\Helper\Type\Str;
use Ffcms\Core\Interfaces\iUser;

/**
 * Class FormUserUpdate. Update user data business logic model
 * @package Apps\Model\Admin\User
 */
class FormUserUpdate extends Model
{
    public $email;
    public $login;
    public $password;
    public $newpassword;
    public $role_id;
    public $approve_token;

    private $_approve_tmp;

    /** @var iUser */
    public $_user;

    /**
     * FormUserUpdate constructor. Pass user object inside the model
     * @param iUser $user
     */
    public function __construct(iUser $user)
    {
        $this->_user = $user;
        parent::__construct(true);
    }

    /**
     * Load user data on before method
     */
    public function before()
    {
        foreach ($this->getAllProperties() as $property => $old_data) {
            if ($this->_user->{$property} !== null) {
                $this->{$property} = $this->_user->{$property};
            }
        }
        $this->_approve_tmp = $this->approve_token;
        if ($this->approve_token == '0') {
            $this->approve_token = 1;
        }
    }

    /**
     * Form labels to display
     * @return array
     */
    public function labels()
    {
        return [
            'email' => __('Email'),
            'login' => __('Login'),
            'newpassword' => __('New password'),
            'role_id' => __('Role'),
            'approve_token' => __('Approved')
        ];
    }

    /**
     * Validation rules for input data
     * @return array
     */
    public function rules()
    {
        return [
            [['email', 'login', 'role_id', 'approve_token'], 'required'],
            [['newpassword'], 'used'],
            ['email', 'email'],
            ['login', 'length_min', 3],
            ['email', 'Apps\Model\Admin\User\FormUserUpdate::isUniqueEmail', $this->_user->getParam('id')],
            ['login', 'Apps\Model\Admin\User\FormUserUpdate::isUniqueLogin', $this->_user->getParam('id')]
        ];
    }

    /**
     * Get all roles as id=>name array
     * @return array|null
     */
    public function getRoleList()
    {
        return Role::getIdNameAll();
    }

    /**
     * Update user information in database based on current obj attributes passed from input data
     */
    public function save()
    {
        foreach ($this->getAllProperties() as $property => $value) {
            if ($property === 'password' || $property === 'newpassword') {
                // update password only if new is set and length >= 3
                if ($this->newpassword !== null && Str::length($this->newpassword) >= 3) {
                    $this->_user->password = App::$Security->password_hash($this->newpassword);
                }
            } elseif ($property === 'approve_token') {
                if ($value == "1") {
                    $this->_user->approve_token = '0';
                } else {
                    if ($this->_approve_tmp === '0') {
                        $this->_approve_tmp = Str::randomLatinNumeric(mt_rand(32, 128));
                    }
                    $this->_user->approve_token = $this->_approve_tmp;
                }
            } else {
                $this->_user->{$property} = $value;
            }
        }

        $this->_user->save();
    }

    /**
     * Check if new email is always exist
     * @param string $email
     * @param int|null $userId
     * @return bool
     */
    public static function isUniqueEmail($email, $userId = null)
    {
        $find = User::where('email', '=', $email);

        if ($userId !== null && Obj::isLikeInt($userId)) {
            $find->where('id', '!=', $userId);
        }

        return $find->count() === 0;
    }

    /**
     * Check if new login is always exist
     * @param string $login
     * @param int|null $userId
     * @return bool
     */
    public static function isUniqueLogin($login, $userId = null)
    {
        $find = User::where('login', '=', $login);

        if ($userId !== null && Obj::isLikeInt($userId)) {
            $find->where('id', '!=', $userId);
        }

        return $find->count() === 0;
    }
}