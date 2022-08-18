<template>
    <NavbarBase />
    <router-view />
    <!-- <FooterBase v-if="$route.matched[0].path != '/dashboard' && $route.matched[0].path != '/adf8d9234min'" /> -->
</template>

<script>
import NavbarBase from "./components/NavbarBase.vue"
// import FooterBase from "./components/FooterBase.vue"
export default {
  setup() {
    
  },
  components : {
     NavbarBase,
     // FooterBase
  }
}
</script>

<style lang="scss">
#app {
  font-family: Avenir, Helvetica, Arial, sans-serif;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
  color: #2c3e50;
}

nav {

  a {
    font-weight: bold;
    color: #2c3e50;

    &.router-link-exact-active {
      color: #42b983;
    }
  }
}
</style>
