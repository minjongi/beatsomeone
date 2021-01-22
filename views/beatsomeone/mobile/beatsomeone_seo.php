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
?>
<div>
    <div v-if="popup">
      <div class="noti-wrap"></div>
      <div class="noti-content">
        <div>
          <a href="<?= lang_url('/event') ?>"><img src="/assets_m/images/event/210110/<?= $this->config->item('locale');?>/1.png?v=1"></a>
        </div>
        <div>
          <img src="'/assets_m/images/event/210110/<?= $this->config->item('locale');?>/2.png?v=1" style="width:50%;"><img :src="'/assets_m/images/event/210110/<?= $this->config->item('locale');?>/3.png?v=1'" style="width:50%;">
        </div>
      </div>
    </div>
    <div class="wrapper">
        <?php $this->load->view('beatsomeone/mobile/include/header_seo') ?>
        <div class="container">
            <div class="main">
                <section class="main__section1">
                    <header class="main__section1-title">
                        <div class="wrap">
                            <h1><?= lang('MainTitleMsg') ?></h1>
                            <p>
                                <?= lang('findingMusicMsg') ?><br/>
                                <?= lang('mainMsg2') ?>
                            </p>
                        </div>
                    </header>
                    <div class="main__media" style="position:relative;z-index: 100;">
                        <div class="tab">
                            <div class="tab__scroll">
                                <?php foreach ($genre as $key => $val) { ?>
                                    <a href="<?= lang_url('/beatsomeone/sublist?genre=' . urlencode($val)) ?>">
                                        <button><?= $genreName[$key] ?></button>
                                    </a>
                                <?php } ?>
                            </div>
                        </div>
                        <div class="icon__group">
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
                        <div class="playList">
                            <?php foreach ($seoViewData['main_list'] as $item) { ?>
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
                            <div class="playList__btnbox">
                                <a class="playList__more pointer" href="<?= lang_url('/beatsomeone/sublist?search=' . urlencode($tag)) ?>"><?= lang('mainMore') ?></a>
                            </div>
                        </div>
                    </div>
                </section>
                <section class="main__section2">
                    <header class="main__section2-title">
                        <div class="wrap">
                            <h2>
                                <?= lang('bitTradingMessage1') ?>
                                <br/>
                                <?= lang('bitTradingMessage2') ?>
                            </h2>
                            <a href="<?= lang_url('/register') ?>"><?= lang('lendOrSellMyBeat') ?></a>
                        </div>
                    </header>
                    <!-- 트렌딜 슬라이드 부분 -->
                    <div class="trending">
                        <h2 class="trending__title"><?= lang('trendingMusic') ?></h2>
                        <div class="trending__slider">
                            <div class="slider">
                                <?php foreach ($seoViewData['main_trending_list'] as $item) { ?>
                                    <div class="trending__slide-item albumItem">
                                        <a href="<?= lang_url('/detail/' . $item['cit_key']) ?>#/">
                                            <button class="albumItem__cover">
                                                <img src="/uploads/cmallitem/<?= $item['thumb'] ?>" alt="<?= $item['cit_name'] ?>"/>
                                            </button>
                                            <a class="albumItem__link">
                                                <h4 class="albumItem__title"><?= $item['cit_name'] ?></h4>
                                                <p class="albumItem__singer"><?= $item['mem_nickname'] ?></p>
                                            </a>
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- 트렌드 슬라이드 끝 -->
                        <!-- 제휴 업체 로그 이미지  -->
                        <div class="alliance">
                            <img src="/assets_m/images/partner/partner-total1.png" alt href="#"/>
                        </div>
                        <!-- 제휴업체 로그 이미지 끝 -->
                        <div class="testimonials">
                            <div class="wrap">
                                <article class="testimonials__title">
                                    <h2><?= lang('testimonials') ?></h2>
                                    <p><?= lang('bestTeamMember') ?></p>
                                </article>
                                <article class="testimonials__lists">
                                    <?php foreach ($seoViewData['main_testimonials_list'] as $post) { ?>
                                        <figure class="card card--testimonials">
                                            <a href="<?= lang_url('/video#/' . $post['post_id']) ?>">
                                                <div class="img">
                                                    <img src="/uploads/post/<?= $post['post']['files'][0]['pfi_filename'] ?>" alt=""/>
                                                    <button class="card--testimonials_play"></button>
                                                </div>
                                                <figcaption>
                                                    <h3><?= $post['post']['dp_title'] ?? $post['post_title'] ?></h3>
                                                    <p><?= $post['post']['dp_sub_title'] ?? $post['post_nickname'] ?></p>
                                                </figcaption>
                                            </a>
                                        </figure>
                                    <?php } ?>
                                </article>
                                <div class="testimonials__btnbox">
                                    <a href="<?= lang_url('/register') ?>"><?= lang('startSelling') ?></a>
                                    <a href="<?= lang_url('/beatsomeone/sublist') ?>" class="beats"><?= lang('browseBeats') ?></a>
                                </div>
                            </div>
                        </div>
                        <div class="main__desc">
                            <h2>
                                <?= lang('musicWorldMsg1') ?>
                                <br/>
                                <?= lang('musicWorldMsg2') ?>
                                <br/>
                                <?= lang('areYouReady') ?>
                            </h2>
                            <a href="<?= lang_url('/register') ?>"><?= lang('trustOurTeamMsg') ?></a>
                        </div>
                    </div>
                    <?php $this->load->view('beatsomeone/mobile/include/footer_seo') ?>
                </section>
            </div>
        </div>
    </div>
    <div class="footer-banner">
      <a href="http://wdmastering.com/" target="_blank"><img src="/assets_m/images/banner/wdmastering.png"></a>
    </div>
</div>
