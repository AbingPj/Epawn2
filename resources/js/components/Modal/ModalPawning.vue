<template>
	<div>
		<div class="modal" tabindex="-1" role="dialog" id="modalPawning">
			<div class="modal-dialog modal-xl" role="document">
				<div class="modal-content">
					<div class="modal-header">
						<h5 class="modal-title">Pawning Item</h5>
						<button
							type="button"
							class="close"
							data-dismiss="modal"
							aria-label="Close"
						>
							<span aria-hidden="true">&times;</span>
						</button>
					</div>
					<div class="modal-body">
						<!-- declineActive == false -->

						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<span class="input-group-text"
									># of days to notify before it hits the deadline</span
								>
							</div>
							<input
								onkeypress="return (event.charCode !=8 && event.charCode ==0 || (event.charCode >= 48 && event.charCode <= 57))"
								v-model="days_deadline"
								type="number"
								class="form-control"
							/>
							<div class="input-group-append">
								<span class="input-group-text">Days</span>
							</div>
						</div>

						<!-- <div class="input-group mb-3">
                <div class="input-group-prepend">
                  <span class="input-group-text">Item's Extension for the User</span>
                </div>
                <input type="text" class="form-control" v-model="pawning_info.ext_months" />
                <div class="input-group-append">
                  <span class="input-group-text">Months</span>
                </div>
                  </div>-->

						<div class="input-group mb-3">
							<div class="input-group-prepend">
								<label class="input-group-text" for="inputGroupSelect01"
									>Package</label
								>
							</div>
							<!-- <select class="custom-select" id="inputGroupSelect01">
                        <option
                           v-for="my_package in packages"
                           :value="my_package.package_id"
                           :key="my_package.package_id"
                        >{{my_package.package_name}}</option>
                     </select>-->

							<select
								class="form-control"
								id="inputGroupSelect01"
								v-model="selectedPackage"
								@change="getCalculations()"
							>
								<option :value="null" disabled>Select Package</option>
								<option
									v-for="pack in packages"
									:key="pack.id"
									:value="pack.id"
									>{{ pack.package_name }}</option
								>
							</select>
						</div>

						<div class="card">
							<div class="card-body">
								<h5 class="text-center">Pawn Agreement Information</h5>
								<br />
								<label class="form-label" style="color: #f57224;"
									>Bid Amount</label
								>
								<div class="input-group mb-3">
									<div class="input-group-prepend">
										<button
											class="btn"
											:class="{
												'btn-warning': bidAmountEditable,
												'btn-danger': !bidAmountEditable
											}"
											@click="bidAmountEditable = !bidAmountEditable"
											type="button"
										>
											Change Amount
										</button>
									</div>
									<input
										type="number"
										class="form-control"
										v-model="item.initial_amount"
										:disabled="bidAmountEditable"
										placeholder
										aria-label
										aria-describedby="basic-addon1"
									/>
								</div>
								<div class="row text-center">
									<div class="col">
										<small>Date</small>
									</div>
									<div class="col">
										<small>Total Interest</small>
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
										<b style="color: #f57224;"
											>{{ duration.from }} - {{ duration.to }}</b
										>
									</div>
									<div class="col">
										<b style="color: #f57224;">{{ duration.interest }}%</b>
									</div>
									<div class="col">
										<b style="color: #f57224;"
											>₱ {{ toFormat(duration.renewal) }}</b
										>
									</div>
									<div class="col">
										<b style="color: #f57224;"
											>₱ {{ toFormat(duration.redemption) }}</b
										>
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
										<b style="color: #f57224;"
											>₱ {{ toFormat(month.renewal) }}</b
										>
									</div>
									<div class="col">
										<b style="color: #f57224;"
											>₱ {{ toFormat(month.redemption) }}</b
										>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col">
								<!-- <button
                           class="btn btn-success btn-block"
                           @click="pawnItem()"
                           :disabled="declineActive || (pawning_info.notif_days.trim().length == 0 || pawning_info.package == 0)"
                        >Accept</button>-->
								<button
									:class="declineActive == true ? 'bg-light' : ''"
									:disabled="declineActive == true"
									class="btn btn-success btn-block"
									@click="savePawnedItem()"
								>
									Accept
								</button>
							</div>
							<div class="col">
								<button
									class="btn btn-danger btn-block"
									v-if="declineActive == false"
									@click="declineActive = !declineActive"
								>
									Decline
								</button>
								<div
									class="row"
									v-if="declineActive == true"
									style="padding: 0px !important;"
								>
									<div class="col">
										<!-- <button
                                 class="btn btn-success btn-block"
                                 @click="declineItem()"
                                 :disabled="pawning_info.reason.trim().length == 0"
                              >Confirm</button>-->
										<button
											class="btn btn-success btn-block"
											@click="reject(item)"
										>
											Confirm
										</button>
									</div>
									<div class="col">
										<button
											class="btn btn-danger btn-block"
											@click="declineActive = !declineActive"
										>
											Cancel
										</button>
									</div>
								</div>
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
			item: {},
			days_deadline: "",
			pawnshop_id: AuthService.methods.getUid(),
			packages: [],
			selectedPackage: null,
			bidAmountEditable: true,
			declineActive: false,
			calculations: [],
			specials: [],
			monthly: []
		};
	},
	created() {
		this.getPackages();
	},
	methods: {
		async reject(item) {
			let data = {
				item_id: this.item.item_id,
				pawnshop_id: this.pawnshop_id,
				customer_id: this.item.user_id
			};

			await axios
				.post("api/zRejectPendingItem", data)
				.then(res => {
					console.log(res);
					Swal.fire({
						title: "Item Rejected Succesfully",
						toast: true,
						timer: 3000,
						position: "top-right"
					});
					$("#modalPawning").modal("hide");
					this.$parent.GetPendingItemsByPawnshop();
				})
				.catch(err => {
					console.error(err);
				});
		},

		async savePawnedItem() {
			let data = {
				item_id: this.item.item_id,
				pawnshop_id: this.pawnshop_id,
				customer_id: this.item.user_id,
				package_id: this.selectedPackage,
				pawn_amount: this.item.initial_amount,
				days_deadline: this.days_deadline
			};

			await axios
				.post("api/zSavePawnedItem", data)
				.then(res => {
                    this.donwloadPDf(res.data.package_id, res.data.pawn_amount, res.data.date_pawned, res.data.id, res.data.item_id);
					console.log(res);
					Swal.fire({
						title: "Pawn Item Succesfully",
						toast: true,
						timer: 3000,
						position: "top-right"
					});
					$("#modalPawning").modal("hide");
					this.$parent.GetPendingItemsByPawnshop();
				})
				.catch(err => {
					console.error(err);
				});
		},

        donwloadPDf(package_id, amount, date, zpawneditem_id, item_id){
               axios({
                    method: "post",
                    url: "/api/downloadPDF",
                    data: {
                        package_id: package_id,
                        amount: amount,
                        date: date,
                        pawnshop_id: this.pawnshop_id,
                        customer_id: this.item.user_id,
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


		toFormat(num) {
			return Number(parseFloat(num).toFixed(2)).toLocaleString("en", {
				minimumFractionDigits: 2
			});
			//  return num.toFixed(2).toLocaleString(undefined, {
			//     maximumFractionDigits: 4,
			//     minimumFractionDicits: 4
			//  });
			// return parseFloat(num).toFixed(2).toLocaleString();
		},
		async getCalculations() {
			if (this.selectedPackage) {
				if (this.item.initial_amount) {
					await axios
						.get(
							"api/getPawnedItemCalculations/" +
								this.selectedPackage +
								"/" +
								this.item.initial_amount
						)
						.then(res => {
							this.calculations = res.data;
							this.monthly = this.calculations[0].monthly;
							this.specials = this.calculations[0].specials;
						})
						.catch(err => {
							console.error(err);
						});
				}
			}
		},
		async getPackages() {
			await axios
				.get("api/zGetPackages/" + this.pawnshop_id)
				.then(res => {
					console.log(res);
					this.packages = res.data;
				})
				.catch(err => {
					console.error(err);
				});
		}
	}
};
</script>
