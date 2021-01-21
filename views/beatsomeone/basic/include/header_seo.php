<div class="event-header">
    <header class="header">
        <div class="event-top">
            <a href="/event"><img src="/assets/images/event/210110/<?= $this->config->item('locale');?>/bn.jpg"></a>
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