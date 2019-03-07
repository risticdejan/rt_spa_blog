import router from "../../router";

const state = {
    posts: [],
    categories: [],
    category: null,
    post: null,
    current_page: 1,
    length: 1
};

const mutations = {
    clearPosts: state => {
        state.posts = [];
    },
    clearCategories: state => {
        state.categories = [];
    },
    clearPost: state => {
        state.post = null;
    },
    clearCurrentPage: state => {
        state.current_page = 1;
    },
    clearCurrentCategory: state => {
        state.category = null;
    },
    clearLength: state => {
        state.length = 1;
    },
    setPosts: (state, payload) => {
        state.posts = payload;
    },
    setCategories: (state, payload) => {
        state.categories = payload;
    },
    setPost: (state, payload) => {
        state.post = payload;
    },
    setCurrentPage: (state, payload) => {
        state.current_page = payload;
    },
    setCurrentCategory: (state, payload) => {
        state.category = payload;
    },
    setLength: (state, payload) => {
        state.length = payload;
    }
};

const actions = {
    getPosts: ({ commit }, page_nb) => {
        const url = base_url + "api/post?page=" + page_nb;
        return new Promise((resolve, reject) => {
            axios
                .get(url)
                .then(res => {
                    const posts = res.data.posts;
                    const cur_page = res.data.current_page;
                    const length = res.data.length;

                    commit("setPosts", posts);
                    commit("setCurrentPage", cur_page);
                    commit("setLength", length);

                    resolve(res);
                })
                .catch(err => {
                    commit("clearPosts");
                    commit("clearCurrentPage");
                    commit("clearLength");
                    reject(err);
                });
        });
    },
    getPost: ({ commit }, post_id) => {
        const url = base_url + "api/post/" + post_id;
        return new Promise((resolve, reject) => {
            axios
                .get(url)
                .then(res => {
                    const post = res.data.post;

                    commit("setPost", post);
                    resolve(res);
                })
                .catch(err => {
                    commit("clearPost");
                    reject(err);
                });
        });
    },
    getCategories: ({ commit }, page_nb) => {
        const url = base_url + "api/category";
        return new Promise((resolve, reject) => {
            axios
                .get(url)
                .then(res => {
                    const categories = res.data.categories;
                    commit("setCategories", categories);
                    resolve(res);
                })
                .catch(err => {
                    commit("clearCategories");
                    reject(err);
                });
        });
    },
    getCategoryPosts: ({ commit }, params) => {
        const url =
            base_url +
            "api/category/" +
            params.id +
            "/posts?page=" +
            params.page;
        return new Promise((resolve, reject) => {
            axios
                .get(url)
                .then(res => {
                    const posts = res.data.posts;
                    const cur_page = res.data.current_page;
                    const cur_category = res.data.current_category;
                    const length = res.data.length;

                    commit("setPosts", posts);
                    commit("setCurrentPage", cur_page);
                    commit("setCurrentCategory", cur_category);
                    commit("setLength", length);

                    resolve(res);
                })
                .catch(err => {
                    commit("clearPosts");
                    commit("clearCurrentPage");
                    commit("clearCurrentCategory");
                    commit("clearLength");
                    reject(err);
                });
        });
    }
};

const getters = {
    posts: state => state.posts,
    categories: state => state.categories,
    post: state => state.post,
    current_page: state => state.current_page,
    current_category: state => state.category,
    length: state => state.length
};

export default {
    namespaced: true,
    state,
    getters,
    actions,
    mutations
};
