<div class="wrapper">
    <?php $this->load->view('beatsomeone/basic/include/header_seo') ?>
    <div class="container detail">
        <div class="detail__header">
            <div class="wrap">
                <div class="detail__music">
                    <div class="detail__music-img">
                        <button class="btn-play amplitude-play-pause ">
                            <img src="/uploads/cmallitem/<?= $item['cit_file_1'] ?>" alt=""/>
                        </button>
                    </div>
                    <div class="detail__music-info">
                        <h2 class="title" style="font-weight: 600;"><?= $item['cit_name'] ?></h2>
                        <div class="state">
                            <span class="state-singer"><?= $item['mem_nickname'] ?></span>
                            <span class="registed"><?= $item['cit_start_datetime'] ?></span>
                        </div>
                        <div style="font-size: 12px; margin-top: 10px">
                            <span class="fa fa-share-alt"></span>
                            <span class="share pointer"><?= lang('lang107') ?></span> /
                            <span class="pointer"><?= lang('lang108') ?></span> /
                            <span class="pointer"><?= lang('lang109') ?></span>
                        </div>
                        <div class="utils" v-if="item">
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
                            </div>
                        </div>
                    </div>
                </div>
                <div class="player player--static">
                    <div class="wrap">
                        <div class="player__top">
                            <div class="player__progress">
                                <div id="progress-container">
                                    <input type="range" class="amplitude-song-slider" step=".1"/>
                                    <progress id="song-played-progress" class="amplitude-song-played-progress"></progress>
                                    <progress id="song-buffered-progress" class="amplitude-buffered-progress" data-amplitude-song-index="0"></progress>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="detail__comment">
                    <form action="">
                        <div class="commentForm">
                            <a href="" class="comment__user"></a>
                            <input type="text" placeholder="Write a comment..." id="comment" maxlength="200"/>
                            <span id="commentLength">0/200</span>
                            <button @click="sendComment"><?= lang('send') ?></button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="detail__body">
            <div class="tab">
                <div class="tab__scroll-none">
                    <button><?= lang('similarTrack') ?></button>
                    <button><?= lang('comments') ?></button>
                    <button><?= lang('information') ?></button>
                </div>
            </div>
            <div class="detail__content">
                <div class="playList" v-infinite-scroll="getListMore" infinite-scroll-immediate-check="false" v-if="list">
                    <ul id="playList__list" class="playList__list">
                        <?php foreach ($seoViewData['detail_similartracks_list'] as $item) { ?>
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
                                            <a href="/detail/<?= $item['cit_key'] ?>#/">
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
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php $this->load->view('beatsomeone/mobile/include/footer_seo') ?>
</div>
