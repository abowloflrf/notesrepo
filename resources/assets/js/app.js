
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.Vue = require('vue');

import ElementUI from 'element-ui'
import 'element-ui/lib/theme-chalk/index.css'
Vue.use(ElementUI)

// import {
//     Aside,
//     Button,
//     Container,
//     Dialog,
//     Header,
//     Icon,
//     Input,
//     Loading,
//     Main,
//     Message,
//     Table,
//     TableColumn,
//     Tree
// } from 'element-ui'
// import 'element-ui/lib/theme-chalk/index.css'
// Vue.use(Aside);
// Vue.use(Button);
// Vue.use(Container);
// Vue.use(Dialog);
// Vue.use(Header);
// Vue.use(Icon)
// Vue.use(Input);
// Vue.use(Main);
// Vue.use(Message);
// Vue.use(Table)
// Vue.use(TableColumn)
// Vue.use(Tree);

// Vue.use(Loading.directive)
// Vue.prototype.$message = Message



/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

//Vue.component('example-component', require('./components/ExampleComponent.vue'));
import App from './App.vue'

const app = new Vue({
    el: '#notesrepo-app',
    beforeCreate:function () {
        //let that = this;
        if (localStorage.token) {
            axios.defaults.headers.common['Authorization'] = 'Bearer' + localStorage.token;
            //TODO:刷新Token
            //Vue.prototype.$axios.defaults.headers.common['Authorization'] = 'Bearer' + localStorage.token;
            // axios.get('api/refreshtoken', {
            //     headers: {'Authorization': 'Bearer' + localStorage.token}
            // }).then(function (response) {
            //     let data = response.data;
            //     if (data.status == 1) {
            //         store.commit(types.LOGIN_SUCCESS, data);
            //         axios.defaults.headers.common['Authorization'] = 'Bearer' + data.token;
            //         Vue.prototype.$axios.defaults.headers.common['Authorization'] = 'Bearer' + data.token;
            //     }  else {
            //         router.push({path: '/login'});}
            // })
        }
    },
    render: h => h(App)
});
