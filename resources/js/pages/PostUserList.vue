<template>
  <v-layout>
    <v-container grid-list-lg fluid>
      <v-layout row wrap>
        <v-flex xs12 md3>
          <app-categroy></app-categroy>
        </v-flex>
        <v-flex xs12 md6>
          <h2 class="mb-2" v-if="user">All Posts posted by "{{ user.name }}"</h2>
          <ul class="post_list">
            <li v-for="post in posts" :key="post.title" class="mb-4">
              <h3>
                <a href=" "></a>
                <router-link
                  :to="{ name: 'user-post', params: { user_id: post.user.id, id: post.id }}"
                >{{ post.title }}</router-link>
              </h3>
              <p class="stitle">Posted by
                <router-link
                  :to="{ name: 'user-post-list', params: { id: post.user.id }}"
                >{{ post.user.name }}</router-link>
                on {{ post.created_at }}.
              </p>
              <p class="description">{{ post.description }}</p>
            </li>
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
import { mapGetters } from "vuex";

export default {
  name: "PostUserList",
  components: {
    AppCategroy
  },
  data() {
    return {
      page: 1,
      id: 0
    };
  },
  computed: {
    ...mapGetters({
      user: "post/current_user",
      posts: "post/posts",
      categories: "post/categories",
      category: "post/current_category",
      cpage: "post/current_page",
      length: "post/length"
    })
  },
  watch: {
    "$route.params": function(params) {
      this.page = parseInt(params.page) || 1;
      this.id = parseInt(params.id) || 1;

      this.getPostsForUserId(this.id, this.page);
    }
  },
  created() {
    this.id = parseInt(this.$route.params.id) || 1;
    this.page = parseInt(this.$route.params.page) || 1;

    this.getPostsForUserId(this.id, this.page);
  },

  methods: {
    update(val) {
      let page = parseInt(val) || 1;

      this.$router.push({
        name: "user-post-list-page",
        params: { page: page }
      });
    },
    getPostsForUserId(id, page) {
      this.$store.dispatch("post/getUserPosts", {
        id: id,
        page: page
      });
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

.post_list li p.description {
  color: #ffffff;
}

.post_list li p.stitle {
  color: #797878;
  margin: 5px 0;
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
