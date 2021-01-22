<?php
$genre = [
    'All Genre',
    'Hip hop',
    'K-pop',
    'Pop',
    'R&B',
    'Dance',
    'Rock',
    'Electronic',
    'Jazz',
    'Acoustic',
    'Indie',
    'Reggae',
    'World',
];

$genreName = [];
foreach ($genre as $key => $val) {
    $genreName[$key] = lang('genre' . str_replace('&', '', str_replace('-', '', str_replace(' ', '', $val))));
}

$moods = [
    'Angry',
    'Annoyed',
    'Anxious',
    'Bouncy',
    'Calm',
    'Chill',
    'Confident',
    'Crazy',
    'Dark',
    'Depressed',
    'Dirty',
    'Dope',
    'Energetic',
    'Enraged',
    'Evil',
    'Giddy',
    'Gloomy',
    'Groovy',
    'Happy',
    'Hyper',
    'Kitsch',
    'Lazy',
    'Lo-fi',
    'Lonely',
    'Loved',
    'Majestic',
    'Mellow',
    'Peaceful',
    'Rebellious',
    'Relaxed',
    'Sad',
    'Sensual',
    'Scared',
    'Soulful',
];

$moodsName = [];
foreach ($moods as $key => $val) {
    $moodsName[$key] = lang('moods' . str_replace('&', '', str_replace('-', '', str_replace(' ', '', $val))));
}

$trackType = [
    'Beats',
    'Beats with chorus',
    'Vocals',
    'Song reference',
    'Songs'
];

$trackTypeName = [];
foreach ($trackType as $key => $val) {
    $trackTypeName[$key] = lang('trackType' . str_replace('&', '', str_replace('-', '', str_replace(' ', '', $val))));
}
?>
<div class="wrapper sublist-wrap">
    <?php $this->load->view('beatsomeone/basic/include/header_seo') ?>
    <div class="container sub">
        <div class="sublist">
            <div class="sublist__content">
                <div class="row">
                    <?php if (!empty($seoViewData['search'])) { ?>
                        <h2 class="section-title"><?= lang('searchResultsFor') ?> '{{ param.search }}'</h2>
                    <?php } else { ?>
                        <h2 class="section-title">
                            <?php if (empty($seoViewData['search'])) { ?>
                                <span>TOP</span>
                                <span class="number">5</span>
                            <?php } ?>
                        </h2>
                    <?php } ?>
                    <?php if (empty($seoViewData['search'])) { ?>
                        <div class="topFive">
                            <?php foreach ($seoViewData['sublist_top_list'] as $val) { ?>
                                <div class="trending__slide-item albumItem">
                                    <a href="<?= lang_url('/detail/' . $val['cit_key']) ?>#/">
                                        <button class="albumItem__cover">
                                            <img src="/uploads/cmallitem/<?= $val['thumb'] ?>" alt="<?= $val['cit_name'] ?>"/>
                                        </button>
                                        <a class="albumItem__link">
                                            <h4 class="albumItem__title"><?= $val['cit_name'] ?></h4>
                                            <p class="albumItem__singer"><?= $val['mem_nickname'] ?></p>
                                        </a>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } ?>
                </div>
                <div class="icon__group_sub">
                    <button>
                        <i class="far fa-question-circle" style="color: #ffffff; width: 10px; margin-right: 5px;"></i>
                    </button>
                    <span class="tooltip">
                        <div>
                            <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_1.png"/>
                            <span> <?= lang('lang121') ?></span>
                        </div>
                        <div>
                            <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_2.png"/>
                            <span> <?= lang('lang122') ?></span>
                        </div>
                        <div>
                            <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_3.png"/>
                            <span> <?= lang('lang123') ?></span>
                        </div>
                        <div>
                            <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_4.png"/>
                            <span> <?= lang('lang124') ?></span>
                        </div>
                        <div>
                            <img style="margin-right: 5px; width:15px;" src="/assets/images/icon/icon_5.png"/>
                            <span> <?= lang('lang125') ?></span>
                        </div>
                    </span>

                    <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_1.png"/>
                    <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_2.png"/>
                    <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_3.png"/>
                    <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_4.png"/>
                    <img style="margin-left: 5px; width:16px;" src="/assets/images/icon/icon_5.png"/>
                </div>
                <div class="row">
                    <div class="playList" v-infinite-scroll="loading" infinite-scroll-immediate-check="false">
                        <?php foreach ($seoViewData['sublist_list'] as $item) { ?>
                            <li class="playList__itembox">
                                <div class="playList__item playList__item--title">
                                    <div class="col favorite">
                                        <button><?= lang('favorite') ?></button>
                                    </div>
                                    <div class="col name">
                                        <figure>
                                            <div class="playList__cover">
                                                <img src="/uploads/cmallitem/<?= $item['thumb'] ?>" alt/>
                                            </div>
                                            <button class="btn-play">재생</button>
                                            <div class="wave"></div>
                                            <a href="<?= lang_url('/detail/' . $item['cit_key']) ?>#/">
                                                <figcaption>
                                                    <h3 class="playList__title"><?= $item['cit_name'] ?></h3>
                                                    <div class="playList__bottom-info">
                                                        <span class="playList__by">by <?= $item['mem_nickname'] ?></span>
                                                        <div class="">
                                                            <?php if($item['cit_freebeat'] == '1') { ?><img style="margin: 0 5px; width:15px;" src="/assets/images/icon/icon_1.png"/><?php } ?>
                                                            <?php if($item['cit_type5'] == '1') { ?><img style="margin: 0 5px; width:15px;" src="/assets/images/icon/icon_2.png"/><?php } ?>
                                                            <?php if($item['cit_officially_registered'] == '1') { ?><img style="margin: 0 5px; width:15px;" src="/assets/images/icon/icon_3.png"/><?php } ?>
                                                            <?php if($item['voice'] == '1') { ?><img style="margin: 0 5px; width:15px;" src="/assets/images/icon/icon_4.png"/><?php } ?>
                                                            <?php if($item['cit_org_content'] == '1') { ?><img style="margin: 0 5px; width:15px;" src="/assets/images/icon/icon_5.png"/><?php } ?>
                                                        </div>
                                                    </div>
                                                </figcaption>
                                            </a>
                                        </figure>
                                    </div>
                                    <div class="col buybtn">
                                        <button>
                                            <i class="fa fa-shopping-cart" style="color: #ffda2a;"></i>
                                        </button>
                                    </div>
                                    <div class="col more">
                                        <button><?= lang('more') ?></button>
                                        <span class="tooltip">
                                                <a><?= lang('lang107') ?></a>
                                                <a><?= lang('lang108') ?></a>
                                                <a><?= lang('lang109') ?></a>
                                            </span>
                                    </div>
                                </div>
                            </li>
                        <?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('beatsomeone/mobile/include/footer_seo') ?>
</div>
