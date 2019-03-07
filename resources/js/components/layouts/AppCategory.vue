<template>
  <v-flex hidden-sm-and-down>
    <v-card>
      <v-card-title>
        <h4>Category:</h4>
      </v-card-title>
      <v-divider></v-divider>
      <v-list dense>
        <v-list-tile
          v-for="category in categories"
          :key="category.name"
          :to="'/category/' + category.id + '/posts'"
        >
          <v-list-tile-content>{{ category.name }}</v-list-tile-content>
          <v-list-tile-content class="primary--text align-end">{{ category.posts_count }}</v-list-tile-content>
        </v-list-tile>
      </v-list>
    </v-card>
  </v-flex>
</template>


<script>
import { mapGetters } from "vuex";

export default {
  name: "AppCategory",
  computed: {
    ...mapGetters({
      user: "auth/authUser",
      categories: "post/categories"
    })
  }
};
</script>

<style>
</style>
