<?php $this->managelayout->add_css(element('view_skin_url', $layout) . '/css/style.css'); ?>

<div class="provision">
    <div class="table-box">
        <div class="table-heading">회원 유형 선택</div>
        <div class="table-body">
            <ol>
                <li>
                    <a class="btn btn-default btn-sm" href="/register/register_user">일반 회원</a>
                </li>
                <li>
                    <a class="btn btn-default btn-sm" href="/register/register_musician">뮤지션 회원</a>
                </li>
            </ol>
        </div>
    </div>
</div>