<template>
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
        <router-link
          :to="props.item.href"
          :class="[props.item.disabled && 'disabled']"
        >{{ props.item.text }}</router-link>
      </template>
    </v-breadcrumbs>
    <p>{{ post.body }}</p>
  </div>
</template>

<script>
export default {
  name: "PostOne",
  props: ["post", "bitems"]
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
