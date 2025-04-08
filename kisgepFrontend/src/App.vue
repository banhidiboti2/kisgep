<template>
  <div id="app">
    <Navbar />
    <main class="content">
      <router-view/>
    </main>
    <Footer />
  </div>
</template>

<script>
import Navbar from './components/Navbar.vue';
import Footer from './components/Footer.vue';

export default {
  name: 'App',
  components: {
    Navbar,
    Footer
  }
};
</script>

<style>
#app {
  background-color: #f7f8fa; 
  min-height: 100vh;
  display: flex;
  flex-direction: column;
}

.content {
  flex: 1;
  padding: 20px;
}
</style>