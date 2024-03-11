import { createStore } from "vuex";

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
            // consultar a la api y trae los datos
            const queryString = new URLSearchParams($dates).toString();

            // consultar a la api y trae los datos
            fetch("/api/data?" + queryString, {
                method: "GET",
                headers: {
                    "Content-Type": "application/json",
                },
            })
                .then((response) => response.json())
                .then((data) => {
                    commit("UPDATE_UF", data);
                })
                .catch((error) => {
                    console.error("Error al obtener los datos:", error);
                });
        },
    },
    getters: {},
});

export default store;
