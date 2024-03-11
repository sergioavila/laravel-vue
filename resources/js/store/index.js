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
        fetchData({ commit }, $dates) {
            // obtener los datos de la url
            const queryString = new URLSearchParams($dates).toString();
            // consultar a la api y trae los datos
            axios
                .get("/api/data?" + queryString)
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
