<template>
  <v-navigation-drawer v-model="ndrawer" temporary fixed app>
    <v-toolbar color="primary" dark flat>
      <v-toolbar-side-icon @click.stop="toggleSidebar">
        <v-icon>fa fa-bars</v-icon>
      </v-toolbar-side-icon>
      <v-toolbar-title>Social</v-toolbar-title>
    </v-toolbar>

    <v-divider></v-divider>

    <v-list>
      <v-list-tile to="/posts">
        <v-list-tile-action>
          <v-icon>fa fa-newspaper</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>Posts</v-list-tile-content>
      </v-list-tile>
      <v-list-tile to="/post/add" v-if="isLogged">
        <v-list-tile-action>
          <v-icon>fa fa-plus-square</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>Add Post</v-list-tile-content>
      </v-list-tile>
      <v-list-tile to="/signin" v-if="!isLogged">
        <v-list-tile-action>
          <v-icon>fa fa-sign-in-alt</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>Sign in</v-list-tile-content>
      </v-list-tile>
      <v-list-tile to="/signup" v-if="!isLogged">
        <v-list-tile-action>
          <v-icon>fa fa-user-plus</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>Sing up</v-list-tile-content>
      </v-list-tile>
      <v-list-tile to="/signout" v-if="isLogged">
        <v-list-tile-action>
          <v-icon>fa fa-sign-out-alt</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>Sign out</v-list-tile-content>
      </v-list-tile>
    </v-list>
    <v-list></v-list>

    <v-divider></v-divider>

    <v-list subheader>
      <v-subheader>Categories:</v-subheader>

      <v-list-tile
        v-for="category in categories"
        :key="category.name"
        :to="'/category/' + category.id + '/posts'"
      >
        <v-list-tile-action>
          <v-icon>far fa-dot-circle</v-icon>
        </v-list-tile-action>
        <v-list-tile-content>
          <v-list-tile-title v-html="category.name"></v-list-tile-title>
        </v-list-tile-content>
        <v-list-tile-content class="primary--text align-end">{{ category.posts_count }}</v-list-tile-content>
      </v-list-tile>
    </v-list>
  </v-navigation-drawer>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "AppSidebar",
  props: ["drawer"],
  computed: {
    ...mapGetters({
      isLogged: "auth/isLogged",
      categories: "post/categories"
    }),
    ndrawer: {
      get: function() {
        return this.drawer;
      },
      set: function(val) {
        if (val != this.drawer) {
          this.$emit("toggleSidebar");
        }
      }
    }
  },
  methods: {
    toggleSidebar() {
      this.$emit("toggleSidebar");
    }
  },
  created() {
    this.$store.dispatch("post/getCategories");
  }
};
</script>

<style>
</style>
