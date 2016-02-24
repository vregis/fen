<?php

use \common\models\GalleryImages;

/* @var $this yii\web\View */
$this->title = 'My Yii Application';
$this->registerMetaTag([
    'name' => 'description',
    'content' => $this->title,
]);
$this->registerMetaTag([
    'name' => 'keywords',
    'content' => $this->title
]);
$this->title = $aPage['title'];

$this->metaTags = ['description'=> '','keywords'=>''];
$this->registerMetaTag(['name' => 'description', 'content' => $aPage['description']], 'description');
$this->registerMetaTag(['name' => 'keywords', 'content' => $aPage['keywords']], 'keywords');
?>
<?= Yii::$app->getSession()->getFlash('mail');?>

<div class="sidebar sidebar_left">

</div>
<div class="vacansies">Вакансии</div>
<div class="sidebar sidebar_right">

</div>
<div class="order order__m">Записаться</div>

<div class="socials">
    <a href="<?=$aSocial['Facebook']?>" class="socials__fb" target="_blank"></a>
    <a href="<?=$aSocial['Instagram']?>" class="socials__inst" target="_blank"></a>
</div>
<nav class="menu-wrapper">
    <div class="nav__mobile_menu">
        <span class="nav__burger"></span>
        <span class="nav__burger"></span>
        <span class="nav__burger"></span>
    </div>
    <ul class="menu">
        <li class="menu__li">
            <a href="#header" class="menu__a menu__a_first">О компании</a>
        </li>
        <li class="menu__li">
            <a href="#servises" class="menu__a menu__a_second">Услуги</a>
        </li>
        <li class="menu__li">
            <a href="#events" class="menu__a menu__a_third">Новости</a>
        </li>
        <li class="menu__li">
            <a href="#contacts" class="menu__a menu__a_ford">Контакты</a>
        </li>
        <li class="menu__li menu__li-order">
            <a class="order__mobile">Записаться</a>
        </li>
        <li class="menu__li menu__li-vacansies">
            <a class="vacansies__mobile">Вакансии</a>
        </li>
        <div class="socials__mobile">
            <a href="" class="socials__fb"></a>
            <a href="" class="socials__inst"></a>
        </div>
    </ul>
</nav>

<div class="popapp popapp_forms">

    <form class="callback callback_active" id="price-order" method="post" action="/message">
        <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />
        <div class="callback__h1">ЗАПИШИТЕСЬ ОНЛАЙН</div>
        <div class="callback__inputs callback__inputs_active">
            <input type="text" name="name" placeholder="Имя">
            <input type="text" name="sername" placeholder="Фамилия">
            <input type="text" name="servise" id="servise" placeholder="Услуга">
            <input type="text" name="time" placeholder="Время">
            <textarea name="text" rows="8" cols="40" placeholder="Дополнительные пожелания..."></textarea>
            <input type="submit" value="записаться">
        </div>
        <div class="callback__thanks">

        </div>
        <div class="close"></div>
    </form>
</div>

<div class="popapp popapp_vacancies">
    <div class="vacancies">
        <div class="close"></div>
        <h2>
            ВАКАНСИИ
        </h2>

        <h3">
            <?= $aAction['action'] ?>
        </h3>
    </div>
</div>


<?php foreach($aaNews as $aNews): ?>

    <div class="popapp popapp_news" data-article="<?= $aNews['id'] ?>">
    <div class="article">
        <div class="close"></div>
        <h2><?= $aNews['name'] ?></h2>
        <div class="article__slider">
            <?php
            $o = GalleryImages::getImages($aNews->gallery['id']);
            foreach($o as $oImage):?>
                <?= \yii\helpers\Html::img(\common\models\GalleryImages::PATHSHOW . $oImage->basename.'.'.$oImage->ext
                    ); ?>
            <?php endforeach; ?>
        </div>

        <p><?= $aNews['text'] ?></p>
    </div>
</div>
<?php endforeach; ?>

<a href="#header" class="logo-wrapper">
    <img src="/img/Pod_Fenom_logo.svg" alt="" class="logo">
</a>
<div class="fullpage">
<?php $headImage = GalleryImages::find()->where(['id' => 15])->one();?>
    <section id="header" <?php echo ($headImage)?'style="background-image:url(/frontend/web/userfiles/gallery/'.$headImage->basename.'.'.$headImage->ext.')"':''?> class="fullpage__header">

        <div class="header__h1">
            <div class="content-wrapper content-wrapper_d">
                <div class="h1 h1__d"><?= $aPage['name'] ?></div>
            </div>
        </div>

    </section>
    <div class="company-description">
        <div class="company-description__content">
            <div class="company-description__p"><?= $aPage['text'] ?></div>
        </div>
    </div>
    <section id="advantages" class="fullpage__individuality">
        <div class="individuality__h1">
            <div class="content-wrapper">
                <div class="h1 h1_individuality">НАШИ ПРЕИМУЩЕСТВА</div>
            </div>
        </div>
        <div class="advantage-wrapper">
            <?php foreach($aaAdvantages as $aAdvantages): ?>
                <?= in_array($aAdvantages['priority'],[1,5])? '<div class="in-two">':'' ?>
                <div class="advantage">
                    <div class="advantage__nomber"><?= $aAdvantages['priority']?>.</div>
                    <div class="advantage__text"><?= $aAdvantages['data']?></div>
                </div>
                <?= in_array($aAdvantages['priority'],[4,8])? '</div>':'' ?>
            <?php endforeach; ?>
        </div>
    </section>
    <section id="servises" class="fullpage__servises">
        <div class="servises-header">

            <?php  foreach($aSlider= $aSlider?:[] as $sSlider): ?>
                <img src="<?= \common\models\GalleryImages::PATHSHOW.$sSlider->basename.'.'.$sSlider->ext
                    ?>" alt="" class="servises-header__img servises-header__img_active" data-link-img="<?=$sSlider->id?>">
            <?php endforeach; ?>

            <div class="servises__h1">
                <div class="content-wrapper">
                    <div class="h1 h1_individuality">УСЛУГИ</div>
                </div>
            </div>
        </div>

        <div class="servises__menu">
            <div class="content-wrapper">
                <div class="content-wrapper2">
                    <?php $active = true; foreach($aaPriceType as $aPriceType):?>
                    <div class="<?= $active? 'servise__link servise__link_active':'servise__link'?>" data-link="<?=
                            $aPriceType['id']?>">
                        <?= strtoupper($aPriceType['name'])?></div>
                    <?php $active = false; endforeach;?>
                </div>
            </div>
        </div>
        <div class="servises__table-wrapper">

            <?php $active = true; foreach($aaPriceType as $aPriceType):?>
                <div class="servises__table <?= $active? 'servises__table_active':''?>" data-table="table-<?=
                        $aPriceType['id']?>">
                    <div class="servise servise_header">
                        <div class="servise__1">Услуга</div>
                        <div class="servise__2">Стоимость</div>
                        <div class="servise__3">Время</div>
                    </div>
                    <?php foreach($aaPriceCategory as $aPriceCategory):?>
                        <?php if($aPriceType->id === $aPriceCategory->type_id):?>
                            <?php if($aPriceCategory['name']):?>
                                <div class="servises__table_header">
                                    <?=$aPriceCategory['name']?>
                                </div>
                            <?php endif; ?>
                            <?php foreach($aaPrice as $aPrice):?>
                                <?php if($aPriceCategory['id'] === $aPrice->category_id):?>
                                    <div data-form="Укладка дневная" class="servise">
                                        <div class="servise__1">
                                            <div><?=$aPrice['name']?></div>
                                            <div></div>
                                        </div>
                                        <div class="servise__2"><span><?=$aPrice['price']?></span></div>
                                        <div class="servise__3"><span><?=$aPrice['time']?></span></div>
                                    </div>
                                <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>
            <?php $active = false; endforeach;?>

        </div>
    </section>
    <section id="events" class="fullpage__servises">
        <div class="events-header">
            <?php $botImage = GalleryImages::find()->where(['id' => 16])->one();?>
            <?php if($botImage):?>
                <img src="/frontend/web/userfiles/gallery/<?php echo $botImage->basename?>.<?php echo $botImage->ext?>" alt="" class="events-header__img">
            <?php else:?>
            <img src="/img/bg/bg4.jpg" alt="" class="events-header__img">
            <?php endif;?>
            <div class="events__h1">
                <div class="content-wrapper">
                    <div class="h1 h1_individuality">ПОСЛЕДНИЕ СОБЫТИЯ</div>
                </div>
            </div>
        </div>
        <div class="events__slider">
            <?php foreach($aaNews as $aNews): ?>
            <div class="event" data-event="<?=$aNews['id']?>">
                <div class="event__img">
                    <?= \yii\helpers\Html::img(\common\models\News::PATH . $aNews['image'])?>
                </div>
                <div class="event__hover">
                    <div class="event__header"><?=$aNews['name']?></div>
                    <div class="event__date"><?=date('d.m.Y', $aNews['created_at'])?></div>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    </section>
    <div id="contacts" class="fullpage__contacts">
        <div id="map"  class="contacts__map">

        </div>
        <div class="contact">
            <div class="contact__h1">Контакты</div>
            <div class="contact__inf"><?= $aContact['address'] ?></div>
            <div class="contact__inf"><?= $aContact['phone'] ?></div>
            <div class="contact__inf">
                <div class="contact__day">Пн.</div>
                <div class="contact__day">Вт.</div>
                <div class="contact__day">Ср.</div>
                <div class="contact__day">Вс.</div>
                <div class="contact__time"><?= $aContact['first_time'] ?></div>

            </div>

            <div class="contact__inf">
                <div class="contact__day">Чт.</div>
                <div class="contact__day">Пт.</div>
                <div class="contact__day">Сб.</div>

                <div class="contact__time"><?= $aContact['second_time'] ?></div>

            </div>

        </div>
    </div>


</div>
