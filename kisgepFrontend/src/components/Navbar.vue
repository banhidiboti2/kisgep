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
  padding: 10px 20px;
  height: 70px; 
  position: relative;
}

.custom-navbar {
  background-color: #858a91;
}

.navbar-brand img.logo {
  height: 60px;
  width: auto;
}

/* Nagy nézet (asztali) */
.container-fluid {
  display: flex;
  align-items: center;
  justify-content: space-between;
}

/* Logó + főoldal */
.d-flex.align-items-center {
  display: flex;
  align-items: center;
  gap: 10px;
}

/* Gépkölcsönzés középre */
.navbar-center-text {
  position: absolute;
  left: 50%;
  top: 50%;
  transform: translate(-50%, -50%);
  z-index: 1;
}

.navbar-text {
  font-size: 1.5rem;
  font-weight: bold;
  white-space: nowrap;
}

/* Jobboldali menü */
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

.nav-link {
  font-size: 1.2rem;
  font-weight: bold;
}

/* Mobil nézet (768px alatt) */
@media (max-width: 768px) {
  .navbar {
    height: auto;
    padding: 20px;
  }

  .container-fluid {
    flex-direction: column;
    align-items: center;
    justify-content: center;
  }

  .d-flex.align-items-center {
    flex-direction: column;
    gap: 5px;
  }

  .navbar-center-text {
    position: static;
    transform: none;
    margin: 10px 0;
  }

  .navbar-nav {
    flex-direction: column;
    align-items: center;
    margin-top: 10px;
  }

  .navbar-nav .nav-item {
    margin: 5px 0;
  }

  .navbar-brand img.logo {
    height: 70px;
  }

  .nav-link {
    font-size: 1.4rem;
  }
}

</style>
