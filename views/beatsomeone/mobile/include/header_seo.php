<div>
    <header class="header">
        <div class="wrap">
            <div class="header__logo">
                <a href="<?= lang_url('/') ?>"><img src="/assets_m/images/logo.png" alt=""/></a>
            </div>
            <div class="header__btnbox">
                <a href="<?= $this->config->item('switchLangUrl') ?>" class="header__locale"><?= $this->config->item('locale') == 'en' ? 'KOR' : 'ENG'?></a>
                <input type="text"
                       class="mo-header-input"
                       style="width: 175px;
                                position:absolute;
                                top: 8px;
                                right:60px;
                                height: 25px;
                                color: #fff;
                                background: rgba(255, 255, 255, 0.2);
                                border-radius: 2em;
                                font-size: 12px;
                                padding: 0 35px 0 10px;
                                -webkit-transition: all 0.3s;
                                transition: all 0.3s;"/>
                <a href="javascript:;" class="header__search" style="z-index: 10000"></a>
                <a class="header__nav"></a>
            </div>
        </div>
    </header>

    <div class="gnb" style="display:none;">
        <div class="gnb__bg" ></div>
    </div>

    <!--        <transition name="slide-fade">-->
    <nav class="gnb" style="display:none;">

        <div class="gnb__content">
            <a class="gnb__close">닫기</a>
            <div class="gnb__links">
                <a href="<?= lang_url('/mypage/favorites') ?>"><?= lang('favorite') ?></a>
                <a v-if="isSeller" href="<?= lang_url('/mypage/regist_item') ?>"><?= lang('registrationSources') ?></a>
                <a href="<?= lang_url('/login') ?>"><?= lang('login') ?></a>
                <a href="<?= lang_url('/register') ?>"><?= lang('signup') ?></a>
            </div>
            <div v-html="banner_content" class="gnb__banner">
            </div>
        </div>
    </nav>
</div>
