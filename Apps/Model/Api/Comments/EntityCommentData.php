<?php

namespace Apps\Model\Api\Comments;


use Apps\ActiveRecord\CommentAnswer;
use Apps\ActiveRecord\CommentPost;
use Ffcms\Core\App;
use Ffcms\Core\Arch\Model;
use Ffcms\Core\Exception\JsonException;
use Ffcms\Core\Helper\Date;
use Ffcms\Core\Helper\Type\Str;

/**
 * Class EntityCommentPostData. Unified model to get comment specified output to json response.
 * @package Apps\Model\Api\Comments
 */
class EntityCommentData extends Model
{
    /** @var \Apps\ActiveRecord\CommentPost|\Apps\ActiveRecord\CommentAnswer $_record */
    private $_record;
    private $_type;
    private $_calcAnswers = true;

    /**
     * EntityCommentPostData constructor. Pass inside the model active record object of comment post or answer
     * @param $record
     * @throws JsonException
     */
    public function __construct($record, $calcAnswers = true)
    {
        $this->_record = $record;
        $this->_calcAnswers = (bool)$calcAnswers;
        if ($this->_record instanceof CommentPost) {
            $this->_type = 'post';
        } elseif ($this->_record instanceof CommentAnswer) {
            $this->_type = 'answer';
        } else {
            throw new JsonException('Unknown comment request');
        }
        parent::__construct();
    }

    /**
     * Prepare output comment post information array
     * @return array|null
     */
    public function make()
    {
        if ($this->_record === null) {
            return null;
        }

        // build user data
        $userName = __('Unknown');
        $userAvatar = App::$Alias->scriptUrl . '/upload/user/avatar/small/default.jpg';
        $userObject = $this->_record->getUser();
        $userColor = 0;
        if ($userObject !== null) {
            $userName = $userObject->getProfile()->getNickname();
            $userAvatar = $userObject->getProfile()->getAvatarUrl('small');
            $userColor = $userObject->getRole()->color;
        } else {
            if (!Str::likeEmpty($this->_record->guest_name)) {
                $userName = App::$Security->strip_tags($this->_record->guest_name);
            }
        }

        // return output json data
        $res = [
            'type' => $this->_type,
            'id' => $this->_record->id,
            'text' => $this->_record->message,
            'date' => Date::convertToDatetime($this->_record->created_at, Date::FORMAT_TO_HOUR),
            'pathway' => $this->_record->pathway,
            'moderate' => (int)$this->_record->moderate,
            'user' => [
                'id' => $this->_record->user_id,
                'name' => $userName,
                'avatar' => $userAvatar,
                'color' => $userColor
            ]
        ];

        if ($this->_type === 'post' && method_exists($this->_record, 'getAnswerCount') && $this->_calcAnswers) {
            $res['answers'] = $this->_record->getAnswerCount();
        } elseif ($this->_type === 'answer') {
            $res['comment_id'] = $this->_record->comment_id;
        }

        return $res;
    }

}