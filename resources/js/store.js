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
        }
    },

    actions: {
        actifUser(context) {
            let response = async function() {
                return await axios.get('/user');
            }();
            response.then(r => {
                context.commit('setUser', r.data)
            })
        },
        getCategories(context) {
            let response = async function() {
                return await axios.get('/category');
            }();
            response.then(result => {
                context.commit('setCategories', result.data)
            });
        },
        getClients(context) {
            let response = async function() {
                return await axios.get('/client');
            }();
            response.then(result => {
                context.commit('setClients', result.data);
            })
        },
        getBanners(context) {
            let response = async function() {
                return await axios.get('/banner');
            }();
            response.then(results => {
                context.commit('setBanners', results.data);
            })
        }
    }

})

export default store