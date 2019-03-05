<template>
  <v-layout>
    <v-container grid-list-lg fluid>
      <v-layout row wrap>
        <v-flex xs12 md3>
          <h2>Category:</h2>
        </v-flex>
        <v-flex xs12 md9>
          <h2>Add a New Post</h2>
        </v-flex>
      </v-layout>
    </v-container>
  </v-layout>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "PostAdd",
  computed: {
    ...mapGetters({
      user: "auth/authUser"
    })
  }
};
</script>

<style>
</style>
