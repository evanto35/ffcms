<?php
use Ffcms\Core\Helper\Url;

if (isset($controller)): ?>
<a href="<?= Url::to($controller . '/index') ?>"><i class="fa fa-cogs"></i></a>&nbsp;
<a href="<?= Url::to('widget/turn', $controller) ?>"><i class="fa fa-power-off"></i></a>
<?php endif; ?>