<template>
  <v-layout>
    <v-container grid-list-lg fluid>
      <v-layout row wrap>
        <v-flex xs12 md3>
          <app-categroy></app-categroy>
        </v-flex>
        <v-flex xs12 md6>
          <app-loading-page v-if="!loading"></app-loading-page>
          <dir v-else>
            <h2 class="mb-2">All Posts</h2>
            <div v-if="posts.length > 0">
              <ul class="post_list">
                <post-list-item
                  v-for="post in posts"
                  :key="post.title"
                  class="mb-4"
                  :post="post"
                  :fLink="{ name: 'post', params: {id: post.id}}"
                  :sLink="{name: 'user-post-list',params: {id: post.user.id}}"
                ></post-list-item>
              </ul>
              <div class="text-xs-left">
                <v-pagination
                  v-model="page"
                  :length="length"
                  :total-visible="7"
                  prev-icon="fa fa-caret-left"
                  next-icon="fa fa-caret-right"
                  @input="update"
                ></v-pagination>
              </div>
            </div>
            <div v-else>
              <p>There are no posts.</p>
            </div>
          </dir>
        </v-flex>
      </v-layout>
    </v-container>
  </v-layout>
</template>

<script>
import AppCategroy from "../components/layouts/AppCategory";
import PostListItem from "../components/shared/PostListItem";
import AppLoadingPage from "../components/layouts/AppLoadingPage";

import { mapGetters } from "vuex";

export default {
  name: "PostList",
  components: {
    AppCategroy,
    PostListItem,
    AppLoadingPage
  },
  data() {
    return {
      page: 1
    };
  },
  computed: {
    ...mapGetters({
      loading: "layout/loading",
      user: "auth/authUser",
      posts: "post/posts",
      categories: "post/categories",
      cpage: "post/current_page",
      length: "post/length"
    })
  },
  watch: {
    $route: "fetchData"
  },
  created() {
    this.fetchData();
    Echo.channel("post.create").listen("CreatePostEvent", e => {
      this.updateData();
    });
  },
  methods: {
    update(val) {
      let page = parseInt(val) || 1;

      this.$router.push({
        name: "post-list-page",
        params: { page: page }
      });
    },
    fetchData() {
      this.page = parseInt(this.$route.params.page) || 1;
      this.$store.commit("layout/setLoading", false);
      this.$store
        .dispatch("post/getPosts", this.page)
        .then(res => {
          this.$store.commit("layout/setLoading", true);
        })
        .catch(err => {
          this.$store.commit("layout/setLoading", true);
        });
    },
    updateData() {
      this.page = parseInt(this.$route.params.page) || 1;

      this.$store
        .dispatch("post/getPosts", this.page)
        .then(res => {})
        .catch(err => {});
    }
  }
};
</script>

<style>
.post_list {
  list-style: none;
  margin: 0;
  padding: 0;
}

@media screen and (max-width: 440px) {
  ul.v-pagination > li {
    display: none;
  }

  ul.v-pagination > li:first-child {
    display: flex;
  }

  ul.v-pagination > li:last-child {
    display: flex;
  }
}
</style>
