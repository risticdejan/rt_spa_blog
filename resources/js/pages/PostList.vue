<template>
  <v-layout>
    <v-container grid-list-lg fluid>
      <v-layout row wrap>
        <v-flex xs12 md3>
          <app-categroy></app-categroy>
        </v-flex>
        <v-flex xs12 md6>
          <h2 class="mb-2">All Posts</h2>
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
        </v-flex>
      </v-layout>
    </v-container>
  </v-layout>
</template>

<script>
import AppCategroy from "../components/layouts/AppCategory";
import PostListItem from "../components/shared/PostListItem";
import { mapGetters } from "vuex";

export default {
  name: "PostList",
  components: {
    AppCategroy,
    PostListItem
  },
  data() {
    return {
      page: 1
    };
  },
  computed: {
    ...mapGetters({
      user: "auth/authUser",
      posts: "post/posts",
      categories: "post/categories",
      cpage: "post/current_page",
      length: "post/length"
    })
  },
  watch: {
    "$route.params.page": function(page) {
      this.page = page || 1;
      this.getPosts(page);
    }
  },
  created() {
    this.page = parseInt(this.$route.params.page) || 1;
    this.getPosts(this.page);
  },
  methods: {
    update(val) {
      let page = parseInt(val) || 1;

      this.$router.push({
        name: "post-list-page",
        params: { page: page }
      });
    },
    getPosts(page) {
      this.$store.dispatch("post/getPosts", page);
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
