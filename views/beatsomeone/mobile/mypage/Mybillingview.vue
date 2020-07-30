<template>
  <div style="margin-bottom:100px;">
    <div class="row" style="margin-bottom:30px;">
      <div class="title-content">
        <h4 class="title">{{$t('orderDetail')}}</h4>
        <div class="n-box">
          <div class="n-flex">
            <span>{{$t('orderNumber')}}</span>
            <span class="index">{{ no }}</span>
          </div>
          <div class="n-flex">
            <span>{{$t('date')}}</span>
            <span class="date">{{ cor_datetime }}</span>
          </div>
          <div class="n-flex">
            <span>{{$t('status')}}</span>
            <span
              :class="{ 'green': cor_status === '0', 'blue': cor_status === '1', 'red': cor_status === '2' }"
            >{{ $t(funcStatus(cor_status)) }}</span>
          </div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-bottom:10px;">
      <div class="title-content">
        <h4 class="title">
          <span class="yellow">{{ myOrderList.length }}</span>
          {{$t('orderedItems')}}
        </h4>
      </div>

      <div class="playList productList orderlist" style="margin-top:10px;">
        <ul>
          <li
            v-for="(item, i) in myOrderList"
            v-bind:key="item.order.cor_id + item.order.cit_id"
            class="playList__itembox"
            :id="'playList__item'+ item.order.cor_id + item.order.cit_id"
          >
            <div class="playList__item playList__item--title other">
              <div class="n-flex between">
                <div class="info">
                  <div class="code">{{ item.order.Item.cit_key }}</div>
                </div>
                <div class="edit">
                  <div
                    class="download_status"
                    :class="getDownStatusColor(cor_status, item.order.Item)"
                  >{{ $t(funcDownStatus(cor_status, item.order.Item)) }}</div>
                  <!--
                                    <div v-if="cor_status === '1' " class="download_period">
                                        <span> {{ caclLeftDay(item.order.cor_approve_datetime) }} {{$t('daysLeft')}} <br/> (~ {{ caclTargetDay(item.order.cor_approve_datetime) }}) </span>
                                    </div>
                                    <div v-else-if="cor_status === '0' " class="download_period"> <span>  </span> </div>
                                    <div v-else class="download_period"> <span class="gray"> (~ {{ caclTargetDay(item.order.cor_approve_datetime) }}) </span> </div>
                  -->

                  <!-- <div class="download_period">40 {{$t('daysLeft')}}<br/>(~2020.06.24 12:30:34)</div> -->
                </div>
                <div
                  class="price"
                  v-show="item.order.Item.cit_lease_license_use === '1' && item.order.Item.cit_mastering_license_use === '1' "
                  style="color: white;"
                >{{ formatPrice(item.order.Item.cde_price, item.order.Item.cde_price_d, true) }}</div>
                <div
                  class="price"
                  v-show="item.order.Item.cit_lease_license_use === '1' && item.order.Item.cit_mastering_license_use === '0' "
                  style="color: white;"
                >{{ formatPrice(item.order.Item.cde_price, item.order.Item.cde_price_d, true) }}</div>
                <div
                  class="price"
                  v-show="item.order.Item.cit_mastering_license_use === '1' && item.order.Item.cit_lease_license_use === '0' "
                  style="color: white;"
                >{{ formatPrice(item.order.Item.cde_price_2, item.order.Item.cde_price_d_2, true) }}</div>
              </div>

              <div class="name">
                <figure class="n-flex" style="margin-right: 0;">
                  <span class="playList__cover">
                    <img
                      v-if="!item.order.Item.cit_file_1"
                      :src="'/assets/images/cover_default.png'"
                      alt
                    />
                    <img v-else :src="'/uploads/cmallitem/' + item.order.Item.cit_file_1" alt />
                    <i v-show="checkToday(item.order.cor_datetime)" class="label new">N</i>
                  </span>
                  <figcaption class="pointer">
                    <h3 class="playList__title" v-html="formatCitName(item.order.Item.cit_name,50)"></h3>
                    <!-- <span class="playList__by">{{ item.order.Item.mem_nickname }}</span>
                    <span class="playList__bpm">{{ getGenre(item.order.Item.genre, item.order.Item.subgenre) }} | {{ item.order.Item.bpm }}BPM</span>-->
                    <div class="n-flex">
                      <div class="listen">
                        <div class="playbtn">
                          <button
                            class="btn-play"
                            @click="playAudio(item.order.Item, $event)"
                            :data-action="'playAction' + item.order.Item.cit_id "
                          >재생</button>
                          <span class="timer">
                            <span data-v-27fa6da0 class="current">0:00 /</span>
                            <span class="duration">0:00</span>
                          </span>
                        </div>
                      </div>
                      <div class="amount">
                        <img src="/assets/images/icon/cd.png" />
                        <div>
                          <span>500</span> left
                        </div>
                      </div>
                    </div>
                  </figcaption>

                  <button
                    v-if="cor_status === '1' && caclLeftDay(item.order.cor_approve_datetime) > 0"
                    @click="downloadWithAxios(item.order.Item.cde_filename, cor_status, item.order.Item)"
                    class="btn-edit"
                  >
                    <img src="/assets/images/icon/down.png" />
                  </button>
                  <button
                    v-else-if="cor_status === '1' && item.order.Item.cit_lease_license_use === '1' && item.order.Item.cit_mastering_license_use === '1' "
                    class="btn-edit unable"
                  >
                    <img src="/assets/images/icon/down.png" />
                  </button>
                  <button
                    v-else-if="cor_status === '1' && item.order.Item.cit_mastering_license_use === '1' "
                    @click="downloadWithAxios(item.order.Item.cde_filename_2, cor_status, item.order.Item)"
                    class="btn-edit"
                  >
                    <img src="/assets/images/icon/down.png" />
                  </button>
                  <button v-else class="btn-edit unable">
                    <img src="/assets/images/icon/down.png" />
                  </button>
                </figure>
              </div>
              <div class="col n-option">
                <div class="feature">
                  <!--
                                    <div class="amount">
                                        <img src="/assets/images/icon/cd.png"/><div><span>{{ item.cde_quantity }}</span> left</div>
                  </div>-->
                </div>

                <!-- Option -->
                <div class="option">
                  <!-- BASIC LEASE LICENSE -->
                  <!-- UNLIMITED STEMS LICENSE -->
                  <div
                    class="n-box"
                    v-if="item.order.Item.cit_lease_license_use === '1' && item.order.Item.cit_mastering_license_use === '1' "
                  >
                    <div>
                      <button class="playList__item--button">
                        <span class="option_fold">
                          <img src="/assets/images/icon/togglefold.png" @click.self="toggleButton" />
                        </span>
                        <div>
                          <div class="title" @click.self="toggleButton">{{$t('basicLeaseLicense')}}</div>
                          <div class="detail">{{$t('mp3Orwav')}}</div>
                        </div>
                        <!-- <div class="price" style="color: white;">{{ formatPrice(item.order.Item.cde_price, item.order.Item.cde_price_d, true) }}</div> -->
                      </button>
                      <ParchaseComponent></ParchaseComponent>
                    </div>
                  </div>
                  <!-- BASIC LEASE LICENSE -->
                  <!-- UNLIMITED STEMS LICENSE -->
                  <!--
                                    <div class="n-box" v-if="item.order.Item.cit_lease_license_use === '1' && item.order.Item.cit_mastering_license_use === '1' ">
                                         {{$t('unlimitedStemsLicense')}}
                                        <div>
                                            <button class="playList__item--button" >
                                                <span class="option_fold"><img src="/assets/images/icon/togglefold.png" @click.self="toggleButton"/></span>
                                                <div>
                                                    <div class="title" @click.self="toggleButton">{{$t('unlimitedStemsLicense')}}</div>
                                                    <div class="detail">{{$t('mp3OrwavStems')}}</div>
                                                </div>
                                                <div class="price" style="color: white;">{{ formatPrice(item.order.Item.cde_price_2, item.order.Item.cde_price_d_2, true) }}</div>
                                            </button>
                                            <div class="option_item unlimited" style="margin-left: 38px;">
                                                <div> <span class="img-box"><img src="/assets/images/icon/parchase-info4.png"></span><span>{{$t('unlimited1')}}</span></div>
                                                <div> <span class="img-box"><img src="/assets/images/icon/parchase-info4.png"></span> <span> {{$t('unlimitedMsg1')}} </span> </div>
                                                <div> <span class="img-box"><img src="/assets/images/icon/parchase-info4.png"></span> <span> {{$t('unlimitedMsg2')}} </span> </div>
                                            </div>
                                        </div>

                  </div>-->
                  <!-- BASIC LEASE LICENSE -->
                  <div
                    class="n-box"
                    v-else-if="item.order.Item.cit_lease_license_use === '1' && item.order.Item.cit_mastering_license_use === '0'  "
                  >
                    <div>
                      <button class="playList__item--button">
                        <span class="option_fold">
                          <img src="/assets/images/icon/togglefold.png" @click.self="toggleButton" />
                        </span>
                        <div>
                          <div class="title" @click.self="toggleButton">{{$t('basicLeaseLicense')}}</div>
                          <div class="detail">{{$t('mp3Orwav')}}</div>
                        </div>
                        <!-- <div class="price" style="color: white;">{{ formatPrice(item.order.Item.cde_price, item.order.Item.cde_price_d, true) }}</div> -->
                      </button>
                      <ParchaseComponent></ParchaseComponent>
                    </div>
                  </div>

                  <!-- UNLIMITED STEMS LICENSE -->
                  <div
                    class="n-box"
                    v-else-if="item.order.Item.cit_mastering_license_use === '1' && item.order.Item.cit_lease_license_use === '0' "
                  >
                    <div>
                      <button class="playList__item--button">
                        <span class="option_fold">
                          <img src="/assets/images/icon/togglefold.png" @click.self="toggleButton" />
                        </span>
                        <div>
                          <div
                            class="title"
                            @click.self="toggleButton"
                          >{{$t('unlimitedStemsLicense')}}</div>
                          <div class="detail">{{$t('mp3OrwavStems')}}</div>
                        </div>
                        <!-- <div class="price" style="color: white;">{{ formatPrice(item.order.Item.cde_price_2, item.order.Item.cde_price_d_2, true) }} </div> -->
                      </button>
                      <div class="option_item unlimited" style="margin-left: 38px;">
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info4.png" />
                          </span>
                          <span>{{$t('unlimited1')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info4.png" />
                          </span>
                          <span>{{$t('unlimitedMsg1')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info4.png" />
                          </span>
                          <span>{{$t('unlimitedMsg2')}}</span>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="col genre" v-html="calcTag(item.order.Item.hashTag)"></div>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div class="row">
      <div class="title-content text-info">
        <p>{{$t('downloadNotAvailableWhenDepositMsg')}}</p>
        <p>{{$t('downloadAvailable60Msg')}}</p>
      </div>
    </div>

    <div class="row">
      <div class="payment_box">
        <div class="n-box">
          <div class="n-flex between">
            <span class="title">{{$t('payMethod1')}}</span>
            <span>{{ payType }}</span>
          </div>
          <div class="n-flex between">
            <span class="title">{{$t('payMethodDetail')}}</span>
            <span>{{ cor_pg }}</span>
          </div>
          <div class="n-flex between">
            <span class="title">{{$t('paySubtotal')}}</span>
            <span>{{ totalPrice }}</span>
          </div>
          <div class="n-flex between">
            <span class="title">{{$t('usePoints')}}</span>
            <span>0 P</span>
          </div>
          <div class="n-flex between total">
            <span>{{$t('payTotal')}}</span>
            <span>{{ totalPrice }}</span>
          </div>
        </div>
      </div>
      <p class="desc">
        <img src="/assets/images/icon/info_blue.png" />
        <span v-html="descNoti"></span>
      </p>
    </div>

    <div class="n-flex n-btnbox">
      <button class="btn btn--gray" @click="goPage('mybilling')">{{$t('backToList')}}</button>
      <button v-if="cor_status==='1'" type="submit" class="btn btn--submit">{{$t('requestRefund')}}</button>
    </div>

    <div class="panel" :class="{ 'active': reqref === 1 }" style="display: none;">
      <div class="popup" style="width:1110px; display:none;">
        <div class="box" style="padding-bottom:50px;">
          <div class="title">CHANGE PASSWORD</div>
          <div class="tab">
            <div>
              <div class="title">{{$t('no')}}</div>
              <div>Order_099</div>
            </div>
            <div>
              <div class="title">{{$t('date')}}</div>
              <div>0000-00-00 00:00:00</div>
            </div>
            <div>
              <div class="title">{{$t('status')}}</div>
              <div class="blue">{{$t('orderComplete')}}</div>
            </div>
          </div>
          <div class="col">
            <div class="title-content">
              <div class="title">
                <label for="checkAll" class="checkbox" style="margin-left:20px;">
                  <input
                    type="checkbox"
                    hidden="hidden"
                    id="checkAll"
                    v-model="checkedAll"
                    @change="setCheckAll"
                  />
                  <span></span>
                  <div style="font-weight:600">{{$t('selectAll')}} (0/4)</div>
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
                        <input type="checkbox" hidden="hidden" id="item1" />
                        <span></span>
                      </label>
                    </div>
                    <div class="col name" style="margin-top:0">
                      <figure>
                        <span class="playList__cover">
                          <img src="/assets/images/cover_default.png" alt />
                          <i ng-if="item.isNew" class="label new">N</i>
                        </span>
                        <figcaption class="pointer">
                          <h3 class="playList__title">Mickey (Buy 1 Get 3 Free)</h3>
                          <span class="playList__by">( Bpm )</span>
                        </figcaption>
                      </figure>
                    </div>
                    <div class="col option">
                      <div>
                        <button class="option_fold">
                          <img src="/assets/images/icon/togglefold.png" />
                        </button>
                        <div>
                          <div class="title">BASIC LEASE</div>
                          <div class="detail">{{$t('mp3Orwav')}}</div>
                        </div>
                      </div>
                      <div class="option_item">
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info1.png" />
                          </span>
                          <span>{{$t('available60Days')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info2.png" />
                          </span>
                          <span>{{$t('unableToEditArbitrarily')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info3.png" />
                          </span>
                          <span>{{$t('rentedMembersCannotBeRerentedToOthers')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info5.png" />
                          </span>
                          <span>{{$t('noOtherActivitiesNotAuthorizedByThePlatform')}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col feature">
                      <div class="price">$ 10.00</div>
                    </div>
                  </div>
                </li>
                <li class="playList__itembox">
                  <div class="playList__item playList__item--title">
                    <div class="col check">
                      <label for="item1" class="checkbox">
                        <input type="checkbox" hidden="hidden" id="item1" />
                        <span></span>
                      </label>
                    </div>
                    <div class="col name" style="margin-top:0">
                      <figure>
                        <span class="playList__cover">
                          <img src="/assets/images/cover_default.png" alt />
                          <i ng-if="item.isNew" class="label new">N</i>
                        </span>
                        <figcaption class="pointer">
                          <h3 class="playList__title">Mickey (Buy 1 Get 3 Free)</h3>
                          <span class="playList__by">( Bpm )</span>
                        </figcaption>
                      </figure>
                    </div>
                    <div class="col option">
                      <div>
                        <button class="option_fold">
                          <img src="/assets/images/icon/togglefold.png" />
                        </button>
                        <div>
                          <div class="title">BASIC LEASE</div>
                          <div class="detail">{{$t('mp3Orwav')}}</div>
                        </div>
                      </div>
                      <div class="option_item">
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info1.png" />
                          </span>
                          <span>{{$t('available60Days')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info2.png" />
                          </span>
                          <span>{{$t('unableToEditArbitrarily')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info3.png" />
                          </span>
                          <span>{{$t('rentedMembersCannotBeRerentedToOthers')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info5.png" />
                          </span>
                          <span>{{$t('noOtherActivitiesNotAuthorizedByThePlatform')}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col feature">
                      <div class="price">$ 10.00</div>
                    </div>
                  </div>
                </li>
                <li class="playList__itembox">
                  <div class="playList__item playList__item--title">
                    <div class="col check">
                      <label for="item1" class="checkbox">
                        <input type="checkbox" hidden="hidden" id="item1" />
                        <span></span>
                      </label>
                    </div>
                    <div class="col name" style="margin-top:0">
                      <figure>
                        <span class="playList__cover">
                          <img src="/assets/images/cover_default.png" alt />
                          <i ng-if="item.isNew" class="label new">N</i>
                        </span>
                        <figcaption class="pointer">
                          <h3 class="playList__title">Mickey (Buy 1 Get 3 Free)</h3>
                          <span class="playList__by">( Bpm )</span>
                        </figcaption>
                      </figure>
                    </div>
                    <div class="col option">
                      <div>
                        <button class="option_fold">
                          <img src="/assets/images/icon/togglefold.png" />
                        </button>
                        <div>
                          <div class="title">BASIC LEASE</div>
                          <div class="detail">{{$t('mp3Orwav')}}</div>
                        </div>
                      </div>
                      <div class="option_item">
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info1.png" />
                          </span>
                          <span>{{$t('available60Days')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info2.png" />
                          </span>
                          <span>{{$t('unableToEditArbitrarily')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info3.png" />
                          </span>
                          <span>{{$t('rentedMembersCannotBeRerentedToOthers')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info5.png" />
                          </span>
                          <span>{{$t('noOtherActivitiesNotAuthorizedByThePlatform')}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col feature">
                      <div class="price">$ 10.00</div>
                    </div>
                  </div>
                </li>
                <li class="playList__itembox">
                  <div class="playList__item playList__item--title">
                    <div class="col check">
                      <label for="item1" class="checkbox">
                        <input type="checkbox" hidden="hidden" id="item1" />
                        <span></span>
                      </label>
                    </div>
                    <div class="col name" style="margin-top:0">
                      <figure>
                        <span class="playList__cover">
                          <img src="/assets/images/cover_default.png" alt />
                          <i ng-if="item.isNew" class="label new">N</i>
                        </span>
                        <figcaption class="pointer">
                          <h3 class="playList__title">Mickey (Buy 1 Get 3 Free)</h3>
                          <span class="playList__by">( Bpm )</span>
                        </figcaption>
                      </figure>
                    </div>
                    <div class="col option">
                      <div>
                        <button class="option_fold">
                          <img src="/assets/images/icon/togglefold.png" />
                        </button>
                        <div>
                          <div class="title">BASIC LEASE</div>
                          <div class="detail">{{$t('mp3Orwav')}}</div>
                        </div>
                      </div>
                      <div class="option_item">
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info1.png" />
                          </span>
                          <span>{{$t('available60Days')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info2.png" />
                          </span>
                          <span>{{$t('unableToEditArbitrarily')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info3.png" />
                          </span>
                          <span>{{$t('rentedMembersCannotBeRerentedToOthers')}}</span>
                        </div>
                        <div>
                          <span class="img-box">
                            <img src="/assets/images/icon/parchase-info5.png" />
                          </span>
                          <span>{{$t('noOtherActivitiesNotAuthorizedByThePlatform')}}</span>
                        </div>
                      </div>
                    </div>
                    <div class="col feature">
                      <div class="price">$ 10.00</div>
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
                <div class="gray">
                  (Used Point
                  <span class="yellow">3,000P</span>)
                </div>
              </div>
            </div>
          </div>

          <div class="col" style="margin:0">
            <div class="title-content" style="margin:0;">
              <div class="title"></div>
              <p style="margin:0">
                - Returned points will be returned / paid depending on the number of products requested for cancellation if there are any points used in ordering.
                <br />- In the case of a full cancellation, the return points will be returned as the amount of points used for payment.
              </p>
            </div>
          </div>

          <div class="btnbox" style="text-align:center;">
            <button
              type="submit"
              class="btn btn--yellow"
              style="width:208px"
              onclick="reqref = 1"
            >Request Fund</button>
          </div>
        </div>
      </div>

      <div class="popup" :class="{ 'active': reqref === 1 }" style="width:1110px;">
        <div class="box" style="padding-bottom:50px;">
          <div class="title" style="margin-bottom:30px;">{{$t('requestRefund')}}</div>
          <div class="row" style="margin-bottom:30px;">
            <div class="type"></div>
            <div class="data">
              <div class="result">
                <div>
                  <img src="/assets/images/icon/check-circle.png" />
                </div>
                <div>
                  <div class="title">Your refund request has been completed.</div>
                  <div
                    class="desc"
                  >Please let us know the reason for the refund and we will process it after confirmation.</div>
                </div>
              </div>
            </div>
          </div>
          <div class="row">
            <div class="type">
              <span>Reason *</span>
            </div>
            <div class="data">
              <div class="sort" style="display:flex; margin-left:0; flex-flow:row nowrap">
                <div class="custom-select">
                  <button class="selected-option" style="min-width: 224px;">Select your reason</button>
                  <div class="options">
                    <button data-value class="option">Selecting the wrong beat</button>
                    <button data-value class="option">No intention to purchase</button>
                  </div>
                </div>
              </div>
            </div>
          </div>

          <div class="row">
            <div class="type">
              <span>Description *</span>
            </div>
            <div class="data">
              <textarea
                class="firstname"
                type="text"
                placeholder="Write your description for refund requesting..."
              ></textarea>
            </div>
            <div></div>
          </div>

          <div class="btnbox" style="text-align:center;">
            <button
              type="submit"
              class="btn btn--yellow"
              style="width:208px"
              @click="reqref = 0"
            >Request Complete</button>
          </div>
        </div>
      </div>
      <div id="playerContainer" class="hidden"></div>
    </div>
    <main-player></main-player>
  </div>
</template>

<script>
import axios from "axios";
import moment from "moment";
import $ from "jquery";
import MainPlayer from "@/vue/common/MainPlayer";
import { EventBus } from "*/src/eventbus";
import WaveSurfer from "wavesurfer.js";
import ParchaseComponent from "./component/ParchaseComponent";

export default {
  components: {
    MainPlayer,
    ParchaseComponent,
  },
  data: function () {
    return {
      cid: "",
      no: "",
      isLogin: false,
      cor_datetime: "",
      cor_approve_datetime: "",
      cor_status: "",
      cor_pg: "",
      mem_photo: "",
      mem_usertype: "",
      mem_nickname: "",
      mem_address1: "",
      mem_type: "",
      mem_lastname: "",
      myOrderList: [],
      checkedAll: [],
      reqref: 0,
      isPlay: false,
      currentPlayId: null,
      wavesurfer: null,
      payType: "",
      totalPrice: "",
      descNoti: "",
    };
  },
  mounted() {
    // 커스텀 셀렉트 옵션
    $(".custom-select").on("click", function () {
      $(this)
        .siblings(".custom-select")
        .removeClass("active")
        .find(".options")
        .hide();
      if ($(this).hasClass("active")) {
        $(this).addClass("active");
        $(this).find(".options").show();
      } else {
        $(this).removeClass("active");
        $(this).find(".options").hide();
      }
    });
  },
  created() {
    this.getParam();
    this.ajaxOrderList().then(() => {});
  },
  methods: {
    async ajaxOrderList() {
      try {
        this.isLoading = true;
        var param = new FormData();
        param.append("cid", JSON.stringify(this.cid));
        const { data } = await axios.post(
          "/beatsomeoneApi/user_order_Detail",
          param,
          {
            headers: {
              "Content-Type": "multipart/form-data",
            },
          }
        );
        console.log(data);
        this.myOrderList = data.result;

        this.cor_datetime = this.myOrderList[0].order.cor_datetime;
        this.cor_approve_datetime = this.myOrderList[0].order.cor_approve_datetime;
        this.cor_status = this.myOrderList[0].order.cor_status;
        this.payType = this.$t(
          this.formPayType(this.myOrderList[0].order.cor_pay_type)
        );
        this.totalPrice = this.formatTotalPrice(
          this.myOrderList[0].order.cor_total_money,
          this.myOrderList[0].order.cor_memo
        );
        this.cor_pg = this.myOrderList[0].order.cor_pg;
        this.funcDesc();
      } catch (err) {
        console.log("ajaxOrderList error");
      } finally {
        this.isLoading = false;
      }
    },
    getParam: function () {
      let uri = window.location.search.substring(1);
      let params = new URLSearchParams(uri);
      this.cid = params.get("cid");
      this.no = params.get("n");
    },
    formPayType: function (pt) {
      if (pt == 1) {
        return "creditCard";
      } else if (pt == 2) {
        return "realtimeBankTransfer";
      } else {
        return "paypal";
      }
    },
    goPage: function (page) {
      window.location.href = "/mypage/" + page;
    },
    calcSeq: function (size, i) {
      return parseInt(size) - parseInt(i);
    },
    formatCitName: function (data) {
      var rst;
      var limitLth = 50;
      if (limitLth < data.length && data.length <= limitLth * 2) {
        rst =
          data.substring(0, limitLth) +
          "<br>" +
          data.substring(limitLth, limitLth * 2);
      } else if (limitLth < data.length && limitLth * 2 < data.length) {
        rst =
          data.substring(0, limitLth) +
          "<br>" +
          data.substring(limitLth, limitLth * 2) +
          "...";
      } else {
        rst = data;
      }
      return rst;
    },
    funcStatus(s) {
      if (s == "0") {
        return "depositWaiting";
      } else if (s == "1") {
        return "orderComplete";
      } else {
        return "refundComplete";
      }
    },
    setCheckAll: function () {},
    checkToday: function (date) {
      const input = new Date(date);
      const today = new Date();
      return (
        input.getDate() === today.getDate() &&
        input.getMonth() === today.getMonth() &&
        input.getFullYear() === today.getFullYear()
      );
    },
    getGenre(g1, g2) {
      if (this.isEmpty(g2)) {
        return g1;
      } else {
        return g1 + ", " + g2;
      }
    },
    toggleButton: function (e) {
      if (
        e.target.parentElement.parentElement.parentElement.parentElement
          .className == "n-box"
      ) {
        e.target.parentElement.parentElement.parentElement.parentElement.className =
          "n-box active";
      } else if (
        e.target.parentElement.parentElement.parentElement.parentElement
          .className == "n-box active"
      ) {
        e.target.parentElement.parentElement.parentElement.parentElement.className =
          "n-box";
      } else {
        //
      }
    },
    formatCheck: function (o) {
      if (this.isEmpty(o)) {
        return "";
      } else {
        return 0;
      }
    },
    formatTotalPrice: function (price, simbol) {
      if (simbol === "$") {
        return (
          "$ " +
          Number(price).toLocaleString(undefined, { minimumFractionDigits: 2 })
        );
      } else {
        return (
          "₩ " +
          Number(price).toLocaleString("ko-KR", { minimumFractionDigits: 0 })
        );
      }
    },
    formatPrice: function (kr, en, simbol) {
      if (!simbol) {
        if (this.$i18n.locale === "en") {
          return en;
        } else {
          return kr;
        }
      }
      if (this.$i18n.locale === "en") {
        return (
          "$ " +
          Number(en).toLocaleString(undefined, { minimumFractionDigits: 2 })
        );
      } else {
        return (
          "₩ " +
          Number(kr).toLocaleString("ko-KR", { minimumFractionDigits: 0 })
        );
      }
    },
    playAudio(i, e) {
      if (!this.isPlay || this.currentPlayId !== i.cit_id) {
        if (this.currentPlayId !== i.cit_id) {
          this.setAudioInstance(i);
        }
        this.currentPlayId = i.cit_id;
        EventBus.$emit("player_request_start", {
          _uid: this._uid,
          item: i,
          ws: this.wavesurfer,
        });
        e.target.className = "btn-play playing";
        this.start();
      } else {
        EventBus.$emit("player_request_stop", {
          _uid: this._uid,
          item: i,
          ws: this.wavesurfer,
        });
        e.target.className = "btn-play paused";
        this.stop();
      }
    },
    setAudioInstance(item) {
      if (!this.wavesurfer) {
        this.wavesurfer = WaveSurfer.create({
          container: "#playerContainer",
          waveColor: "#696969",
          progressColor: "#c3ac45",
          hideScrollbar: true,
          height: 40,
        });
      }

      if (item.cde_id) {
        this.wavesurfer.load(`/cmallact/download_sample/${item.cde_id}`);
        //this.wavesurfer.load(`/uploads/cmallitemdetail/${item.cde_filename}`);
      }

      this.wavesurfer.on("ready", () => {
        this.wavesurfer.play();
      });
    },
    stop() {
      if (this.wavesurfer) {
        this.wavesurfer.pause();
      }
      this.isPlay = false;
    },
    start(isInit) {
      if (this.wavesurfer) {
        this.wavesurfer.play();
      }
      if (!isInit) {
        this.isPlay = true;
      }
    },
    isEmpty: function (str) {
      if (typeof str == "undefined" || str == null || str == "") return true;
      else return false;
    },
    caclLeftDay: function (orderDate) {
      var tDate = new Date(orderDate);
      var nDate = new Date();
      tDate.setDate(tDate.getDate() + 60);
      var diff = tDate.getTime() - nDate.getTime();
      diff = Math.ceil(diff / (1000 * 3600 * 24));
      return diff;
    },
    caclTargetDay: function (orderDate) {
      var tDate = new Date(orderDate);
      tDate.setDate(tDate.getDate() + 60);
      return moment(tDate).format("YYYY-MM-DD HH:mm:ss");
    },
    productEditBtn: function (key, status) {
      console.log("productEditBtn:" + key);
      if (status == 0) {
        return;
      } else {
        window.location.href = "/mypage/regist_item/" + key;
      }
    },
    removeReg: function (val) {
      const regExp = /[~!@#$%^&*()_+|'"<>?:{}]/;
      while (regExp.test(val)) {
        val = val.replace(regExp, "");
      }
      return val;
    },
    calcTag: function (hashTag) {
      let rst = "";
      let tags = hashTag.split(",");
      for (let i in tags) {
        rst =
          rst +
          "<span><button >" +
          this.removeReg(tags[i]) +
          "</button></span>";
      }
      return rst;
    },
    funcDownStatus: function (status, i) {
      if (status === "0") {
        return "unavailable1";
      } else if (
        status === "1" &&
        this.caclLeftDay(this.cor_approve_datetime) > 0
      ) {
        if (
          i.cit_lease_license_use == "1" &&
          i.cde_quantity <= i.cde_download
        ) {
          return "downloadComplete";
        }
        if (i.cit_lease_license_use == "1" && i.cde_quantity > i.cde_download) {
          return "downloadAvailable";
        }
        if (
          i.cit_mastering_license_use == "0" &&
          i.cit_mastering_license_use == "1"
        ) {
          return "downloadAvailable";
        }
      } else if (
        status === "1" &&
        i.cit_lease_license_use === "1" &&
        i.cit_mastering_license_use === "1"
      ) {
        return "expried";
      } else if (status === "1" && i.cit_mastering_license_use === "1") {
        return "downloadAvailable";
      } else {
        return "expried";
      }
    },
    getDownStatusColor: function (status, i) {
      if (status === "0") {
        return "red";
      } else if (
        status === "1" &&
        this.caclLeftDay(this.cor_approve_datetime) > 0
      ) {
        if (
          i.cit_lease_license_use == "1" &&
          i.cde_quantity <= i.cde_download
        ) {
          return "blue";
        }
        if (i.cit_lease_license_use == "1" && i.cde_quantity > i.cde_download) {
          return "green";
        }
        if (i.cit_mastering_license_use == "1") {
          return "green";
        }
      } else if (
        status === "1" &&
        i.cit_lease_license_use === "1" &&
        i.cit_mastering_license_use === "1"
      ) {
        return "gray";
      } else if (status === "1" && i.cit_mastering_license_use === "1") {
        return "blue";
      } else {
        return "gray";
      }
    },
    funcDesc: function () {
      if (this.cor_status === "0") {
        this.descNoti =
          this.$t("depositWaitingStateSupportCaseMenuMsg") +
          " " +
          '<a href="/mypage/inquiry/">' +
          this.$t("shortcut") +
          "</a>";
      } else if (
        this.cor_status === "1" &&
        this.caclLeftDay(this.cor_approve_datetime) < 0
      ) {
        this.descNoti =
          "If the download period has , the purchased bit cannot be downloaded";
      } else {
        this.descNoti =
          this.$t("depositWaitingStateSupportCaseMenuMsg") +
          " " +
          '<a href="/mypage/inquiry/">' +
          this.$t("shortcut") +
          "</a>";
      }
    },
    forceFileDownload(r, oriname) {
      const blob = new Blob([r.data], { type: "application/mp3" });
      const link = document.createElement("a");
      link.href = URL.createObjectURL(blob);
      link.download = oriname;
      link.click();
      URL.revokeObjectURL(link.href);
    },
    downloadWithAxios: function (cde_filename, status, i) {
      if (
        !(
          this.getDownStatusColor(status, i) == "green" ||
          this.getDownStatusColor(status, i) == "blue"
        )
      ) {
        return;
      }

      let filename = "";
      let oriname = "";
      if (
        i.cit_lease_license_use == "1" &&
        i.cit_mastering_license_use == "1"
      ) {
        filename = i.cde_filename;
        oriname = i.cde_originname;
      } else if (
        i.cit_lease_license_use == "1" &&
        i.cit_mastering_license_use == "0"
      ) {
        filename = i.cde_filename;
        oriname = i.cde_originname;
      } else {
        filename = i.cde_filename_2;
        oriname = i.cde_originname_2;
      }

      axios({
        method: "get",
        //url: '/cmallact/download_sample/'+cde_id,
        url: "/uploads/cmallitemdetail/" + filename,
        responseType: "arraybuffer",
      })
        .then((r) => {
          this.forceFileDownload(r, oriname);
        })
        .catch(() => console.log("error occured"));
    },
  },
};
</script>

<style scoped="scoped" lang="scss">
@import "/assets/plugins/slick/slick.css";
@import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";

.title-content .title {
  font-size: 14px;
  line-height: 16px;
}
</style>