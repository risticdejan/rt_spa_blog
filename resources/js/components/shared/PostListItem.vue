<template>
  <li v-if="post">
    <h3>
      <router-link :to="fLink">{{ post.title }}</router-link>
    </h3>
    <p class="stitle">Posted by
      <router-link :to="sLink">{{ post.user.name }}</router-link>
      on {{ post.created_at }}.
    </p>
    <p class="description">{{ post.description }}</p>
  </li>
</template>

<script>
export default {
  name: "PostListItem",
  props: ["post", "fLink", "sLink"]
};
</script>

<style>
p.description {
  color: #ffffff;
}

p.stitle {
  color: #797878;
  margin: 5px 0;
}
</style>
