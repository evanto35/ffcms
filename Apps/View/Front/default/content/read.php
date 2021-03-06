<?php

/** @var Apps\Model\Front\Content\EntityContentRead $model */
/** @var Apps\Model\Front\Content\EntityContentSearch $search */
/** @var \Ffcms\Core\Arch\View $this */
/** @var bool $trash */
/** @var array $configs */
use Ffcms\Core\Helper\Type\Arr;
use Ffcms\Core\Helper\Type\Obj;
use Ffcms\Core\Helper\Type\Str;
use Ffcms\Core\Helper\Url;

// check if content is trashed or hidden from display and show it only for admin with content.index permissions
if (($trash || !$model->display) && (!\App::$User->isAuth() || !\App::$User->identity()->getRole()->can('Admin/Content/Index'))) {
    throw new \Ffcms\Core\Exception\NotFoundException(__('Page not found'));
}

// set meta title
$this->title = $model->metaTitle;
if (Str::likeEmpty($this->title)) {
    $this->title = $model->title;
}
// set meta description
$this->description = $model->metaDescription;
// set meta keywords
if (Obj::isArray($model->metaKeywords) && count($model->metaKeywords) > 0) {
    $this->keywords = implode(', ', $model->metaKeywords);
}

// don't use breadcrumbs on injected pathway rule
if (!\App::$Request->isPathInjected() && (bool)$model->getCategory()->getProperty('showCategory')) {
    $breadcrumbs = [
            Url::to('/') => __('Home')
    ];
    if (Obj::isArray($model->catNesting)) {
        foreach ($model->catNesting as $cat) {
            if (Str::likeEmpty($cat['path'])) {
                $breadcrumbs[Url::to('content/list', $cat['path'])] = __('Contents');
            } else {
                $breadcrumbs[Url::to('content/list', $cat['path'], null, [], false)] = $cat['name'];
            }
        }
        $breadcrumbs[] = __('Content') . ': ' . Str::sub($this->title, 0, 40);
    }

    $this->breadcrumbs = $breadcrumbs;
}

$properties = [
    'date' => (bool)$model->getCategory()->getProperty('showDate'),
    'author' => (bool)$model->getCategory()->getProperty('showAuthor'),
    'views' => (bool)$model->getCategory()->getProperty('showViews'),
    'category' => (bool)$model->getCategory()->getProperty('showCategory'),
    'rating' => (bool)$model->getCategory()->getProperty('showRating'),
    'tags' => (bool)$model->getCategory()->getProperty('showTags')
];
$showComments = (bool)$model->getCategory()->getProperty('showComments');
$showPoster = (bool)$model->getCategory()->getProperty('showPoster');

?>

<article class="article-item" itemscope="itemscope" itemtype="https://schema.org/NewsArticle">
    <h1><?= $model->title ?></h1>
    <?php if (Arr::in(true, $properties)): ?>
    <div class="meta">
        <?php if ($properties['category'] === true): ?>
        <span class="spaced"><i class="glyphicon glyphicon-list"></i> <?= Url::link(['content/list', $model->catPath, null, [], false], $model->catName, ['itemprop' => 'genre']) ?></span>
        <?php endif; ?>
        <?php if ($properties['date'] === true): ?>
        <span class="spaced"><i class="glyphicon glyphicon-calendar"></i> <time datetime="<?= date('c', $model->createDate) ?> itemprop="datePublished"><?= $model->createDate ?></time></span>
        <?php endif; ?>
        <?php if ($properties['author'] === true): ?>
            <?php if ($model->authorId !== null && $model->authorId > 0): ?>
                <span class="spaced"><i class="glyphicon glyphicon-user"></i> <?= Url::link(['profile/show', $model->authorId], $model->authorName, ['itemprop' => 'author']) ?></span>
            <?php else: ?>
                <span class="spaced"><i class="glyphicon glyphicon-user"></i> <s><?= $model->authorName ?></s></span>
            <?php endif; ?>
        <?php endif; ?>
        <?php if ($properties['views'] === true): ?>
        <span class="spaced"><i class="glyphicon glyphicon-eye-open"></i> <?= $model->views ?></span>
        <?php endif ?>
        <?php if (\App::$User->isAuth() && \App::$User->identity()->getRole()->can('Admin/Content/Update')): ?>
        <span class="pull-right"><a href="<?= \App::$Alias->scriptUrl . '/admin/content/update/' . $model->id ?>" target="_blank"><i class="glyphicon glyphicon-pencil" style="color: #ff0000;"></i></a></span>
        <?php endif; ?>
    </div>
    <?php else: ?>
    <hr />
    <?php endif; ?>
    <?php if ($trash): ?>
    <p class="alert alert-danger"><i class="glyphicon glyphicon-trash"></i> <?= __('This content is placed in trash') ?></p>
    <?php endif; ?>
    <?php if (!$model->display): ?>
    <p class="alert alert-warning"><i class="glyphicon glyphicon-pencil"></i> <?= __('This content now is on moderation stage') ?></p>
    <?php endif; ?>
    <div id="content-text">
        <?php if ($showPoster === true && $model->posterFull !== null && $model->posterThumb !== null): ?>
            <a href="#showPoster" data-toggle="modal" data-target="#showPoster">
                <img alt="<?= __('Poster for') ?>: <?= Str::lowerCase($model->title) ?>" src="<?= \App::$Alias->scriptUrl . $model->posterThumb ?>" class="image_poster img-thumbnail" />
            </a>

            <!-- Modal poster pop-up -->
            <div class="modal fade" id="showPoster" tabindex="-1" role="dialog" aria-labelledby="showPosterModal">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                            <h4 class="modal-title" id="myModalLabel"><?= __('View poster') ?></h4>
                        </div>
                        <div class="modal-body">
                            <img class="img-responsive" src="<?= \App::$Alias->scriptUrl . $model->posterFull ?>" alt="<?= __('Poster image') ?>" style="margin: 0 auto;" />
                        </div>
                    </div>
                </div>
            </div>
        <?php endif ;?>
        <?= $model->text ?>
    </div>
    <?php if ($model->galleryItems !== null && Obj::isArray($model->galleryItems)): ?>
        <div class="row">
        <?php $i = 1; ?>
        <?php foreach ($model->galleryItems as $thumbPic => $fullPic): ?>
            <div class="col-md-2 well">
                <a href="#showGallery" class="modalGallery" content="<?= \App::$Alias->scriptUrl . $fullPic ?>" id="gallery-<?= $i ?>">
                    <img src="<?= \App::$Alias->scriptUrl . $thumbPic ?>" class="img-responsive image-item" />
                </a>
            </div>
            <?php $i++ ?>
        <?php endforeach; ?>
        </div>
        <div class="modal fade" id="showGallery" tabindex="-1" role="dialog" aria-labelledby="showshowGallery">
            <div class="modal-dialog modal-max" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                        <h4 class="modal-title" id="showModalLabel"><?= __('View picture') ?></h4>
                    </div>
                    <div class="modal-body" id="modal-gallery-body">
                        <img class="img-responsive" src="<?= \App::$Alias->scriptUrl . $model->posterFull ?>" alt="<?= __('Gallery picture') ?>" style="margin: 0 auto;" />
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>
    <?php if ($search->items !== null && Obj::isArray($search->items)): ?>
        <div class="h3"><?= __('Similar content') ?></div>
        <div class="panel-group">
        <?php $idx = 1; ?>
        <?php foreach ($search->items as $item): ?>
            <div id="similar-group" class="panel panel-default">
                <div class="panel-heading">
                    <h4 class="panel-title">
                        <a data-toggle="collapse" data-parent="#similar-group" href="#similar<?= $idx ?>">
                            <i class="glyphicon glyphicon-sort"></i> <?= $item['title'] ?>
                        </a>
                    </h4>
                </div>
                <div id="similar<?= $idx ?>" class="panel-collapse collapse">
                    <div class="panel-body">
                        <a href="<?= \App::$Alias->baseUrl . $item['uri'] ?>">
                            <?= $item['snippet'] ?>
                        </a>
                    </div>
                </div>
            </div>
            <?php ++$idx; ?>
        <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <div class="row">
    	<div class="col-md-12">
    		<div class="pull-left">
        	<?php if ($properties['rating']) {
        	    echo \App::$View->render('content/_rate', [
        	        'id' => $model->id,
        	        'rating' => $model->rating,
        	        'canRate' => $model->canRate
        	    ]);
        	} ?>
        	<?= \App::$View->render('content/_rateJs') ?>
    		</div>
    		<div class="pull-right">
    		    <?php if ($properties['tags']): ?>
                <div id="content-tags">
                    <?php
                    if (Obj::isArray($model->metaKeywords) && count($model->metaKeywords) > 0 && Str::length($model->metaKeywords[0]) > 0) {
                        echo '<i class="glyphicon glyphicon-tags hidden-xs"></i> ';
                        foreach ($model->metaKeywords as $tag) {
                            $tag = trim($tag);
                            echo Url::link(['content/tag', $tag], $tag, ['class' => 'label label-default']) . "&nbsp;";
                        }
                    }
                    ?>
                </div>
                <?php endif; ?>
    		</div>
    	</div>
    </div>
    <?php if (!Str::likeEmpty($model->source)): ?>
    <div id="content-source" style="padding-top: 5px;">
        <?php
        $sourceUrl = $model->source;
        $parseUrl = parse_url($sourceUrl);
        $sourceHost = $parseUrl['host'];
        ?>
        <i class="glyphicon glyphicon-random"></i> <?= __('Source') ?>: <a href="<?= $sourceUrl ?>" rel="nofollow" target="_blank">
            <?= $sourceHost ?>
        </a>
    </div>
    <?php endif; ?>
</article>
<?php if ($showComments === true): ?>
<div class="row">
    <div class="col-md-12">
        <div class="h3 text-success"><?= __('Comments') ?></div>
        <hr />
        <?= \Widgets\Front\Comments\Comments::widget(['targetClass' => 'wysi-comments', 'config' => 'config-small']); ?>
    </div>
</div>
<?php endif; ?>
<?php if ($model->galleryItems !== null && Obj::isArray($model->galleryItems)): ?>
<script>
    $(document).ready(function(){
        var galleryPos = 1;
        $('.modalGallery').on('click', function() {
            galleryPos = parseInt($(this).attr('id').replace('gallery-', ''));

            var picture = $(this).attr('content');
            if (picture != null && picture.length > 0) {
                var gallerySelector = $('#modal-gallery-body');
                gallerySelector.html('<img class="img-responsive gallery-img" alt="Picture" style="margin: 0 auto;" src="' + picture + '"/>');
                gallerySelector.append('<hr />');
                // add previous & next buttons
                var gSelectors = '<p class="text-center">';
                gSelectors += '<a href="#showGallery" id="gallery-show-prev"><i class="glyphicon glyphicon-arrow-left glyphicon-2x"></i></a> ';
                gSelectors += '<a href="#showGallery" id="gallery-show-next"><i class="glyphicon glyphicon-arrow-right glyphicon-2x"></i></a>';
                gSelectors += '</p>';
                gallerySelector.append(gSelectors);
                $('#showGallery').modal('show');
            }
        });

        // click next image in gallery
        $(document).on('click', '#gallery-show-next', function() {
            galleryPos += 1;
            var imgSel = $('#gallery-'+galleryPos);
            if (imgSel.length < 1) {
                galleryPos -= 1;
                return;
            }

            var newImg = imgSel.attr('content');
            $(this).parent().parent().find('.gallery-img').fadeOut('fast').attr('src', newImg).fadeIn('fast');
        });

        // click previous image in gallery
        $(document).on('click', '#gallery-show-prev', function(){
            galleryPos -= 1;
            var imgSel = $('#gallery-'+galleryPos);
            if (imgSel.length < 1) {
                galleryPos += 1;
                return;
            }
            var newImg = imgSel.attr('content');
            $(this).parent().parent().find('.gallery-img').fadeOut('fast').attr('src', newImg).fadeIn('fast');

        });
        // bind keydown (left * right arrows)
        $(document).keydown(function(e){
            var modalActive = $('#showGallery').hasClass('in');
            switch (e.which) {
                case 37: // left arrow
                    if (modalActive) {
                        $('#gallery-show-prev').trigger('click');
                    }
                    break;
                case 39: // right arrow
                    if (modalActive) {
                        $('#gallery-show-next').trigger('click');
                    }
                    break;
            }
        })
    });
</script>
<?php endif; ?>