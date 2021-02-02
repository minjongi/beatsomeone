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
<div class="wrapper">
    <?php $this->load->view('beatsomeone/basic/include/header_seo') ?>
    <div class="container">
        <div class="main">
            <section class="main__section1">
                <div class="filter"></div>
                <div class="wrap">
                    <header class="main__section1-title">
                        <h1><?= lang('MainTitleMsg') ?></h1>
                        <p>
                            <?= lang('findingMusicMsg') ?><br/>
                            <?= lang('mainMsg2') ?>
                        </p>
                    </header>
                    <div class="main__media">
                        <div class="tab">
                            <?php foreach ($genre as $key => $val) { ?>
                                <a href="<?= lang_url('/sublist?genre=' . urlencode($val)) ?>">
                                    <button><?= $genreName[$key] ?></button>
                                </a>
                            <?php } ?>
                        </div>
                        <div class="filter">
                            <label for="voice" class="switch">
                                <?= lang('voice') ?>
                                <input type="checkbox" hidden id="voice"/>
                                <span></span>
                            </label>
                            <div class="custom-select ">
                                <button class="selected-option">
                                    <?= lang('sortItemSortBy') ?>
                                </button>
                            </div>
                            <div class="custom-select ">
                                <button class="selected-option">
                                    BPM
                                </button>
                            </div>
                        </div>
                        <div class="playList">
                            <?php foreach ($seoViewData['main_list'] as $item) { ?>
                                <li class="playList__itembox">
                                    <div class="playList__item playList__item--title">
                                        <div class="col favorite">
                                            <button><?= lang('favorite') ?></button>
                                        </div>
                                        <div class="col favorite">
                                            <label class="checkbox nfavorites__checkbox">
                                                <input type="checkbox" hidden>
                                                <span></span>
                                            </label>
                                        </div>

                                        <div class="col name">
                                            <figure>
                                                <span class="playList__cover"><img src="/uploads/cmallitem/<?= $item['thumb'] ?>" alt/></span>
                                                <a href="<?= lang_url('/detail/' . $item['cit_key']) ?>#/">
                                                    <figcaption class="pointer">
                                                        <h3 class="playList__title"><?= $item['cit_name'] ?></h3>
                                                        <span class="playList__by">by <?= $item['mem_nickname'] ?></span>
                                                    </figcaption>
                                                </a>
                                            </figure>
                                            <?php if ($item['cit_freebeat'] == '1' || $item['cit_type5'] == '1' || $item['cit_officially_registered'] == '1' || $item['cit_include_copyright_transfer'] == '1' || $item['cit_org_content'] == '1') { ?>
                                                <div class="tags" >
                                                    <button>
                                                        <div @mouseover="hovered = true" @mouseleave="hovered = false">
                                                            <?php if($item['cit_freebeat'] == '1') { ?><img style="margin: 0 5px; width:15px;" src="/assets/images/icon/icon_1.png"/><?php } ?>
                                                            <?php if($item['cit_type5'] == '1') { ?><img style="margin: 0 5px; width:15px;" src="/assets/images/icon/icon_2.png"/><?php } ?>
                                                            <?php if($item['cit_officially_registered'] == '1') { ?><img style="margin: 0 5px; width:15px;" src="/assets/images/icon/icon_3.png"/><?php } ?>
                                                            <?php if($item['voice'] == '1') { ?><img style="margin: 0 5px; width:15px;" src="/assets/images/icon/icon_4.png"/><?php } ?>
                                                            <?php if($item['cit_org_content'] == '1') { ?><img style="margin: 0 5px; width:15px;" src="/assets/images/icon/icon_5.png"/><?php } ?>
                                                        </div>
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
                                                    </button>
                                                </div>
                                            <?php } ?>
                                            <!-- 서브리스트 토글 버튼 -->
                                            <button class="toggle-subList"></button>
                                        </div>
                                        <div class="col genre">
                                            <?php
                                            $hashTag = explode(',', $item['hashTag']);
                                            foreach ($hashTag as $tag) {
                                                ?>
                                                <a href="<?= lang_url('/sublist?search=' . urlencode($tag)) ?>">
                                                    <span><button><?= $tag ?></button></span>
                                                </a>
                                            <?php } ?>
                                        </div>
                                        <div class="col playbtn">
                                            <button class="btn-play">재생</button>
                                            <span class="timer">
                                                <span class="current">0:00 /</span>
                                                <span class="duration">
                                                    <?php
                                                    $min = floor($item['duration'] / 60);
                                                    $min = empty($min) ? '0' : $min;
                                                    $sec = floor($item['duration'] % 60);
                                                    $sec = ($sec < 10) ? '0' . $sec : $sec;
                                                    echo  $min . ':' . $sec;
                                                    ?>
                                                </span>
                                            </span>
                                        </div>
                                        <div class="col spectrum">
                                            <div class="wave"></div>
                                        </div>
                                        <div class="col buybtn">
                                            <button @click="addCart"><?= lang('lang106') ?></button>
                                        </div>
                                        <div class="col utils" v-if="false">
                                            <a href="<?= lang_url('/cmallact/download_sample/' . $item['cde_id']) ?>" class="download"><?= lang('download') ?></a>
                                        </div>
                                        <div class="col more_shared">
                                            <button>
                                                <?= lang('share') ?>
                                                <span class="tooltip">
                                                    <a><?= lang('lang107') ?></a>
                                                    <a><?= lang('lang108') ?></a>
                                                    <a><?= lang('lang109') ?></a>
                                                </span>
                                            </button>
                                        </div>
                                    </div>
                                </li>
                            <?php } ?>
                            <div class="playList__btnbox">
                                <a class="playList__more" href="<?= lang_url('/sublist') ?>"><?= lang('mainMore') ?></a>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
            <section class="main__section2">
                <div class="filter reverse"></div>
                <div class="wrap">
                    <header class="main__section2-title-login" v-if="false">
                        <h2>
                            <?= lang('backgroundMusicMessage1') ?><br/>
                            <?= lang('backgroundMusicMessage2') ?>
                        </h2>
                        <a class="startSelling" href="<?= lang_url('/register') ?>">
                            <?= lang('buyerLogin') ?>
                        </a>
                    </header>
                    <header class="main__section2-title">
                        <h2>
                            <?= lang('bitTradingMessage1') ?><br/>
                            <?= lang('bitTradingMessage2') ?>
                        </h2>
                        <a class="startSelling" href="<?= lang_url('/register') ?>">
                            <?= lang('lendOrSellMyBeat') ?>
                        </a>
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
                    </div>
                    <!-- 트렌드 슬라이드 끝 -->
                    <!-- 제휴 업체 로그 이미지  -->
                    <div class="alliance">
                        <img src="/assets/images/alliance1.png" alt="alliance" href="#" style="opacity: .3"/>
                    </div>
                    <!-- 제휴업체 로그 이미지 끝 -->
                    <div class="testimonials">
                        <article class="testimonials__title">
                            <h2><?= lang('testimonials') ?></h2>
                            <p><?= lang('bestTeamMember') ?></p>
                        </article>
                        <article class="testimonials__lists">
                            <?php foreach ($seoViewData['main_testimonials_list'] as $post) { ?>
                                <figure class="card card--testimonials">
                                    <a href="<?= lang_url('/video#' . $post['post_id']) ?>">
                                        <div class="img">
                                            <img src="/uploads/post/<?= $post['post']['files'][0]['pfi_filename'] ?>" alt="<?= $post['post_title'] ?>"/>
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
                            <a class="startSelling" href="<?= lang_url('/register') ?>"><?= lang('startSelling') ?></a>
                            <a href="<?= lang_url('/sublist') ?>" class="beats"><?= lang('browseBeats') ?></a>
                        </div>
                    </div>
                    <div class="main__desc">
                        <h2>
                            <?= lang('musicWorldMsg1') ?><br/>
                            <?= lang('musicWorldMsg2') ?><br/>
                            <?= lang('areYouReady') ?>
                        </h2>
                        <a class="startSelling" href="<?= lang_url('/register') ?>">
                            <?= lang('trustOurTeamMsg') ?>
                        </a>
                    </div>
                </div>
                <?php $this->load->view('beatsomeone/basic/include/footer_seo') ?>
            </section>
        </div>
    </div>
    <div class="footer-banner">
        <a href="http://wdmastering.com/" target="_blank"><img src="/assets/images/banner/wdmastering.png"></a>
    </div>
</div>