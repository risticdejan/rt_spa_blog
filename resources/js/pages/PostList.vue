<template>
  <v-layout>
    <v-container grid-list-lg fluid>
      <v-layout row wrap>
        <v-flex xs12 md3>
          <h2>Category:</h2>
        </v-flex>
        <v-flex xs12 md9>
          <h2 class="mb-2">Posts</h2>

          <ul class="post_list">
            <li v-for="post in posts" :key="post.title" class="mb-2">
              <h3>
                <a href=" "></a>
                <router-link :to="{ name: 'post', params: { id: post.id }}">{{ post.title }}</router-link>
              </h3>
              <p>{{ post.description }}</p>
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
import { mapGetters } from "vuex";

export default {
  name: "PostList",
  data() {
    return {
      page: 1
    };
  },
  computed: {
    ...mapGetters({
      user: "auth/authUser",
      posts: "post/posts",
      cpage: "post/current_page",
      length: "post/length"
    })
  },
  created() {
    this.page = this.cpage;
    if (this.$route.params) {
      this.page = parseInt(this.$route.params.page) || 1;
    }
    this.$store.dispatch("post/getPosts", this.page);
  },
  methods: {
    update(val) {
      let page = parseInt(val) || 1;
      this.$store.dispatch("post/getPosts", page);
      this.$router.push({
        name: "post-list-page",
        params: { page: page }
      });
    }
  }
};
</script>

<style scoped>
.post_list {
  list-style: none;
  margin: 0;
  padding: 0;
}

.post_list li p {
  color: #cccccc;
}
</style>
