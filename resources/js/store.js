import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state : {
        _token : document.querySelector("meta[name=csrf-token]").content,
        loader : false,
        user: null,
        drawer: false,
        categories: [],
        clients: [],
        banners: [],
        articles: []
    },
    mutations : {
        loading(state,value)
        {
            state.loader = value
        },
        setDrawer(state, value) {
            state.drawer = value
        },
        setUser(state, value) {
            state.user = value
        },
        setCategories(state, value) {
            state.categories = value
        },
        setClients(state, value) {
            state.clients = value
        },
        setBanners(state, value) {
            state.banners = value;
        },
        setArticles(state, value) {
            state.articles = value;
        }
    },

    actions: {
        actifUser(context) {
            let response = async function() {
                return await axios.get('/request/user');
            }();
            response.then(r => {
                context.commit('setUser', r.data)
            })
        },
        getCategories(context) {
            let response = async function() {
                return await axios.get('/request/category');
            }();
            response.then(result => {
                context.commit('setCategories', result.data)
            });
        },
        getClients(context) {
            let response = async function() {
                return await axios.get('/request/client');
            }();
            response.then(result => {
                context.commit('setClients', result.data);
            })
        },
        getBanners(context) {
            let response = async function() {
                return await axios.get('/request/banner');
            }();
            response.then(results => {
                context.commit('setBanners', results.data);
            })
        },
        getArticles(context) {
            let response = async function() {
                return await axios.get('article');
            }();
            response.then(results => {
                context.commit('setArticles', results.data);
            })
        }
    }

})

export default store