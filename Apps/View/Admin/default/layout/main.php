<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= App::$Security->strip_tags($this->title) ?></title>
    <link rel="stylesheet" href="<?php use Ffcms\Core\Helper\Arr;
    use Ffcms\Core\Helper\HTML\Listing;
    use Ffcms\Core\Helper\Object;
    use Ffcms\Core\Helper\Url;

    echo \App::$Alias->getVendor('css', 'bootstrap'); ?>"/>
    <link rel="stylesheet" href="<?php echo \App::$Alias->getVendor('css', 'fa'); ?>"/>
    <link href="<?php echo \App::$Alias->currentViewUrl; ?>/assets/css/site.css" rel="stylesheet">
    <link href="<?php echo \App::$Alias->currentViewUrl; ?>/assets/plugins/metisMenu/metisMenu.min.css" rel="stylesheet">
    <link href="<?php echo \App::$Alias->currentViewUrl; ?>/assets/css/sb-admin-2.css" rel="stylesheet">
    <?php echo \App::$View->showCodeLink('css'); ?>
    <?php
    $customCssCode = \App::$View->showPlainCode('css');
    if ($customCssCode !== null) {
        echo '<style>' . $customCssCode . '</style>';
    } ?>
</head>
<body>

<div id="wrapper">

    <!-- Navigation -->
    <nav id="w0" class="navbar navbar-default navbar-static-top" style="margin-bottom: 0" role="navigation">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#w0-collapse"><span
                    class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span></button>
            <a class="navbar-brand" href="<?php echo App::$Alias->baseUrl ?>">FFCMS<sup>3</sup> Dashboard</a></div>
        <div id="w0-collapse" class="collapse navbar-collapse">
            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i> <?= __('Fast Access') ?> <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>Add page</strong>
                                    <span class="pull-right text-muted">
                                        <i class="fa fa-list-alt fa-lg"></i>
                                    </span>
                                </div>
                                <div>Using this function you can add static page to website</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>Add page</strong>
                                    <span class="pull-right text-muted">
                                        <i class="fa fa-plus fa-lg"></i>
                                    </span>
                                </div>
                                <div>Using this function you can add news material on website</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>Read feedback</strong>
                                    <span class="pull-right text-muted">
                                        <i class="fa fa-envelope fa-lg"></i>
                                    </span>
                                </div>
                                <div>Using this function you can read current feedback from users</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>Moderate comments</strong>
                                    <span class="pull-right text-muted">
                                        <i class="fa fa-plus fa-lg"></i>
                                    </span>
                                </div>
                                <div>Using this function you can moderate user comments</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>View All admin notify</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->
                <li><a href="<?php echo \App::$Alias->scriptUrl; ?>" target="_blank">
                        <i class="fa fa-arrow-right"></i>
                        <?= __('Open site') ?> </a>
                </li>
                <li><a href="<?= \App::$Alias->scriptUrl ?>/user/logout" data-method="post"><i class="fa fa-sign-out"></i> <?= __('Logout') ?></a></li>
            </ul>

            <div class="navbar-default sidebar" role="navigation">
                <div class="sidebar-nav navbar-collapse">
                    <ul class="nav" id="side-menu">
                        <li><a href="<?= Url::to('main/index'); ?>">
                                <i class="fa fa-home fa-fw"></i> <?= __('Main') ?></a>
                        </li>
                        <li<?= (\App::$Request->getController() === 'Main' && \App::$Request->getAction() !== 'Index') ? ' class="active"' : null ?>>
                            <a href="#"><i class="fa fa-fire fa-fw"></i> <?= __('System') ?><span class="fa arrow"></span></a>
                            <?php echo Listing::display([
                                'type' => 'ul',
                                'property' => ['class' => 'nav nav-second-level'],
                                'items' => [
                                    ['type' => 'link', 'link' => ['main/settings'], 'text' => '<i class="fa fa-cogs"></i> ' . __('Settings'), 'html' => true],
                                    ['type' => 'link', 'link' => ['main/files'], 'text' => '<i class="fa fa-file-o"></i> ' . __('Files'), 'html' => true],
                                    ['type' => 'link', 'link' => ['main/antivirus'], 'text' => '<i class="fa fa-shield"></i> ' . __('Antivirus'), 'html' => true],
                                    ['type' => 'link', 'link' => ['main/codex'], 'text' => '<i class="fa fa-code"></i> ' . __('CodeX'), 'html' => true],
                                    ['type' => 'link', 'link' => ['main/updates'], 'text' => '<i class="fa fa-gavel"></i> ' . __('Updates'), 'html' => true]
                                ]
                            ]) ?>
                            <!-- /.nav-second-level -->
                        </li>
                        <?php
                        $appMenuItems = null;
                        $appControllers = [];
                        foreach ($this->applications as $app) {
                            if ($app->type !== 'app') {
                                continue;
                            }
                            $appControllers[] = $app->sys_name;
                            $appMenuItems[] = ['type' => 'link', 'link' => [$app->sys_name . '/index'], 'text' => $app->getLocaleName()];
                        }
                        $appMenuItems[] = ['type' => 'link', 'link' => ['application/index'], 'text' => __('All apps') . '...'];
                        $appControllers[] = 'Application';
                        ?>
                        <li<?= Arr::in(\App::$Request->getController(), $appControllers) ? ' class="active"' : null ?>>
                            <a href="#"><i class="fa fa-plug fa-fw"></i> <?= __('Applications') ?><span class="fa arrow"></span></a>
                            <?php

                            echo Listing::display([
                                'type' => 'ul',
                                'property' => ['class' => 'nav nav-second-level'],
                                'items' => $appMenuItems
                            ]) ?>
                            <!-- /.nav-second-level -->
                        </li>
                        <li>
                            <a href="#"><i class="fa fa-table fa-fw"></i> <?= __('Widgets') ?><span class="fa arrow"></span></a>
                            <ul class="nav nav-second-level">
                                <li><a href="#">All widgets...</a></li>
                            </ul>
                            <!-- /.nav-second-level -->
                        </li>
                    </ul>
                </div>
                <!-- /.sidebar-collapse -->
            </div>

        </div>
    </nav>
    <div id="page-wrapper">
        <div class="row">
            <div class="col-md-12">
                <div class="site-index">
                    <?php if ($this->breadcrumbs !== null && Object::isArray($this->breadcrumbs)) : ?>
                        <ol class="breadcrumb">
                            <?php foreach ($this->breadcrumbs as $bUrl => $bText): ?>
                                <?php if (Object::isLikeInt($bUrl)): // only text ?>
                                    <li class="active"><?= \App::$Security->strip_tags($bText) ?></li>
                                <?php else: ?>
                                    <li>
                                        <a href="<?= \App::$Security->strip_tags($bUrl) ?>">
                                            <?= \App::$Security->strip_tags($bText) ?>
                                        </a>
                                    </li>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        </ol>
                    <?php endif; ?>
                    <article>
                        <?php
                        if ($body != null) {
                            // display notify if not used in views
                            $notify = \App::$Session->getFlashBag()->all();
                            if (Object::isArray($notify) && count($notify) > 0) {
                                echo \App::$View->show('macro/notify', ['notify' => $notify]);
                            }

                            echo $body;
                        } else {
                            \App::$Response->setStatusCode(404);
                            echo '<p>' . __('Page is not founded!') . '</p>';
                        }
                        ?>
                    </article>
                </div>
            </div>
            <!-- /.col-md-12 -->
        </div>
        <!-- /.row -->
        <div class="row" style="padding-top: 20px;">
            <p class="text-center"><a href="#" onclick="window.history.back();return false;"><span
                        class="label label-primary"><i class="fa fa-arrow-left"></i></span></a></p>
        </div>
    </div>
    <!-- /#page-wrapper -->

</div>
<script src="<?php echo \App::$Alias->getVendor('js', 'jquery'); ?>"></script>
<script src="<?php echo \App::$Alias->getVendor('js', 'bootstrap'); ?>"></script>
<script src="<?php echo \App::$Alias->currentViewUrl; ?>/assets/js/metisMenu.min.js"></script>
<script src="<?php echo \App::$Alias->currentViewUrl; ?>/assets/js/sb-admin-2.js"></script>
<?php echo \App::$View->showCodeLink('js'); ?>
<?php
$customJsCode = \App::$View->showPlainCode('js');
if ($customJsCode !== null) {
    echo '<script>' . $customJsCode . '</script>';
}
?>
</body>
</html>