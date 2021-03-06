<?php
use Ffcms\Core\Helper\Url;

/** @var object $this */

$this->title = __('Settings are saved');
?>
<h1><?= __('Congratulations!') ?></h1>
<hr />
<p><?= __('Settings are successful saved! Wait 5 second to update configurations') ?></p>
<?= Url::link(['main/settings'], __('Reload'), ['class' => 'btn btn-primary']); ?>

<script>
setTimeout(function () {
	window.location.replace("<?= Url::to('main/settings') ?>");
 }, 5000);
</script>