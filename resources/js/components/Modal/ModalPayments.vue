<template>
   <div>
      <div class="modal" tabindex="-1" role="dialog" id="modalPawningPayment">
         <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
               <div class="modal-header">
                  <h5 class="modal-title">Pawned Item</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                     <span aria-hidden="true">&times;</span>
                  </button>
               </div>
               <div class="modal-body">
                  <div class="card">
                     <div class="card-body">
                        <h4 class="text-center">Pawn Agreement Information</h4>
                        <h5
                           class="text-center"
                           style="color: #f57224;"
                        >Bid Amount: ₱ {{ this.pawned_item.pawn_amount }}</h5>
                        <br>
                        <div class="row text-center">
                           <div class="col">
                              <small>Date</small>
                           </div>
                           <div class="col">
                              <small>Total interest</small>
                           </div>
                           <div class="col">
                              <small>Renewal Amount</small>
                           </div>
                           <div class="col">
                              <small>Redemption</small>
                           </div>
                        </div>

                        <div
                           class="row text-center"
                           style="font-size: 14px;"
                           v-for="duration in specials"
                           :key="duration.index"
                        >
                           <div class="col">
                              <b style="color: #f57224;">{{ duration.from }} - {{ duration.to }}</b>
                           </div>
                           <div class="col">
                              <b style="color: #f57224;">{{ duration.interest }}%</b>
                           </div>
                           <div class="col">
                              <b style="color: #f57224;">₱ {{ toFormat(duration.renewal) }}</b>
                           </div>
                           <div class="col">
                              <b style="color: #f57224;">₱ {{ toFormat(duration.redemption) }}</b>
                           </div>
                        </div>
                        <div
                           class="row text-center"
                           style="font-size: 14px;"
                           v-for="month in monthly"
                           :key="month.renewal"
                        >
                           <div class="col">
                              <b style="color: #f57224;">{{ month.month }}</b>
                           </div>
                           <div class="col">
                              <b style="color: #f57224;">{{ month.total_interest }}%</b>
                           </div>
                           <div class="col">
                              <b style="color: #f57224;">₱ {{ toFormat(month.renewal) }}</b>
                           </div>
                           <div class="col">
                              <b style="color: #f57224;">₱ {{ toFormat(month.redemption) }}</b>
                           </div>
                        </div>
                     </div>
                  </div>
                  <br />
                  <!-- <h6>Date now:   {{date_now}}</h6> -->
                  <h6 class="text-center">Date now: {{ date_now }}</h6>
                  <br />
                  <div v-if="current_payment == 0" class="row">
                     <div class="col">
                        <div
                           class="alert alert-danger text-center"
                           role="alert"
                        >Item was over due in last due date, Confiscate?</div>
                        <button
                           class="btn btn-danger btn-block mt-1"
                           @click="confiscate()"
                        >Confiscate</button>
                     </div>
                  </div>

                  <div v-else class="row">
                     <div class="col">
                        <br />

                        <h6 class="text-center">
                           Current Renewal Payment:
                           <b>₱ {{ toFormat(current_renewal) }}</b>
                        </h6>

                        <input
                           disabled
                           type="text"
                           class="form form-control text-center"
                           v-model="current_renewal.toFixed(2)"
                        />
                        <button class="btn btn-primary btn-block mt-1" @click="renew()">Renew</button>
                     </div>- - OR - -
                     <div class="col">
                        <br />
                        <h6 class="text-center">
                           Current Claim Payment:
                           <b>₱ {{ toFormat(current_payment) }}</b>
                        </h6>

                        <input
                           disabled
                           type="text"
                           class="form form-control text-center"
                           v-model="current_payment.toFixed(2)"
                        />
                        <button class="btn btn-primary btn-block mt-1" @click="claim()">Claim</button>
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
   </div>
</template>

<script>
import AuthService from "../../services/auth";
import Swal from "sweetalert2";
export default {
   data() {
      return {
         pawnshop_id: AuthService.methods.getUid(),
         pawned_item: [],
         calculations: [],
         specials: [],
         monthly: [],
         date_now: "",
         current_payment: 0,
         current_interest_rate: 0,
         current_renewal: 0
      };
   },
   // mounted() {
   //    this.getPaymentCalculations();
   // },
   methods: {
      toFormat(num) {
         return Number(parseFloat(num).toFixed(2)).toLocaleString("en", {
            minimumFractionDigits: 2
         });
      },

      async confiscate() {
         let data = {
            pawned_item_id: this.pawned_item.id,
         };

         await axios
            .post("api/zConfiscateItem", data)
            .then(res => {
               console.log(res);
               Swal.fire({
                  title: "Item Confiscate Succesfully",
                  toast: true,
                  timer: 3000,
                  position: "top-right"
               });
              this.$parent.GetPawnedItemsByPawnshop();
               $("#modalPawningPayment").modal("hide");
            })
            .catch(err => {
               console.error(err);
            });
      },

      async renew() {
         let data = {
            item_id: this.pawned_item.item_id,
            pawned_item_id: this.pawned_item.id,
            amount: this.current_renewal
         };

         await axios
            .post("api/sendRenewPayment", data)
            .then(res => {
             this.donwloadPDfRenew(
             res.data.package_id,
             res.data.pawn_amount,
             res.data.date_renew,
             res.data.id,
             res.data.item_id,
             res.data.pawnshop_id,
             res.data.customer_id
             );
               console.log(res);
               Swal.fire({
                  title: "Send Renewal Payment Succesfully",
                  toast: true,
                  timer: 3000,
                  position: "top-right"
               });
               this.$parent.GetPawnedItemsByPawnshop();
               $("#modalPawningPayment").modal("hide");
            })
            .catch(err => {
               console.error(err);
            });
      },



        donwloadPDfRenew(package_id, amount, date, zpawneditem_id, item_id, pawnshop_id, user_id){
               axios({
                    method: "post",
                    url: "/api/downloadPDFRenew",
                    data: {
                        package_id: package_id,
                        amount: amount,
                        date: date,
                        pawnshop_id: pawnshop_id,
                        customer_id: user_id,
                        zpawneditem_id: zpawneditem_id,
                        item_id: item_id,
                    },
                    responseType: "arraybuffer",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/pdf"
                    }
                })
                .then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", "receipt.pdf"); //or any other extension
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(error => console.log(error));
        },

      async claim() {
         let data = {
            item_id: this.pawned_item.item_id,
            pawned_item_id: this.pawned_item.id,
            amount: this.current_payment
         };
         await axios
            .post("api/sendClaimPayment", data)
            .then(res => {
             this.downloadPDFClaim(
             res.data.package_id,
             res.data.pawn_amount,
             res.data.date_renew,
             res.data.id,
             res.data.item_id,
             res.data.pawnshop_id,
             res.data.customer_id
             );
               console.log(res);
               Swal.fire({
                  title: "Send Claim Payment Succesfully",
                  toast: true,
                  timer: 3000,
                  position: "top-right"
               });
               this.$parent.GetPawnedItemsByPawnshop();
               $("#modalPawningPayment").modal("hide");
            })
            .catch(err => {
               console.error(err);
            });
      },


       downloadPDFClaim(package_id, amount, date, zpawneditem_id, item_id, pawnshop_id, user_id){
               axios({
                    method: "post",
                    url: "/api/downloadPDFClaim",
                    data: {
                        package_id: package_id,
                        amount: amount,
                        date: date,
                        pawnshop_id: pawnshop_id,
                        customer_id: user_id,
                        zpawneditem_id: zpawneditem_id,
                        item_id: item_id,
                        current_payment:  this.current_payment,
                        current_interest_rate:  this.current_interest_rate,
                    },
                    responseType: "arraybuffer",
                    headers: {
                        "Content-Type": "application/json",
                        Accept: "application/pdf"
                    }
                })
                .then(response => {
                    const url = window.URL.createObjectURL(new Blob([response.data]));
                    const link = document.createElement("a");
                    link.href = url;
                    link.setAttribute("download", "receipt.pdf"); //or any other extension
                    document.body.appendChild(link);
                    link.click();
                })
                .catch(error => console.log(error));
        },

      async getPaymentCalculations() {
         await axios
            .get(
               "api/getPawnedItemPaymentDetails/" +
                  this.pawned_item.package_id +
                  "/" +
                  this.pawned_item.pawn_amount +
                  "/" +
                  this.pawned_item.date_renew
            )
            .then(res => {
               this.calculations = res.data;
               this.monthly = this.calculations[0].monthly;
               this.specials = this.calculations[0].specials;
               this.current_payment = this.calculations[0].current_payment;
               this.current_interest_rate = this.calculations[0].current_interest_rate;
               this.current_renewal = this.calculations[0].current_renewal;
               this.date_now = this.calculations[0].date_now;
            })
            .catch(err => {
               console.error(err);
            });
      }
   }
};
</script>
