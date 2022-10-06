<template>

    <div>
    <router-view></router-view>

    <!-- Footer provvisorio -->
    <footer class="py-4 text-center custom-shadow">
      <div class="container">
        <small>boolbnb &copy;2022</small>
      </div>
    </footer>

    </div>
  
</template>

<script>
export default {
  name: "App",
};
</script>

<style lang='scss' scoped>

.custom-shadow {
  box-shadow: 0 -0.5rem 1rem rgb(0 0 0 / 15%);
}
</style>

