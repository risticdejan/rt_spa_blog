<template>
  <v-layout>
    <v-container grid-list-lg fluid>
      <v-layout row wrap>
        <v-flex xs12 md3>
          <app-categroy></app-categroy>
        </v-flex>
        <v-flex xs12 md6>
          <div v-if="post">
            <h2 class="mb-2">{{ post.title }}</h2>
            <p class="stitle">Posted by
              <router-link
                :to="{ name: 'user-post-list', params: { id: post.user.id }}"
              >{{ post.user.name }}</router-link>
              on {{ post.created_at }}.
            </p>
            <v-breadcrumbs :items="bitems">
              <template v-slot:item="props">
                <a
                  :href="props.item.href"
                  :class="[props.item.disabled && 'disabled']"
                >{{ props.item.text }}</a>
              </template>
            </v-breadcrumbs>
            <p>{{ post.body }}</p>
          </div>
        </v-flex>
      </v-layout>
    </v-container>
  </v-layout>
</template>

<script>
import { mapGetters } from "vuex";
import AppCategroy from "../components/layouts/AppCategory";

export default {
  name: "PostUser",
  components: {
    AppCategroy
  },
  computed: {
    ...mapGetters({
      user: "auth/authUser",
      post: "post/post",
      categories: "post/categories"
    }),
    bitems: function() {
      return [
        {
          text: "Posts",
          disabled: false,
          href:
            "user/" +
            this.$route.params.user_id +
            "/posts/" +
            this.$store.getters["post/current_page"]
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

<style scoped>
ul.v-breadcrumbs {
  padding: 10px 0px;
}

ul.v-breadcrumbs a {
  text-decoration: none;
}
ul {
  padding: 0;
}

.disabled {
  color: grey;
  pointer-events: none;
}

p.stitle {
  color: #797878;
  margin-bottom: 5px;
}
</style>
