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
        fetchData({ commit }) {
            const dates = {
                from: "2021-01-01",
                to: "2021-12-31",
            };
            // consultar a la api y trae los datos
            fetch("/api/data", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                },
                body: JSON.stringify(dates),
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
