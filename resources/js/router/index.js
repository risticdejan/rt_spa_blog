import "babel-polyfill";
import Vue from "vue";
import VueRouter from "vue-router";
import store from "../store";

Vue.use(VueRouter);

import Signin from "../pages/auths/Signin";
import Signup from "../pages/auths/Signup";
import NotFound from "../pages/NotFound";
import PostAdd from "../pages/PostAdd";
import PostList from "../pages/PostList";
import PostCategoryList from "../pages/PostCategoryList";
import PostCategory from "../pages/PostCategory";
import Post from "../pages/Post";

const routes = [
    {
        path: "/",
        redirect: "/posts",
        meta: { requiresAuth: false }
    },
    {
        path: "/posts",
        name: "post-list",
        component: PostList,
        meta: { requiresAuth: false }
    },
    {
        path: "/posts/:page",
        name: "post-list-page",
        component: PostList,
        meta: { requiresAuth: false }
    },
    {
        path: "/category/:id/posts",
        name: "category-post-list",
        component: PostCategoryList,
        meta: { requiresAuth: false }
    },
    {
        path: "/category/:id/posts/:page",
        name: "category-post-list-page",
        component: PostCategoryList,
        meta: { requiresAuth: false }
    },
    {
        path: "/post/add",
        name: "post-add",
        component: PostAdd,
        meta: { requiresAuth: true }
    },
    {
        path: "/post/:id",
        name: "post",
        component: Post,
        meta: { requiresAuth: false }
    },
    {
        path: "/category/:category_id/post/:id",
        name: "category-post",
        component: PostCategory,
        meta: { requiresAuth: false }
    },
    {
        path: "/signout",
        name: "signout",
        meta: { signoutAuth: true }
    },
    {
        path: "/signin",
        name: "signin",
        component: Signin,
        meta: { requiresAuth: false }
    },
    {
        path: "/signup",
        name: "signup",
        component: Signup,
        meta: { requiresAuth: false }
    },
    {
        path: "*",
        name: "notFound",
        meta: { requiresAuth: false },
        component: NotFound
    }
];

const router = new VueRouter({
    routes,
    hashbang: false,
    mode: "history"
});

router.beforeEach((to, from, next) => {
    if (to.matched.some(record => record.meta.requiresAuth)) {
        if (!store.getters["layout/refresh"]) {
            let token = localStorage.getItem("token");
            if (token) {
                store.commit("layout/setLoadingApp", true);
                store
                    .dispatch("auth/getAuthUser")
                    .then(res => {
                        store.commit("layout/setLoadingApp", false);
                        next();
                    })
                    .catch(err => {
                        store.commit("layout/setLoadingApp", false);
                        next({
                            path: "/signin"
                        });
                    });
            }
        } else {
            if (!store.getters["auth/isLogged"]) {
                next({
                    path: "/signin"
                });
            } else {
                next();
            }
        }
    } else if (to.matched.some(record => record.meta.signoutAuth)) {
        store
            .dispatch("auth/signout")
            .then(res => {
                next({
                    path: "/"
                });
            })
            .catch(err => {
                next();
            });
    } else {
        if (!store.getters["layout/refresh"]) {
            let token = localStorage.getItem("token");
            if (token) {
                store.commit("layout/setLoadingApp", true);
                store
                    .dispatch("auth/getAuthUser")
                    .then(res => {
                        store.commit("layout/setLoadingApp", false);
                        next();
                    })
                    .catch(err => {
                        store.commit("layout/setLoadingApp", false);
                        next({
                            path: "/signin"
                        });
                    });
            } else {
                next();
            }
        } else {
            next();
        }
    }
});

export default router;
