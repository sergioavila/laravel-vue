import { createStore } from "vuex";
import axios from "axios";

const store = createStore({
    state: {
        valoresUF: [],
    },
    mutations: {
        UPDATE_UF(state, payload) {
            state.valoresUF = payload;
        },
    },
    actions: {
        fetchData({ commit }, { from, to }) {
            // obtener los datos de la url
            axios
                .get(`api/data?from=${from}&to=${to}`)
                .then((response) => {
                    // actualiza el estado con los datos obtenidos
                    commit("UPDATE_UF", response.data);
                })
                .catch((error) => {
                    console.error("Error al obtener los datos:", error);
                });
        },
    },
    getters: {
        getValoresUF: (state) => {
            return state.valoresUF;
        },
    },
});

export default store;
