<template>
  <v-layout>
    <v-container grid-list-lg fluid>
      <v-layout row wrap>
        <v-flex xs12 md3></v-flex>
        <v-flex xs12 md6>
          <h2>Home</h2>
        </v-flex>
      </v-layout>
    </v-container>
  </v-layout>
</template>

<script>
import { mapGetters } from "vuex";

export default {
  name: "Home",
  computed: {
    ...mapGetters({
      user: "auth/authUser"
    })
  }
};
</script>

<style>
</style>
