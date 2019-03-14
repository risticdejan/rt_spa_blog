<template>
  <v-layout>
    <v-container grid-list-lg fluid>
      <v-layout row wrap>
        <v-flex xs12 md3>
          <app-categroy></app-categroy>
        </v-flex>
        <v-flex xs12 md6>
          <h2 class="mb-2">Add new Post</h2>

          <form-alert v-if="error" :messages="error"></form-alert>
          <v-form v-model="isFormValid" lazy-validation ref="form" @submit.prevent="handleCreate">
            <v-layout row>
              <v-flex xs12>
                <v-text-field
                  :rules="titleRules"
                  v-model="title"
                  label="Title"
                  type="text"
                  required
                ></v-text-field>
              </v-flex>
            </v-layout>

            <v-layout row>
              <v-flex xs12>
                <v-text-field
                  :rules="descriptionRules"
                  v-model="description"
                  label="Description"
                  type="text"
                  required
                ></v-text-field>
              </v-flex>
            </v-layout>

            <v-layout row>
              <v-flex xs12>
                <v-select
                  :rules="categoryRules"
                  v-model="category"
                  :items="categories"
                  label="Select Category:"
                  item-text="name"
                  item-value="id"
                ></v-select>
              </v-flex>
            </v-layout>

            <v-layout row>
              <v-flex xs12>
                <v-textarea
                  name="input-7-1"
                  label="Put yout text"
                  :rules="bodyRules"
                  v-model="body"
                ></v-textarea>
              </v-flex>
            </v-layout>

            <v-layout row>
              <v-flex xs12>
                <v-btn
                  :loading="loading"
                  :disabled="!isFormValid"
                  block
                  color="primary"
                  type="submit"
                >
                  <span slot="loader" class="custom-loader">
                    <v-icon light>fas fa-spinner</v-icon>
                  </span>
                  Create
                </v-btn>
              </v-flex>
            </v-layout>
          </v-form>
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
  data() {
    return {
      loading: false,
      isFormValid: true,
      title: "",
      description: "",
      category: null,
      body: "",
      titleRules: [
        title => !!title || "Title is required",
        title =>
          title.length < 125 || "Title cannot be more than 125 characters"
      ],
      descriptionRules: [
        description => !!description || "Description is required",
        description =>
          description.length < 255 ||
          "Description cannot be more than 255 characters"
      ],
      categoryRules: [category => !!category || "Category is required"],
      bodyRules: [
        body => !!body || "Text is required",
        body => body.length < 3255 || "Text cannot be more than 3255 characters"
      ]
    };
  },
  computed: {
    ...mapGetters({
      user: "auth/authUser",
      token: "auth/token",
      error: "post/error",
      categories: "post/categories"
    })
  },
  created() {},
  destroyed() {
    this.$store.commit("post/clearError");
  },
  methods: {
    handleCreate() {
      if (this.$refs.form.validate() && this.loading == false) {
        this.loading = true;
        this.$store
          .dispatch("post/create", {
            token: this.token,
            title: this.title,
            description: this.description,
            body: this.body,
            category_id: this.category
          })
          .then(res => {
            this.loading = false;
          })
          .catch(err => {
            this.loading = false;
          });
      }
    }
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
</style>
