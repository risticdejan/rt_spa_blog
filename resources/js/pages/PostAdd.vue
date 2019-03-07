<template>
  <v-layout>
    <v-container grid-list-lg fluid>
      <v-layout row wrap>
        <v-flex xs12 md3>
          <app-categroy></app-categroy>
        </v-flex>
        <v-flex xs12 md6>
          <h2>Add a New Post</h2>
        </v-flex>
      </v-layout>
    </v-container>
  </v-layout>
</template>

<script>
import { mapGetters } from "vuex";
import AppCategroy from "../components/layouts/AppCategory";

export default {
  name: "PostAdd",
  components: {
    AppCategroy
  },
  computed: {
    ...mapGetters({
      categories: "post/categories",
      user: "auth/authUser"
    })
  }
};
</script>

<style>
</style>
