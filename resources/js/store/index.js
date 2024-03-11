import { createStore } from "vuex";

const store = createStore({
    state: {
        valorUf: 0,
    },
    mutations: {},
    actions: {
        udpateUf(context, payload) {
            context.commit("UPDATE_UF", payload);
        },
    },
    getters: {
        udpateUf: function (state) {
            return state.valorUf;
        },
    },
});

export default store;
