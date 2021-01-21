<div class="wrapper">
    <?php $this->load->view('beatsomeone/basic/include/header_seo') ?>
    <div class="container detail">
        <div class="detail__header">
            <div class="wrap">
                <div class="detail__music">
                    <div class="detail__music-img">
                        <img src="/uploads/cmallitem/<?= $item['cit_file_1'] ?>" alt/>
                    </div>
                    <div class="detail__music-info">
                        <h2 class="title"><?= $item['cit_name'] ?></h2>
                        <p class="singer"><?= $item['mem_nickname'] ?></p>
                        <div class="state">
                            <span class="registed"><?= $item['cit_start_datetime'] ?></span>
                            <div class="etc"><?= $item['info_content'] ?></div>
                        </div>
                        <div class="utils">
                            <div class="utils__info">
                                <a class="buy waves-effect">
                                    <span>
                                    <?php
                                    if ($item['cit_lease_license_use'] == '1') {
                                        $this->config->item('locale') == 'ko' ? $item['detail']['LEASE']['cde_price'] : $item['detail']['LEASE']['cde_price_d'];
                                    } else {
                                        $this->config->item('locale') == 'ko' ? $item['detail']['STEM']['cde_price'] : $item['detail']['STEM']['cde_price_d'];
                                    }
                                    ?>
                                    </span>
                                </a>
                                <span class="talk pointer"><?= $item['cit_review_count'] ?></span>
                                <div class="share">
                                    <span><?= $item['cit_share_count'] ?></span> /
                                    <span class="share pointer"><?= lang('lang107') ?></span> /
                                    <span class="share pointer"><?= lang('lang108') ?></span> /
                                    <span class="share pointer"><?= lang('lang109') ?></span>
                                </div>
                            </div>
                        </div>
                        <div class="utils" v-if="item" style="margin-top: 10px;">
                            <div class="tags">
                                <?php if($item['cit_freebeat'] == '1') { ?>
                                    <button style="color:#3873d3;"><?= lang('lang1') ?></button>
                                <?php } ?>
                                <?php if($item['cit_org_content'] == '1') { ?>
                                    <button style="color:#ffda2a;"><?= lang('lang2') ?></button>
                                <?php } ?>
                                <?php if($item['cit_officially_registered'] == '1') { ?>
                                    <button style="color:#fff;"><?= lang('lang3') ?></button>
                                <?php } ?>
                            </div>
                            <div class="category" style="width: 100%;">
                                <?php foreach($seoViewData['hashtag'] as $val) { ?>
                                    <span class="pointer"><?= $val ?>></span>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail__player">
                    <button class="detail__player-controller"></button>
                    <div id="detail__player-wave">
                    </div>
                </div>
                <div class="detail__comment">
                    <form action>
                        <div class="commentForm">
                            <a href class="comment__user"></a>
                            <input type="text" placeholder="<?= lang('writeComment') ?>" id="comment" maxlength="200"/>
                            <span id="commentLength">0/200</span>
                            <button><?= lang('send') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="detail__body">
            <div class="wrap">
                <div class="tab">
                    <button><?= lang('similarTrack') ?></button>
                    <button><?= lang('comments') ?></button>
                    <button><?= lang('information') ?></button>
                </div>
                <div class="detail__content">
                    <div class="playList" v-infinite-scroll="getListMore" infinite-scroll-immediate-check="false"  v-if="list">
                        <ul id="playList__list" class="playList__list">
                            <?php foreach ($seoViewData['detail_similartracks_list'] as $item) { ?>
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
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('beatsomeone/basic/include/footer_seo') ?>
</div>