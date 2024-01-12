

require('./bootstrap');

window.Vue = require('vue');

import Vue from 'vue'

import VueChatScroll from 'vue-chat-scroll'
Vue.use(VueChatScroll)

Vue.component('message', require('./components/message.vue'));

const app = new Vue({
    el: '#app',
    data: {
        message: '',
        chat:{
            message:[],
            user:[],
            color:[]
        }
    },
    methods: {
        send(){
            if(this.message != 0){
           this.chat.message.push(this.message);
                this.chat.color.push('success');
                this.chat.user.push('you');
                axios.post('/send', {
                   message: this.message
                })
                    .then(response=> {
                        console.log(response);
                        this.message =''
                    })
                    .catch(error=> {
                        console.log(error);
                    });
            }
        }
    },

    mounted() {
        Echo.private('chat')
            .listen('ChatEvent', (e) => {
                this.chat.message.push(e.message);
                this.chat.user.push(e.user);
                this.chat.color.push(e.warning);
                //console.log(e);
            });
    }
});
