    <script src="js/jquery.min.js"> </script>
    <script src="js/bootstrap.js"> </script>
    <script src="../node_modules/@fortawesome/fontawesome-free/js/all.js"></script>
    <script src="https://js.pusher.com/4.3/pusher.min.js"></script>
    <script src="../node_modules/vue/dist/vue.min.js"></script>
    <script src="../node_modules/axios/dist/axios.min.js"></script>
    <script src="../node_modules/vue-chat-scroll/dist/vue-chat-scroll.js"></script>
    <script src="../node_modules/moment/moment.js"></script>


    <script>

        function changeStatus(selectelement) {
            let taskid = document.getElementById(selectelement).nextElementSibling.value;
            let taskstatus = document.getElementById(selectelement).value;
            //console.log(taskid);
            //console.log(taskstatus);
            let formData = new FormData();
            formData.append('taskid',taskid);
            formData.append('data', taskstatus);
            axios.post('changeStatus.php',formData)
                .then(res=>{
                    if(res.data){
                        window.location = "mytask.php";
                        console.log("true");
                    }
                }).catch(err=>console.log(err));
        }

        moment().format();

        Vue.filter('momentdate',(date)=>{
            return moment(date).format('MMMM Do YYYY, h:mm:ss a');
            //return moment(date).utc(date).local().fromNow();
        });



       const app = new Vue({
            el : '#app',
            data:{
                isShow : false,
                signedupuser : null,
                chatwithuser : null,
                chatwithname : null,
                msg : '',
                messages : []
            },

            methods : {

                chatpopup : function(event){

                    let chatwithid = event.target.getAttribute('data-chatwithid');
                    let chatwithname = event.target.innerHTML;
                    this.chatwithname = chatwithname;
                    this.isShow = true;
                    let elem = document.querySelector('#chat_box');
                    elem.style.display = 'block';

                    // var params = new URLSearchParams();
                    // params.append('chatwithid', chatwithid);
                    let formData = new FormData();
                    formData.append('chatwithid', chatwithid);

                    axios.post('../axios/getchatwithuser.php',formData)
                        .then((res)=>{
                            console.log(res);
                            this.chatwithuser = res.data;
                            console.log(this.chatwithuser);
                            let formData = new FormData();
                            formData.append('from',this.signedupuser.id);
                            formData.append('to',this.chatwithuser.id);
                            axios.post('../axios/msgfeed.php',formData)
                                .then((res)=>{
                                    this.messages = res.data;
                                }).catch(err=>console.log(err));
                        }).catch(err=>console.log(err));

                },

                sendingmsg : function(){
                    if(this.msg.length<1){
                        return 0;
                    }
                    let msg = this.msg;
                    let formData = new FormData();
                    formData.append('msg',this.msg);
                    formData.append('from',this.signedupuser.id);
                    formData.append('to',this.chatwithuser.id);
                    axios.post('../axios/sendmsg.php',formData)
                        .then(res=>{
                            // if(!res.data){
                            //     console.error('something went wrong while u sending message!!');
                            // }
                        }).catch(err=>console.log(err));
                    this.msg = '';
                },

                hidechatbox : function () {
                    let elem = document.querySelector('#chat_box');
                    elem.style.display = 'none';
                }

            },

            mounted(){

                Pusher.logToConsole = true;

                var pusher = new Pusher('615ab82d58d43b853e3b', {
                    cluster: 'ap2',
                    forceTLS: true
                });

                var channel = pusher.subscribe('my-channel');

                channel.bind('my-event',(data) => {
                    //alert(JSON.stringify(data));
                    if(this.chatwithuser) {
                        if (data.message.from == this.chatwithuser.id) {
                            this.messages.push(data.message);
                        }
                    }

                    if(data.message.from == this.signedupuser.id){
                        this.messages.push(data.message);
                    }

                    this.messages.push(data.message);

                });


                axios.get('../axios/getsingedupuser.php')
                   .then(res=>{
                       this.signedupuser = res.data;
                       //console.log(res.data);
                   }).catch(err=>console.log(err));

            }

        });

    </script>


    </body>

</html>