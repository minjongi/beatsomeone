<?php
$genre = [
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
    <div class="event-header">
        <header class="header">
            <div class="event-top">
                <a href="/event"><img src="/assets/images/event/210110/<?= $this->config->item('locale');?>/bn.jpg'"></a>
            </div>
            <div class="wrap">
                <h1 class="header__logo">
                    <a href="/"><img src="/assets/images/logo.png" alt=""/></a>
                </h1>
                <div class="header__gnb">
                    <div class="header__search">
                        <div>
                            <input type="text"/>
                            <button></button>
                        </div>
                    </div>
                    <nav class="header__nav">
                        <a href=""></a>
                        <a href="/mypage/favorites"><?= lang('favorite') ?></a>
                        <a href="/mypage/regist_item"><?= lang('registrationSources') ?></a>
                        <a href="/mypage""><?= lang('mypage') ?></a>
                        <a href="/login/logout"><?= lang('logout') ?></a>
                        <a href="/login"><?= lang('login') ?></a>
                        <a href="/register"><?= lang('signup') ?></a>
                        <button v-if="!isLogin">
                            <a href="/register" class="sale_signup" @click="signUpClick('seller')"><?= lang('lang119') ?></a>
                            <span class="tooltip">
                            <?= lang('lang120') ?>
                        </span>
                        </button>
                    </nav>
                </div>
            </div>
        </header>
    </div>
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
                            <a href="/beatsomeone/sublist">
                                <button class="active">전체</button>
                            </a>
                            <?php foreach ($genre as $key => $val) { ?>
                                <a href="/beatsomeone/sublist?genre=<?= urlencode($val) ?>">
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
                                                <a href="/detail/<?= $item['cit_key'] ?>#/">
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
                                                            <?php if($item['cit_include_copyright_transfer'] == '1') { ?><img style="margin: 0 5px; width:15px;" src="/assets/images/icon/icon_4.png"/><?php } ?>
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
                                                <a href="/beatsomeone/sublist?search=<?= urlencode($tag) ?>">
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
                                            <a href="/cmallact/download_sample/<?= $item['cde_id'] ?>" class="download"><?= lang('download') ?></a>
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
                                <a class="playList__more" href="/beatsomeone/sublist"><?= lang('mainMore') ?></a>
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
                        <a class="startSelling" href="/register">
                            <?= lang('buyerLogin') ?>
                        </a>
                    </header>
                    <header class="main__section2-title">
                        <h2>
                            <?= lang('bitTradingMessage1') ?><br/>
                            <?= lang('bitTradingMessage2') ?>
                        </h2>
                        <a class="startSelling" href="/register">
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
                                        <a href="/detail/<?= $item['cit_key'] ?>#/">
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
                        <img src="/assets/images/alliance1.png" alt="" href="#" style="opacity: .3"/>
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
                                    <a href="/video#/<?= $post['post_id'] ?>">
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
                            <a class="startSelling" href="/register"><?= lang('startSelling') ?></a>
                            <a href="/beatsomeone/sublist" class="beats"><?= lang('browseBeats') ?></a>
                        </div>
                    </div>
                    <div class="main__desc">
                        <h2>
                            <?= lang('musicWorldMsg1') ?><br/>
                            <?= lang('musicWorldMsg2') ?><br/>
                            <?= lang('areYouReady') ?>
                        </h2>
                        <a class="startSelling" href="/register">
                            <?= lang('trustOurTeamMsg') ?>
                        </a>
                    </div>
                </div>
                <footer class="footer">
                    <div class="wrap">
                        <div class="footer__top">
                            <div class="footer__logo">
                                <img src="/assets/images/logo.png" alt />
                            </div>
                            <div class="footer__sns sns">
                                <a href="https://www.instagram.com/beatsomeone" class="sns__insta" target="_blank">
                                    <img src="/assets/images/icon/instagram.png" alt="instagram" />
                                </a>
                                <a href="https://www.youtube.com/channel/UCkOZTgnHFgC0Cb04W0AJ1LQ" class="sns__insta" target="_blank">
                                    <img src="/assets/images/icon/youtube.png" alt="youtube" />
                                </a>
                                <a href="https://www.facebook.com/beatsomeone" class="sns__insta" target="_blank">
                                    <img src="/assets/images/icon/facebook.png" alt="facebook" />
                                </a>
                                <a href="https://twitter.com/beatsomeone1" class="sns__insta" target="_blank">
                                    <img src="/assets/images/icon/twitter.png" alt="twitter" />
                                </a>
                            </div>
                        </div>
                        <div class="footer__content">
                            <div class="footer__subLink">
                                <div class="row">
                                    <ul>
                                        <li>
                                            <a href="/" style="cursor:default;">BEAT SOMEONE</a>
                                        </li>
                                        <li>
                                            <a href="/register/terms" target="_blank"><?= lang('termsOfService') ?></a>
                                        </li>
                                        <li>
                                            <a href="/register/policy" target="_blank"><?= lang('privacyPolicy') ?></a>
                                        </li>
                                        <li>
                                            <a href="http://dumdum.kr" target="_blank"><?= lang('aboutUs') ?></a>
                                        </li>
                                    </ul>
                                </div>
                                <div class="row">
                                    <a href="http://scan.beatsomeone.com" target="_blank">beatsomeone Blockchain Monitoring System</a>
                                </div>
                            </div>
                        </div>
                        <div class="footer__bottom">
                            <p class="footer__copyright">
                                <?= lang('lang131') ?><br/>
                                <?= lang('lang132') ?><br/>
                                <?= lang('lang133') ?><br/><br/>
                                <?= lang('lang134') ?><br/>
                                <?= lang('lang135') ?>
                            </p>
                        </div>
                    </div>
                </footer>
            </section>
        </div>
    </div>
    <div class="footer-banner">
        <a href="http://wdmastering.com/" target="_blank"><img src="/assets/images/banner/wdmastering.png"></a>
    </div>
</div>