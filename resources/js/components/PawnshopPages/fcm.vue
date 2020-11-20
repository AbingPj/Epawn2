<template>
    <div>
    </div>
</template>
<script>
    const jsonApiHeader = {
        "access-control-allow-origin": "http://epawn2.test",
        "Content-Type": "application/json; charset=UTF-8",
        "Authorization": "key=AAAAJLCm3kk:APA91bGgnwb5jH_oMnTHSd1T6yQw_bwC53UZcfmB4Wt54DUXLyigR5wjU-oC9KwZ1YW748qgbdL_k90Mi2a6ZVYwT4FnvpxWDQBNgGb7pjrhyS_7oQ6fdIjLmvgkIj4QbomPVWLFKf4e",
    };
    export default {

        data() {
            return {

                alertMsg: "",
                fcmUrl: "https://fcm.googleapis.com/fcm/send",
                fcmJson: {
                    to: "/topics/all",
                    content_available: true,
                    notification: {
                        title: "Test",
                        body: "OKay",
                        click_action: "FCM_PLUGIN_ACTIVITY",
                        sound: "default",
                        priority: "priority",
                    },
                    data: {
                        app_notification: "1",
                        term: "48",
                        activity_date: "2018-08-16 15:30:00",
                        msg_type: "1",
                        student_id: "1111",
                        college_code: "edrdemo",
                        notification_from_firebase: "1",
                        avatar_img_url: "0",
                    }
                }

            }
        },


        methods: {
            submitAction: function () {

                if (!this.fcmJson.notification.title || !this.fcmJson.notification.body || !this.fcmJson.to) {
                    this.alertMsg = '<span class="text-danger">title, body, to can\'t empty</span>'
                } else {
                    this.alertMsg = 'Please wait...'
                    console.log('submitAction');
                    this.postToFirebase()
                    // this.postToFirebase().then((resualt) => {
                    //     console.log(resualt);
                    //     this.alertMsg = '';
                    // });
                }
            },
            // async postToFirebase() {

            //     console.log('postToFirebase');
            //     const dataParam = this.fcmJson;
            //     try {
            //         const response = await axios({
            //             method: 'post',
            //             url: this.fcmUrl,
            //             headers: jsonApiHeader,
            //             data: dataParam
            //         });
            //         return response;
            //     } catch (error) {
            //         console.error(error);
            //     }


            // }
            postToFirebase() {
                //             $.post(
                //     "https://maps.googleapis.com/maps/api/geocode/json",
                //     param,
                //     function (res) {
                //     let lat = res.results[0].geometry.location.lat;
                //     let lng = res.results[0].geometry.location.lng;
                //     self.zone.address = res.results[0].formatted_address;
                //     self.selectZone(lat, lng);
                //     }
                // ).fail(function () {
                //     console.log("error");
                // });
                console.log("test")
                const dataParam = this.fcmJson;
                let sef = this;
                // $.ajax({
                //     url: sef.fcmUrl,
                //     headers: {
                //         'Content-Type': 'application/json; charset=UTF-8',
                //         'Authorization':'key=AAAAJLCm3kk:APA91bGgnwb5jH_oMnTHSd1T6yQw_bwC53UZcfmB4Wt54DUXLyigR5wjU-oC9KwZ1YW748qgbdL_k90Mi2a6ZVYwT4FnvpxWDQBNgGb7pjrhyS_7oQ6fdIjLmvgkIj4QbomPVWLFKf4e'
                //     },
                //     method: 'POST',
                //     dataType: 'json',
                //     data: dataParam,
                //     success: function(data){
                //     console.log('succes: '+data);
                //     }
                // });


                $.ajax({
                        url: 'https://fcm.googleapis.com/fcm/send',
                        type: 'post',
                        data: JSON.stringify(dataParam),
                        headers: {
                        'Content-Type': 'application/json',
                        'Authorization': 'key=AAAAJLCm3kk:APA91bGgnwb5jH_oMnTHSd1T6yQw_bwC53UZcfmB4Wt54DUXLyigR5wjU-oC9KwZ1YW748qgbdL_k90Mi2a6ZVYwT4FnvpxWDQBNgGb7pjrhyS_7oQ6fdIjLmvgkIj4QbomPVWLFKf4e'
                        },
                        dataType: 'json',
                        success: function (data) {
                        console.info(data);
                        }
                    });
            }





        }
    }
</script>
