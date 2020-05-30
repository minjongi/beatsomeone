<template>

    <div class="wrapper">

        <Header :is-login="isLogin"/>
        <div class="container sub">
            <div class="mypage sublist">
                <div class="wrap">
                    <div class="sublist__filter sticky">
                        <div class="row center">
                            <div class="profile">
                                <div class="portait">
                                    <img v-if="mem_photo === ''" src="/assets/images/portait.png"/>
                                    <img v-else :src="'http://dev.beatsomeone.com/uploads/member_photo/' + mem_photo" alt="">
                                </div>
                                <div class="info">
                                    <div class="group">
                                        <div class="group_title" :class="group_title">{{group_title}}</div>
                                    </div>
                                    <div class="username">
                                        {{mem_nickname}}
                                    </div>
                                    <div class="bio">
                                        Music Lover, KKOMA
                                    </div>
                                    <div class="location">
                                        <img class="site" src="/assets/images/icon/position.png"/><div>{{mem_address1}}</div>
                                    </div>
                                    <div class="brandshop">
                                        <img class="shop" src="/assets/images/icon/shop.png"/><a href="#">Go to Brandshop ></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <ul class="menu">
                                <li @click="goPage('')">Dashboard</li>
                                <li @click="goPage('profilemod')">Manage Information</li>
                                <li @click="goPage('list_item')">Product List</li>
                                <li class="active">Order History</li>
                                <li v-show="group_title == 'SELLER'">Sales History</li>
                                <li v-show="group_title == 'SELLER'">Settlement History</li>
                                <li>Message</li>
                                <li v-show="group_title == 'CUSTOMER'">Seller Register</li>
                                <li @click="goPage('inquiry')">Support
                                    <ul class="menu">
                                        <li @click="goPage('inquiry')">Support Case</li>
                                        <li @click="goPage('faq')">FAQ</li>
                                    </ul>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="sublist__content" style="margin-bottom:100px;">

                        <div class="row" style="margin-bottom:30px;">
                            
                            <div class="title-content">
                                <div class="title">
                                    <div>Order detail</div>
                                </div>
                            </div>

                            <div class="main__media board inquirylist">
                                <div class="tab" style="height:48px; justify-content:flex-start;">
                                    <div>
                                        <div class="title">No</div>
                                        <div>Order_099</div>
                                    </div>
                                    <div>
                                        <div class="title">Date</div>
                                        <div>0000-00-00 00:00:00</div>
                                    </div>
                                    <div>
                                        <div class="title">Status</div>
                                        <div class="blue">Order Complete</div>
                                    </div>
                                </div>
                            </div>

                        </div>

                        <div class="row" style="margin-bottom:10px;">
                            
                            <div class="title-content">
                                <div class="title">
                                    <div><span class="yellow">3</span> Ordered items</div>
                                </div>
                            </div>

                            <div class="playList productList orderlist" style="margin-top:10px;">
                                <ul>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title active">
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <!-- <img :src="'/assets/images/cover_default.png'" alt=""> -->
                                                        <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'" alt="">
                                                        <i class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <div class="info">
                                                          <div class="code">item.cit_key</div>
                                                        </div>
                                                        <h3 class="playList__title">formatCitName(item.cit_name)</h3>
                                                        <span class="playList__by">(item.bpm)</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col option">
                                                <div>
                                                    <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                    <div>
                                                        <div class="title">UNLIMITED STEMS LICENSE PRICE</div>
                                                        <div class="detail">MP3 or WAV + STEMS</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>No other activities not authorized by the platform</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="listen">
                                                    <div class="playbtn">
                                                        <button class="btn-play">재생</button>
                                                        <span class="timer"><span class="current">0:00 / </span>
                                                        <span class="duration">0:00</span></span>
                                                    </div>
                                                    <div class="col spectrum">
                                                        <div class="wave"></div>
                                                    </div>
                                                </div>
                                                <div class="price" style="margin-top:32px;">
                                                    $10.00
                                                </div>
                                            </div>
                                            <div class="col edit">
                                                <button @click="productEditBtn(item.cit_key)" class="btn-edit"><img src="/assets/images/icon/down.png"/></button>
                                                <div class="download_status blue">Download Complete</div>
                                                <div class="download_period">40 days left<br/>(~2020.06.24 12:30:34)</div>
                                            </div>
                                            <div class="col genre">
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title">
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <!-- <img :src="'/assets/images/cover_default.png'" alt=""> -->
                                                        <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'" alt="">
                                                        <i class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <div class="info">
                                                          <div class="code">item.cit_key</div>
                                                        </div>
                                                        <h3 class="playList__title">formatCitName(item.cit_name)</h3>
                                                        <span class="playList__by">(item.bpm)</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col option">
                                                <div>
                                                    <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                    <div>
                                                        <div class="title">UNLIMITED STEMS LICENSE PRICE</div>
                                                        <div class="detail">MP3 or WAV + STEMS</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>No other activities not authorized by the platform</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="listen">
                                                    <div class="playbtn">
                                                        <button class="btn-play">재생</button>
                                                        <span class="timer"><span class="current">0:00 / </span>
                                                        <span class="duration">0:00</span></span>
                                                    </div>
                                                    <div class="col spectrum">
                                                        <div class="wave"></div>
                                                    </div>
                                                </div>
                                                <div class="price" style="margin-top:32px;">
                                                    $10.00
                                                </div>
                                            </div>
                                            <div class="col edit">
                                                <button @click="productEditBtn(item.cit_key)" class="btn-edit"><img src="/assets/images/icon/down.png"/></button>
                                                <div class="download_status green">Download Available</div>
                                                <div class="download_period">40 days left<br/>(~2020.06.24 12:30:34)</div>
                                            </div>
                                            <div class="col genre">
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title active">
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <!-- <img :src="'/assets/images/cover_default.png'" alt=""> -->
                                                        <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'" alt="">
                                                        <i class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <div class="info">
                                                          <div class="code">item.cit_key</div>
                                                        </div>
                                                        <h3 class="playList__title">formatCitName(item.cit_name)</h3>
                                                        <span class="playList__by">(item.bpm)</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col option">
                                                <div>
                                                    <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                    <div>
                                                        <div class="title">UNLIMITED STEMS LICENSE PRICE</div>
                                                        <div class="detail">MP3 or WAV + STEMS</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>No other activities not authorized by the platform</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="listen">
                                                    <div class="playbtn">
                                                        <button class="btn-play">재생</button>
                                                        <span class="timer"><span class="current">0:00 / </span>
                                                        <span class="duration">0:00</span></span>
                                                    </div>
                                                    <div class="col spectrum">
                                                        <div class="wave"></div>
                                                    </div>
                                                </div>
                                                <div class="price" style="margin-top:32px;">
                                                    $10.00
                                                </div>
                                            </div>
                                            <div class="col edit">
                                                <button @click="productEditBtn(item.cit_key)" class="btn-edit unable"><img src="/assets/images/icon/down.png"/></button>
                                                <div class="download_status red">Unavailable</div>
                                            </div>
                                            <div class="col genre">
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                            </div>
                                        </div>
                                    </li>
                                    <li class="playList__itembox">
                                        <div class="playList__item playList__item--title">
                                            <div class="col name">
                                                <figure>
                                                    <span class="playList__cover">
                                                        <!-- <img :src="'/assets/images/cover_default.png'" alt=""> -->
                                                        <img src="'http://dev.beatsomeone.com/uploads/cmallitem/'" alt="">
                                                        <i class="label new">N</i>
                                                    </span>
                                                    <figcaption class="pointer">
                                                        <div class="info">
                                                          <div class="code">item.cit_key</div>
                                                        </div>
                                                        <h3 class="playList__title">formatCitName(item.cit_name)</h3>
                                                        <span class="playList__by">(item.bpm)</span>
                                                    </figcaption>
                                                </figure>
                                            </div>
                                            <div class="col option">
                                                <div>
                                                    <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                    <div>
                                                        <div class="title">UNLIMITED STEMS LICENSE PRICE</div>
                                                        <div class="detail">MP3 or WAV + STEMS</div>
                                                    </div>
                                                </div>
                                                <div class="option_item">
                                                    <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                    <div><img src="/assets/images/icon/parchase-info4.png"><span>No other activities not authorized by the platform</span></div>
                                                </div>
                                            </div>
                                            <div class="col feature">
                                                <div class="listen">
                                                    <div class="playbtn">
                                                        <button class="btn-play">재생</button>
                                                        <span class="timer"><span class="current">0:00 / </span>
                                                        <span class="duration">0:00</span></span>
                                                    </div>
                                                    <div class="col spectrum">
                                                        <div class="wave"></div>
                                                    </div>
                                                </div>
                                                <div class="price" style="margin-top:32px;">
                                                    $10.00
                                                </div>
                                            </div>
                                            <div class="col edit">
                                                <button @click="productEditBtn(item.cit_key)" class="btn-edit unable"><img src="/assets/images/icon/down.png"/></button>
                                                <div class="download_status gray">Expired</div>
                                                <div class="download_period gray">40 days left<br/>(~2020.06.24 12:30:34)</div>
                                            </div>
                                            <div class="col genre">
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                                <span><button >music tech03</button></span>
                                            </div>
                                        </div>
                                    </li>
                                </ul>
                            </div>

                        </div>

                        <div class="row">
                            <div class="title-content">
                                <p>
                                    ※- Beat download is not available when the deposit is in a waiting state.<br/>
                                    ※- Beat download is available for 60 days after payment is completed.
                                </p>
                            </div>
                        </div>

                        <div class="row">
                            <div class="payment_box" style="padding-top:0; margin-top:0; border:0;">
                                <div class="tab">
                                    <div>
                                        <div class="title">Method</div>
                                        <div>Wire Transfer</div>
                                    </div>
                                    <div>
                                        <div class="title">Detail</div>
                                        <div>Woori Bank (123-456-7890)</div>
                                    </div>
                                    <div>
                                        <div class="title">Subtotal</div>
                                        <div>$ 30.00</div>
                                    </div>
                                    <div>
                                        <div class="title">Points</div>
                                        <div>300 P</div>
                                    </div>
                                    <div class="total">
                                        <div>Total</div>
                                        <div>$ 27.00</div>
                                    </div>                           
                                </div>
                            </div>
                            <p class="desc">
                                <img src="/assets/images/icon/info_blue.png">If you are in a deposit waiting state or wish to cancel, please request a change through a <a href="/mypage/inquiry/">Support Case</a> menu.
                            </p>
                        </div>

                        <div class="btnbox col" style="width:50%; margin:0 auto 100px;">
                            <button class="btn btn--gray">Back to List</button>
                            <button type="submit" class="btn btn--submit">Request Refund</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!--
        <div id="waveform" ></div>
        <main-player></main-player>
        -->


        <div class="panel active">
            <div class="popup" style="width:1110px; display:none;">
                <div class="box" style="padding-bottom:50px;">
                    <div class="title">CHANGE PASSWORD</div>
                    <div class="tab">
                        <div>
                            <div class="title">No</div>
                            <div>Order_099</div>
                        </div>
                        <div>
                            <div class="title">Date</div>
                            <div>0000-00-00 00:00:00</div>
                        </div>
                        <div>
                            <div class="title">Status</div>
                            <div class="blue">Order Complete</div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="title-content">
                            <div class="title">
                                <label for="checkAll" class="checkbox" style="margin-left:20px;">
                                    <input type="checkbox" hidden="hidden" id="checkAll" v-model="checkedAll" @change="setCheckAll">
                                    <span></span><div style="font-weight:600">Select All (0/4)</div>
                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="col">
                        <div class="playList productList cart">
                            <ul>
                                <li class="playList__itembox">
                                    <div class="playList__item playList__item--title">
                                        <div class="col check">
                                            <label for="item1" class="checkbox">
                                                <input type="checkbox" hidden="hidden" id="item1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col name" style="margin-top:0">
                                            <figure>
                                                <span class="playList__cover">
                                                    <img src="/assets/images/cover_default.png" alt="">
                                                    <i ng-if="item.isNew" class="label new">N</i>
                                                </span>
                                                <figcaption class="pointer">
                                                    <h3 class="playList__title"> Mickey (Buy 1 Get 3 Free) </h3>
                                                    <span class="playList__by"> ( Bpm )</span>
                                                </figcaption>
                                            </figure>
                                        </div>
                                        <div class="col option">
                                            <div>
                                                <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                <div>
                                                    <div class="title">BASIC LEASE</div>
                                                    <div class="detail">MP3 or WAV</div>
                                                </div>
                                            </div>
                                            <div class="option_item">
                                                <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                <div><img src="/assets/images/icon/parchase-info5.png"><span>No other activities not authorized by the platform</span></div>
                                            </div>
                                        </div>
                                        <div class="col feature">
                                            <div class="price">
                                                $ 10.00
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="playList__itembox">
                                    <div class="playList__item playList__item--title">
                                        <div class="col check">
                                            <label for="item1" class="checkbox">
                                                <input type="checkbox" hidden="hidden" id="item1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col name" style="margin-top:0">
                                            <figure>
                                                <span class="playList__cover">
                                                    <img src="/assets/images/cover_default.png" alt="">
                                                    <i ng-if="item.isNew" class="label new">N</i>
                                                </span>
                                                <figcaption class="pointer">
                                                    <h3 class="playList__title"> Mickey (Buy 1 Get 3 Free) </h3>
                                                    <span class="playList__by"> ( Bpm )</span>
                                                </figcaption>
                                            </figure>
                                        </div>
                                        <div class="col option">
                                            <div>
                                                <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                <div>
                                                    <div class="title">BASIC LEASE</div>
                                                    <div class="detail">MP3 or WAV</div>
                                                </div>
                                            </div>
                                            <div class="option_item">
                                                <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                <div><img src="/assets/images/icon/parchase-info5.png"><span>No other activities not authorized by the platform</span></div>
                                            </div>
                                        </div>
                                        <div class="col feature">
                                            <div class="price">
                                                $ 10.00
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="playList__itembox">
                                    <div class="playList__item playList__item--title">
                                        <div class="col check">
                                            <label for="item1" class="checkbox">
                                                <input type="checkbox" hidden="hidden" id="item1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col name" style="margin-top:0">
                                            <figure>
                                                <span class="playList__cover">
                                                    <img src="/assets/images/cover_default.png" alt="">
                                                    <i ng-if="item.isNew" class="label new">N</i>
                                                </span>
                                                <figcaption class="pointer">
                                                    <h3 class="playList__title"> Mickey (Buy 1 Get 3 Free) </h3>
                                                    <span class="playList__by"> ( Bpm )</span>
                                                </figcaption>
                                            </figure>
                                        </div>
                                        <div class="col option">
                                            <div>
                                                <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                <div>
                                                    <div class="title">BASIC LEASE</div>
                                                    <div class="detail">MP3 or WAV</div>
                                                </div>
                                            </div>
                                            <div class="option_item">
                                                <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                <div><img src="/assets/images/icon/parchase-info5.png"><span>No other activities not authorized by the platform</span></div>
                                            </div>
                                        </div>
                                        <div class="col feature">
                                            <div class="price">
                                                $ 10.00
                                            </div>
                                        </div>
                                    </div>
                                </li>
                                <li class="playList__itembox">
                                    <div class="playList__item playList__item--title">
                                        <div class="col check">
                                            <label for="item1" class="checkbox">
                                                <input type="checkbox" hidden="hidden" id="item1">
                                                <span></span>
                                            </label>
                                        </div>
                                        <div class="col name" style="margin-top:0">
                                            <figure>
                                                <span class="playList__cover">
                                                    <img src="/assets/images/cover_default.png" alt="">
                                                    <i ng-if="item.isNew" class="label new">N</i>
                                                </span>
                                                <figcaption class="pointer">
                                                    <h3 class="playList__title"> Mickey (Buy 1 Get 3 Free) </h3>
                                                    <span class="playList__by"> ( Bpm )</span>
                                                </figcaption>
                                            </figure>
                                        </div>
                                        <div class="col option">
                                            <div>
                                                <button class="option_fold"><img src="/assets/images/icon/togglefold.png"/></button>
                                                <div>
                                                    <div class="title">BASIC LEASE</div>
                                                    <div class="detail">MP3 or WAV</div>
                                                </div>
                                            </div>
                                            <div class="option_item">
                                                <div><img src="/assets/images/icon/parchase-info1.png"><span>Available for 60 days</span></div>
                                                <div><img src="/assets/images/icon/parchase-info2.png"><span>Unable to edit arbitrarily</span></div>
                                                <div><img src="/assets/images/icon/parchase-info3.png"><span>Rented members cannot be re-rented to others</span></div>
                                                <div><img src="/assets/images/icon/parchase-info5.png"><span>No other activities not authorized by the platform</span></div>
                                            </div>
                                        </div>
                                        <div class="col feature">
                                            <div class="price">
                                                $ 10.00
                                            </div>
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>

                    <div class="tab" style="margin-top:30px; margin-bottom:10px;">
                        <div>
                            <div class="title">Total Refund</div>
                            <div class="yellow" style="font-weight:600">$ 20.00</div>
                        </div>
                        <div>
                            <div class="title">Points to be Refunded</div>
                            <div>
                                <div class="yellow" style="font-weight:600; margin-right:10px;">1500 P</div>
                                <div class="gray">(Used Point <span class="yellow">3,000P</span>)</div>
                            </div>
                        </div>
                    </div>

                    <div class="col" style="margin:0">
                        
                        <div class="title-content" style="margin:0;">
                            <div class="title"></div>
                            <p style="margin:0">
                                - Returned points will be returned / paid depending on the number of products requested for cancellation if there are any points used in ordering.<br/>
                                - In the case of a full cancellation, the return points will be returned as the amount of points used for payment.
                            </p>
                        </div>

                    </div>

                    <div class="btnbox" style="text-align:center;">
                        <button type="submit" class="btn btn--yellow" style="width:208px">Request Fund</button>
                    </div>
                </div>
            </div>

            <div class="popup active" style="width:1110px;">

                <div class="box" style="padding-bottom:50px;">
                    <div class="title" style="margin-bottom:30px;">REQUEST REFUND</div>
                    <div class="row" style="margin-bottom:30px;">
                        <div class="type"></div>
                        <div class="data">
                            <div class="result">
                                <div>
                                    <img src="/assets/images/icon/check-circle.png"/>
                                </div>
                                <div>
                                    <div class="title">Your refund request has been completed.</div>
                                    <div class="desc">Please let us know the reason for the refund and we will process it after confirmation.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="type"><span>Reason *</span></div>
                        <div class="data">
                            <div class="sort" style="display:flex; margin-left:0; flex-flow:row nowrap">
                                <div class="custom-select">
                                    <button class="selected-option" style="min-width: 224px;">Select your reason</button>
                                    <div class="options">
                                        <button data-value="" class="option"> Selecting the wrong beat </button>
                                        <button data-value="" class="option"> No intention to purchase </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        <div class="type"><span>Description *</span></div>
                        <div class="data">
                            <textarea class="firstname" type="text" placeholder="Write your description for refund requesting..."></textarea>
                        </div>
                        <div></div>
                    </div>

                    <div class="btnbox" style="text-align:center;">
                        <button type="submit" class="btn btn--yellow" style="width:208px">Request Complete</button>
                    </div>
                </div>
            </div>

        </div>
        <Footer/>

    </div>

</template>


<script>
    require('@/assets/js/function')
    import Header from "../include/Header"
    import Footer from "../include/Footer"

    import $ from "jquery";
    import { EventBus } from '*/src/eventbus';
    import Velocity from "velocity-animate";
    //import MainPlayer from "@/vue/common/MainPlayer";
    import WaveSurfer from 'wavesurfer.js';

    export default {
        components: {
            Header, Footer
        },
        data: function() {
            return {
                isLogin: false,
                group_title: 'SELLER',
                product_status: 'PENDING',
                popup_filter:0,
                ws: null,
                isPlay: false,
                isReady: false,
                wavesurfer: null,
            };
        },
        mounted(){
                        // 커스텀 셀렉트 옵션
            $(".custom-select").on("click", function() {

                $(this)
                    .siblings(".custom-select")
                    .removeClass("active")
                    .find(".options")
                    .hide();
                $(this).toggleClass("active");
                $(this)
                    .find(".options")
                    .toggle();
            });
        },
        created() {
                Http.get('/beatsomeoneApi/get_user_regist_item_list').then(r => {
                    console.log(r.data);
                    this.myProduct_list = r.data;
                });
        },
        methods:{
            goPage: function(page){
                window.location.href = '/mypage/'+page;
            },
            calcSeq: function(size, i){
                return parseInt(size) - parseInt(i);
            },
            formatCitName: function(data){
                var rst;
                var limitLth = 50
                if(limitLth < data.length && data.length <= limitLth*2){
                    rst = data.substring(0,limitLth) + '<br>' + data.substring(limitLth,limitLth*2);
                }else if(limitLth < data.length && limitLth*2 < data.length){
                    rst = data.substring(0,limitLth) + '<br>' + data.substring(limitLth,limitLth*2) + '...';
                }else{
                    rst = data
                }
                return rst;
            },
            productEditBtn: function(key){
                console.log("productEditBtn:" +key);
                window.location.href = 'http://dev.beatsomeone.com/beatsomeone/detail/'+key;
            },
            playAudio(i) {
                this.wavesurfer = WaveSurfer.create({
                    container: document.querySelector('#waveform'),
                });
                // https://nachwon.github.io/waveform/
                this.wavesurfer.load('http://dev.beatsomeone.com/uploads/cmallitemdetail/2020/04/cb40bdf9165462c6351ebd82abedb1d6.mp3');
                this.wavesurfer.on('ready', this.start);
            },
            start(){
                this.wavesurfer.play();
            },
        }
    }
</script>


<style lang="scss">
    @import '@/assets/scss/App.scss';
</style>

<style scoped="scoped" lang="css">
    @import '/assets/plugins/slick/slick.css';
    @import '/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css';
</style>