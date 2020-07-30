<template>
  <div class="modal" id="purchase" v-if="purchaseTypeSelectorPopup" @click.self="close">
    <div class="modal__content">
      <header class="modal__header">
        <h2 class="modal__title">PLEASE SELECT A PURCHASE TYPE</h2>
        <button class="modal__close" @click="close">닫기</button>
      </header>
      <div class="modal__body">
        <div class="album">
          <div class="album__thumb">
            <img :src="albumThumb" alt />
          </div>
          <h3>{{ item.cit_name }}</h3>
          <p>{{ item.musician }}</p>
        </div>
        <div class="purchase-list">
          <ul>
            <li
              class="parchase-item"
              v-if="item.cit_lease_license_use && !!item.detail && !!item.detail.LEASE && !!item.detail.LEASE.cde_id"
            >
              <div class="parchase-info">
                <div class="parchase-headern">
                  <div>
                    <h4 class="parchase-title">BASIC LEASE</h4>
                    <p class="parchase-desc">
                      {{$t('mp3Orwav')}}
                      <span class="copytransfer">+ Include Copyright Transfer</span>
                    </p>
                  </div>

                  <div class="parchase-btnbox">
                    <a class="buy waves-effect" @click="addCart(item.detail.LEASE.cde_id)">
                      <span>{{ formatPrice(item.detail.LEASE.cde_price, item.detail.LEASE.cde_price_d, true) }}</span>
                    </a>
                  </div>
                </div>
                <div class="parchase-description" :ref="'purchaseDesc' + item.detail.LEASE.cde_id">
                  <p>
                    <i>
                      <img src="/assets/images/icon/parchase-info6.png" alt />
                    </i>
                    <!-- {{$t('available60Days')}} -->
                    Profits from performances and can be used in broadcasting
                  </p>
                  <p></p>
                  <p>
                    <i>
                      <img src="/assets/images/icon/parchase-info1.png" alt />
                    </i>
                    <!-- {{$t('available60Days')}} -->
                    Available for 60 days
                  </p>
                  <p>
                    <i>
                      <img src="/assets/images/icon/parchasev-info3.png" alt />
                    </i>
                    <!-- {{$t('rentedMembersCannotBeRerentedToOthers')}} -->
                    Unable to register commercial music copyrights
                  </p>
                  <p>
                    <i>
                      <img src="/assets/images/icon/parchase-info2.png" alt />
                    </i>
                    <!-- {{$t('unableToEditArbitrarily')}} -->
                    Only simple cutting editing is possible
                  </p>
                  <p>
                    <i>
                      <img src="/assets/images/icon/parchase-info7.png" alt />
                    </i>
                    <!-- {{$t('noOtherActivitiesNotAuthorizedByThePlatform')}} -->
                    Will continue to be sold to the majority other than this buyer
                  </p>
                  <div class="copybox">
                    <span>Seller's copyright must also be partially recognized when registering music copyrights.</span>
                    <span>If you wish to transfer copyrights, you need to contact the customer center.</span>
                  </div>
                </div>
                <div class="parchase-dropdown" @click="openDesc(item.detail.LEASE.cde_id)">
                  <button :ref="'purchaseBtn' + item.detail.LEASE.cde_id">정보열람</button>
                  <span>Detailed condition</span>
                </div>
              </div>
            </li>
            <li
              class="parchase-item"
              v-if="item.cit_mastering_license_use && !!item.detail && !!item.detail.STEM && !!item.detail.STEM.cde_id"
            >
              <div class="parchase-info">
                <h4 class="parchase-title">MASTERING LICENSE</h4>
                <p class="parchase-desc">
                  {{$t('mp3OrwavStems')}}
                  <span class="copytransfer">+ Include Copyright Transfer</span>
                </p>
                <div class="parchase-description" :ref="'purchaseDesc' + item.detail.STEM.cde_id">
                  <p>
                    <i>
                      <img src="/assets/images/icon/parchase-info6.png" alt />
                    </i>
                    <!-- {{$t('unlimited1')}} -->
                    Profits from performances and can be used in broadcasting
                  </p>
                  <p>
                    <i>
                      <img src="/assets/images/icon/parchase-info8.png" />
                    </i>
                    <!-- {{$t('unlimitedMsg1')}} -->
                    Registration of commercial music copyrights is possible
                  </p>
                  <p>
                    <i>
                      <img src="/assets/images/icon/parchase-info9.png" />
                    </i>
                    <!-- {{$t('unlimitedMsg2')}} -->
                    All editing rights can be obtained
                  </p>
                  <p>
                    <i>
                      <img src="/assets/images/icon/parchase-info4.png" />
                    </i>
                    <!-- {{$t('unlimitedMsg2')}} -->
                    No restrictions on all other commercial uses
                  </p>
                  <p>
                    <i>
                      <img src="/assets/images/icon/parchase-info10.png" />
                    </i>
                    <!-- {{$t('unlimitedMsg2')}} -->
                    Sold exclusively to only one purchaser (share of ownership)
                  </p>

                  <div class="copybox">
                    <span>Seller's copyright must also be partially recognized when registering music copyrights.</span>
                    <span>If you wish to transfer copyrights, you need to contact the customer center.</span>
                  </div>
                </div>
                <div class="parchase-dropdown" @click="openDesc(item.detail.STEM.cde_id)">
                  <button :ref="'purchaseBtn' + item.detail.STEM.cde_id">정보열람</button>
                  <span>Detailed condition</span>
                </div>
              </div>
              <div>
                <a class="buy waves-effect" @click="addCart(item.detail.STEM.cde_id)">
                  <span>{{ formatPrice(item.detail.STEM.cde_price, item.detail.STEM.cde_price_d, true) }}</span>
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { EventBus } from "*/src/eventbus";
import $ from "jquery";

export default {
  props: ["purchaseTypeSelectorPopup", "item"],
  data: function () {
    return {};
  },
  mounted() {},
  watch: {
    item: function (n) {
      console.log(n);
    },
  },
  computed: {
    albumThumb() {
      return !this.item.cit_file_1
        ? "/assets/images/no_190x190.png"
        : "/uploads/cmallitem/" + this.item.cit_file_1;
    },
  },
  methods: {
    openDesc(id) {
      this.$refs["purchaseBtn" + id].classList.toggle("active");
      this.$refs["purchaseDesc" + id].style.display =
        this.$refs["purchaseDesc" + id].style.display === "block"
          ? "none"
          : "block";
    },
    addCart(cde_id) {
      let detail_qty = {};
      detail_qty[cde_id] = 1;
      Http.post(`/beatsomeoneApi/itemAction`, {
        stype: "cart",
        cit_id: this.item.cit_id,
        chk_detail: [cde_id],
        detail_qty: detail_qty,
      }).then((r) => {
        if (!r) {
          log.debug("장바구니 담기 실패");
        } else {
          log.debug("장바구니 담기 성공");
          alert(this.$t("inMyShoppingCart"));
          this.close();
        }
      });
    },
    close() {
      this.$emit("update:purchaseTypeSelectorPopup", false);
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
  },
};
</script>

<style lang="css">
@import "/assets/plugins/slick/slick.css";
@import "/assets/plugins/rangeSlider/css/ion.rangeSlider.min.css";

/* width */
.purchase-list::-webkit-scrollbar {
  width: 5px;
}

/* Track */
.purchase-list::-webkit-scrollbar-track {
  background: none;
}

/* Handle */
.purchase-list::-webkit-scrollbar-thumb {
  background: #414349;
}

/* Handle on hover */
.purchase-list::-webkit-scrollbar-thumb:hover {
  background: #414349;
}

.parchase-dropdown {
  display: flex;
  align-items: center;
}
.parchase-dropdown span {
  color: #fff;
  font-size: 13px;
  margin-left: 5px;
  opacity: 0.3;
}
.parchase-dropdown:hover span {
  opacity: 1;
}

/* 추가 해야할 부분 */
.copybox {
  padding-left: 30px;
}
.copybox span {
  display: block;
  font-size: 11px;
  color: #3873d3;
  margin-bottom: 5px;
  display: flex;
  align-items: flex-start;
  line-height: 15px;
}
.copybox span:before {
  content: "*";
  font-size: 11px;
  color: #3873d3;
  margin-top: 2px;
  margin-right: 3px;
}
.copytransfer {
  font-size: 13px;
  color: #3873d3;
}
/* 추가 해야할 부분 끝 */

.parchase-headern {
  display: flex;
  align-items: flex-start;
  justify-content: space-between;
}
.parchase-headern div {
  flex: 1;
}
.parchase-btnbox {
  margin-left: auto;
  padding-left: 10px;
  flex: 0 !important;
}
#purchase .modal__content .modal__body .parchase-item .parchase-description p {
  margin-bottom: 5px !important;
}
</style>
