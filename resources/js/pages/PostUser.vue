<template>
  <v-layout>
    <v-container grid-list-lg fluid>
      <v-layout row wrap>
        <v-flex xs12 md3>
          <app-categroy></app-categroy>
        </v-flex>
        <v-flex xs12 md6>
          <div v-if="post">
            <post-one :post="post" :bitems="bitems"></post-one>
          </div>
          <div v-else>
            <h2>The requested post was not found</h2>
          </div>
        </v-flex>
      </v-layout>
    </v-container>
  </v-layout>
</template>

<script>
import { mapGetters } from "vuex";
import AppCategroy from "../components/layouts/AppCategory";
import PostOne from "../components/shared/PostOne";

export default {
  name: "PostUser",
  components: {
    AppCategroy,
    PostOne
  },
  computed: {
    ...mapGetters({
      user: "auth/authUser",
      post: "post/post"
    }),
    bitems: function() {
      return [
        {
          text: "Posts",
          disabled: false,
          href: {
            name: "user-post-list-page",
            params: {
              id: this.$route.params.user_id,
              page: this.$store.getters["post/current_page"]
            }
          }
        },
        {
          text: "Post",
          disabled: true,
          href: ""
        }
      ];
    }
  },
  created() {
    let id = parseInt(this.$route.params.id) || 0;

    this.$store.dispatch("post/getPost", id);
  }
};
</script>

