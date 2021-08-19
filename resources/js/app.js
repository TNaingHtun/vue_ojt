import Vue from "vue";
import router from "./routes/routes";
import VueRouter from "vue-router";
import VueAxios from 'vue-axios';
import VueSimpleAlert from "vue-simple-alert";
import axios from 'axios';
import Layout from './components/Layout.vue';
import { library, dom } from '@fortawesome/fontawesome-svg-core';
import { fas } from '@fortawesome/free-solid-svg-icons';
import Vuetify from "vuetify";
import 'vuetify/dist/vuetify.min.css';
import "material-design-icons-iconfont/dist/material-design-icons.css";
//js_moment
import moment from "moment";
//vue_excel_export
import excel from 'vue-excel-export';
//vue_json_excel
import JsonExcel from "vue-json-excel";
//vue-excel-xlsx
import VueExcelXlsx from "vue-excel-xlsx";

library.add(fas);
dom.watch();

Vue.use(excel);
Vue.use(VueExcelXlsx);
Vue.use(VueRouter);
Vue.use(VueAxios, axios);
Vue.use(Vuetify);
Vue.use(VueSimpleAlert);
Vue.use(require('vue-moment'));
Vue.prototype.moment = moment;
//vue_json_excel_component
Vue.component("downloadExcel", JsonExcel);
Vue.component('pagination', require('laravel-vue-pagination'));
require('./bootstrap');

window.Vue = require('vue');
const vuetifyOptions = {
    icons: {
        iconfont: "md"
    }
};

Vue.prototype.$axios = axios;

Vue.component('app-layout', Layout);

const app = new Vue({
    vuetify: new Vuetify(vuetifyOptions),
    el: '#app',
    router
});