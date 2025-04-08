<template>
  <nav class="navbar navbar-expand-lg custom-navbar">
    <div class="container-fluid position-relative">
      <div class="d-flex align-items-center">
        <a class="navbar-brand" href="#">
          <img src="@/photos/logo.png" class="logo" alt="Logo">
        </a>
        <router-link class="nav-link" to="/">Főoldal</router-link>
      </div>
      <div class="navbar-center-text">
        <span class="navbar-text">Gépkölcsönzés</span>
      </div>

      <div class="d-flex justify-content-end">
        <ul class="navbar-nav">
          <li class="nav-item">
            <router-link class="nav-link" to="/login">Bejelentkezés</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/register">Regisztráció</router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/profile">
              <img src="@/photos/profile.png" width="30" height="30" class="d-inline-block align-top" alt="Profile">
            </router-link>
          </li>
          <li class="nav-item">
            <router-link class="nav-link" to="/basket">
              <img src="@/photos/basket.png" width="30" height="30" class="d-inline-block align-top" alt="Basket">
            </router-link>
          </li>
        </ul>
      </div>
    </div>
  </nav>
</template>
  
  <script>
  export default {
    name: 'Navbar'
  };
  </script>
  
  <style scoped>
  .navbar {
    padding: 10px;
    height: 70px; 
    position: relative;
  }
  
  .custom-navbar {
    background-color: #858a91; 
  }
  
  .navbar-brand img.logo {
    height: 90px; 
    width: auto; 
  }
  

  .navbar-center-text {
    position: absolute;
    left: 50%;
    top: 50%;
    transform: translate(-50%, -50%);
    width: auto;
    z-index: 1;
  }
  
  .navbar-text {
    font-size: 1.5rem;
    font-weight: bold;
    white-space: nowrap;
  }
  
  .nav-link {
    font-size: 1.5rem; 
    font-weight: bold;
  }
  
  .navbar-nav {
    display: flex;
    align-items: center;
  }
  
  .navbar-nav .nav-item {
    margin-left: 10px;
    margin-right: 10px;
  }
  
  .navbar-nav .nav-link img {
    display: block;
    margin: 0 auto;
  }
  </style>