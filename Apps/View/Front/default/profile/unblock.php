<?php

use Ffcms\Core\Helper\Date;
use Ffcms\Core\Helper\HTML\Form;
use Ffcms\Core\Helper\Type\String;
use Ffcms\Core\Helper\Url;

/** @var $model Apps\Model\Front\Profile\FormIgnoreDelete */
/** @var $this object */

$this->title = __('Blacklist user remove');

$this->breadcrumbs = [
    Url::to('main/index') => __('Home'),
    Url::to('profile/show', \App::$User->identity()->getId()) => __('Profile'),
    Url::to('profile/ignore') => __('Blacklist'),
    __('Blacklist cleanup')
];

?>

<?= $this->render('profile/_settingsTab') ?>
<h1><?= __('Remove user from blacklist') ?></h1>
<hr />
<?php $form = new Form($model, ['class' => 'form-horizontal', 'action' => '', 'method' => 'post']) ?>
<div class="row">
    <div class="col-md-3">
        <label class="pull-right"><?= $model->getLabel('name') ?></label>
    </div>
    <div class="col-md-9">
        <?= Url::link(['profile/show', $model->id], String::likeEmpty($model->name) ? __('No name') : $model->name, ['target' => '_blank']) ?>
    </div>
</div>

<p><?= __('Are you sure to remove this user from your blacklist?') ?> <?= __('No any attentions will be displayed!') ?></p>

<div class="col-md-9 col-md-offset-3"><?= $form->submitButton(__('Remove'), ['class' => 'btn btn-danger']) ?></div>
<?= $form->finish() ?>