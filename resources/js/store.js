import Vue from 'vue'
import Vuex from 'vuex'

Vue.use(Vuex)

const store = new Vuex.Store({
    state : {
        _token : document.querySelector("meta[name=csrf-token]").content,
        loader : false
    },
    mutations : {
        loading(state,value)
        {
            state.loader = value
        }
    }
})

export default store