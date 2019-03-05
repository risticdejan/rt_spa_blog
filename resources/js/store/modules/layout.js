const state = {
    refresh: false,
    loadingApp: false
};

const mutations = {
    setRefresh: (state, payload) => {
        state.refresh = payload;
    },
    setLoadingApp: (state, payload) => {
        state.loadingApp = payload;
    }
};

const actions = null;

const getters = {
    refresh: state => state.refresh,
    loadingApp: state => state.loadingApp
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
