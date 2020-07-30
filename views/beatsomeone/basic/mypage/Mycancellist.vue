<template>
  <div>
    <div class="row" style="margin-bottom:20px;">
      <div class="main__media board inquirylist">
        <div class="tab" style="height:64px;">
          <div @click="goRoute('mybilling')">{{$t('orderHistory')}} (123)</div>
          <div class="active">Cancellation / Refund History(32)</div>
        </div>
      </div>
    </div>
    <div class="row" style="display:flex; margin-bottom:10px;">
      <div class="search condition">
        <div class="filter">
          <div
            class="condition"
            :class="{ 'active': search_condition_active_idx === 1 }"
            @click="setSearchCondition(1)"
          >All</div>
          <div
            class="condition"
            :class="{ 'active': search_condition_active_idx === 2 }"
            @click="setSearchCondition(2)"
          >3 months</div>
          <div
            class="condition"
            :class="{ 'active': search_condition_active_idx === 3 }"
            @click="setSearchCondition(3)"
          >6 months</div>
          <div
            class="condition"
            :class="{ 'active': search_condition_active_idx === 3 }"
            @click="setSearchCondition(3)"
          >1 year</div>
        </div>
      </div>
      <div style="margin-left:auto; ">
        <div>
          <div class="sort datepicker" style="max-width: initial; margin-top:10px;">
            <input type="date" :placeholder="$t('startDate')" />
            <span>─</span>
            <input type="date" :placeholder="$t('endDate')" />
            <button>
              <img src="/assets/images/icon/calendar-white.png" />
            </button>
          </div>
        </div>
      </div>
    </div>

    <div class="row" style="display:flex; margin-bottom:30px;">
      <div class="tabmenu"></div>
      <div class="sort" style="text-align:right">
        <div class="custom-select" style="min-width:max-content;">
          <button class="selected-option">Recent</button>
          <div class="options">
            <button data-value class="option">Past</button>
          </div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-bottom:20px;">
      <div class="main__media board mybillinglist">
        <div class="tab nowrap">
          <div class="index">No</div>
          <div class="date">Date</div>
          <div class="product">Product</div>
          <div class="totalprice">Total price</div>
          <div class="status">Status</div>
        </div>
      </div>
    </div>

    <div class="row" style="margin-bottom:30px;">
      <div class="playList board mybillinglist">
        <ul>
          <li class="playList__itembox" @click="goRoute('mycancelView')">
            <div class="playList__item playList__item--title nowrap active">
              <div class="index">Order_010</div>
              <div class="date">0000-00-00 00:00:00</div>
              <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
              <div class="totalprice">$ 10.00</div>
              <div class="status">
                <div class="red">Refund Complete</div>
              </div>
            </div>
          </li>
          <li class="playList__itembox" @click="goRoute('mycancelView')">
            <div class="playList__item playList__item--title nowrap active">
              <div class="index">Order_010</div>
              <div class="date">0000-00-00 00:00:00</div>
              <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
              <div class="totalprice">$ 10.00</div>
              <div class="status">
                <div class="red">Refund Complete</div>
              </div>
            </div>
          </li>
          <li class="playList__itembox" @click="goRoute('mycancelView')">
            <div class="playList__item playList__item--title nowrap active">
              <div class="index">Order_010</div>
              <div class="date">0000-00-00 00:00:00</div>
              <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
              <div class="totalprice">$ 10.00</div>
              <div class="status">
                <div class="red">Refund Complete</div>
              </div>
            </div>
          </li>
          <li class="playList__itembox" @click="goRoute('mycancelView')">
            <div class="playList__item playList__item--title nowrap active">
              <div class="index">Order_010</div>
              <div class="date">0000-00-00 00:00:00</div>
              <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
              <div class="totalprice">$ 10.00</div>
              <div class="status">
                <div class="red">Refund Complete</div>
              </div>
            </div>
          </li>
          <li class="playList__itembox" @click="goRoute('mycancelView')">
            <div class="playList__item playList__item--title nowrap active">
              <div class="index">Order_010</div>
              <div class="date">0000-00-00 00:00:00</div>
              <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
              <div class="totalprice">$ 10.00</div>
              <div class="status">
                <div class="red">Refund Complete</div>
              </div>
            </div>
          </li>
          <li class="playList__itembox" @click="goRoute('mycancelView')">
            <div class="playList__item playList__item--title nowrap active">
              <div class="index">Order_010</div>
              <div class="date">0000-00-00 00:00:00</div>
              <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
              <div class="totalprice">$ 10.00</div>
              <div class="status">
                <div class="red">Refund Complete</div>
              </div>
            </div>
          </li>
          <li class="playList__itembox" @click="goRoute('mycancelView')">
            <div class="playList__item playList__item--title nowrap active">
              <div class="index">Order_010</div>
              <div class="date">0000-00-00 00:00:00</div>
              <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
              <div class="totalprice">$ 10.00</div>
              <div class="status">
                <div class="red">Refund Complete</div>
              </div>
            </div>
          </li>
          <li class="playList__itembox" @click="goRoute('mycancelView')">
            <div class="playList__item playList__item--title nowrap active">
              <div class="index">Order_010</div>
              <div class="date">0000-00-00 00:00:00</div>
              <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
              <div class="totalprice">$ 10.00</div>
              <div class="status">
                <div class="red">Refund Complete</div>
              </div>
            </div>
          </li>
          <li class="playList__itembox" @click="goRoute('mycancelView')">
            <div class="playList__item playList__item--title nowrap active">
              <div class="index">Order_010</div>
              <div class="date">0000-00-00 00:00:00</div>
              <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
              <div class="totalprice">$ 10.00</div>
              <div class="status">
                <div class="red">Refund Complete</div>
              </div>
            </div>
          </li>
          <li class="playList__itembox" @click="goRoute('mycancelView')">
            <div class="playList__item playList__item--title nowrap active">
              <div class="index">Order_010</div>
              <div class="date">0000-00-00 00:00:00</div>
              <div class="subject">The Flow Buy 1 Get 3 Free and 2 more</div>
              <div class="totalprice">$ 10.00</div>
              <div class="status">
                <div class="red">Refund Complete</div>
              </div>
            </div>
          </li>
        </ul>
      </div>
    </div>

    <div class="row" style="margin-bottom:30px;">
      <div class="pagination">
        <div>
          <button class="prev active">
            <img src="/assets/images/icon/chevron_prev.png" />
          </button>
          <button class="active">1</button>
          <button>2</button>
          <button>3</button>
          <button>4</button>
          <button>5</button>
          <button>6</button>
          <button>7</button>
          <button>8</button>
          <button>9</button>
          <button>10</button>
          <button class="next active">
            <img src="/assets/images/icon/chevron_next.png" />
          </button>
        </div>
      </div>
    </div>
  </div>
</template>


<script>
import $ from "jquery";

export default {
  components: {},
  data: function () {
    return {
      isLogin: false,
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
      $(this).toggleClass("active");
      $(this).find(".options").toggle();
    });
  },
  created() {},
  methods: {
    goRoute: function (page) {
      this.$router.push({ path: "/" + page });
    },
  },
};
</script>

<style scoped="scoped" lang="css">
@import "/assets/plugins/slick/slick.css";
@import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";
</style>