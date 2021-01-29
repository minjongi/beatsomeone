<div class="event-header">
    <header class="header">
        <div class="event-top">
            <a href="<?= lang_url('/event') ?>"><img src="/assets/images/event/210110/<?= $this->config->item('locale');?>/bn.jpg"></a>
        </div>
        <div class="wrap">
            <div class="header__logo">
                <a href="<?= lang_url('/') ?>"><img src="/assets/images/logo.png" alt=""/></a>
            </div>
            <div class="header__gnb">
                <div class="header__search">
                    <div>
                        <input type="text"/>
                        <button></button>
                    </div>
                </div>
                <nav class="header__nav">
                    <a href="<?= lang_url('/mypage/favorites') ?>"><?= lang('favorite') ?></a>
                    <a href="<?= lang_url('/mypage/regist_item') ?>"><?= lang('registrationSources') ?></a>
                    <a href="<?= lang_url('/mypage') ?>"><?= lang('mypage') ?></a>
                    <a href="<?= lang_url('/login/logout') ?>"><?= lang('logout') ?></a>
                    <a href="<?= lang_url('/login') ?>"><?= lang('login') ?></a>
                    <a href="<?= lang_url('/register') ?>"><?= lang('signup') ?></a>
                    <a href="<?= $this->config->item('switchLangUrl') ?>"><?= $this->config->item('locale') === 'ko' ? 'ENG' : 'KOR' ?></a>
                </nav>
            </div>
        </div>
    </header>
</div>