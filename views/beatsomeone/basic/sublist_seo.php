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
<div class="wrapper">
    <?php $this->load->view('beatsomeone/basic/include/header_seo') ?>
    <div class="container sub">
        <div class="sublist">
            <div class="wrap">
                <div class="sublist__filter">
                    <div class="row">
                        <div class="filter">
                            <h2 class="filter__title"><?= lang('filter') ?></h2>
                            <div class="filter__content">
                                <ul class="filter__list">
                                    <?php foreach ($genre as $key => $val) { ?>
                                        <li class="filter__item">
                                            <label class="checkbox">
                                                <input type="radio" name="filter" hidden/>
                                                <?= $genreName[$key] ?>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="filter">
                            <h2 class="filter__title"><?= lang('subGenres') ?></h2>
                            <div class="filter__content" style="display: none;">
                                <ul class="filter__list">
                                    <?php foreach ($genre as $key => $val) { ?>
                                        <li class="filter__item">
                                            <label class="checkbox">
                                                <input type="radio" name="filter" hidden/>
                                                <?= $genreName[$key] ?>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="filter">
                            <h2 class="filter__title folded">BPM</h2>
                            <div class="filter__content" style="display: none;">
                                <div class="bpmRange">
                                    <input type="text" />
                                </div>
                                <div class="bpmRangeInfo">
                                    <input type="text" readonly id="bpm-start" v-model="param.currentBpmFr" />
                                    <span>-</span>
                                    <input type="text" readonly id="bpm-end" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="filter">
                            <h2 class="filter__title folded"><?= lang('moods') ?></h2>
                            <div class="filter__content" style="display: none;">
                                <ul class="filter__list">
                                    <?php foreach ($moods as $key => $val) { ?>
                                        <li class="filter__item">
                                            <label class="checkbox">
                                                <input type="radio" name="filter" hidden/>
                                                <?= $moodsName[$key] ?>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="filter">
                            <h2 class="filter__title folded"><?= lang('trackType') ?></h2>
                            <div class="filter__content" style="display: none;">
                                <ul class="filter__list">
                                    <?php foreach ($trackType as $key => $val) { ?>
                                        <li class="filter__item">
                                            <label class="checkbox">
                                                <input type="radio" name="filter" hidden/>
                                                <?= $trackTypeName[$key] ?>
                                            </label>
                                        </li>
                                    <?php } ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="sublist__content">
                    <div class="row">
                        <?php if (!empty($seoViewData['search'])) { ?>
                            <h1 class="section-title"><?= lang('searchResultsFor') ?> '{{ param.search }}'</h1>
                        <?php } else { ?>
                            <h2 class="section-title">
                                <?php if (empty($seoViewData['search'])) { ?>
                                    <span>TOP</span>
                                    <span class="number">5</span>
                                <?php } ?>
                                <div class="sort">
                                    <span><?= lang('sortBy') ?></span>
                                    <div class="custom-select">
                                        <button class="selected-option"><?= lang('sortBy') ?></button>
                                    </div>
                                </div>
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
                    <div class="row">
                        <?php if (empty($seoViewData['search'])) { ?>
                            <h2 class="section-title"><?= lang('playList') ?></h2>
                        <?php } else { ?>
                            <h2 class="section-title">SEARCH RESULTS</h2>
                        <?php } ?>
                        <div class="playList">
                            <?php foreach ($seoViewData['sublist_list'] as $item) { ?>
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
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('beatsomeone/basic/include/footer_seo') ?>
</div>
