<template>
    <div class="profile-view">
      <div class="container" v-if="isLoggedIn">
        <div class="profile-box">
          <h2>Felhasználói profil</h2>
          
          <div class="profile-info">
            <div class="profile-avatar">
              <div class="avatar-circle">
                <span class="initials">{{ userInitials }}</span>
              </div>
            </div>
            
            <div class="profile-details">
              <div class="profile-field">
                <h3>Név</h3>
                <p>{{ user.vezeteknev }} {{ user.keresztnev }}</p>
              </div>
              
              <div class="profile-field">
                <h3>Email</h3>
                <p>{{ user.email }}</p>
              </div>
              
              <div class="profile-field">
                <h3>Telefonszám</h3>
                <p>{{ user.telefonszam }}</p>
              </div>
            </div>
          </div>
          
          <button @click="logout" class="btn-logout">Kijelentkezés</button>
        </div>
      </div>
      
      <div class="container" v-else>
        <div class="login-prompt">
          <h1>Jelentkezz be a profil megtekintéséhez</h1>
          <router-link to="/login" class="btn-login">Bejelentkezés</router-link>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    data() {
      return {
        user: null,
        isLoggedIn: false
      };
    },
    computed: {
      userInitials() {
        if (!this.user) return '';
        return (this.user.vezeteknev?.charAt(0) || '') + (this.user.keresztnev?.charAt(0) || '');
      }
    },
    created() {
      this.checkLoginStatus();
    },
    methods: {
      checkLoginStatus() {
        const userJson = localStorage.getItem('user');
        const token = localStorage.getItem('token');
        
        if (userJson && token) {
          try {
            this.user = JSON.parse(userJson);
            this.isLoggedIn = true;
          } catch (e) {
            console.error('Error parsing user data', e);
            this.isLoggedIn = false;
          }
        } else {
          this.isLoggedIn = false;
        }
      },
      logout() {
        localStorage.removeItem('user');
        localStorage.removeItem('token');
        this.isLoggedIn = false;
        this.user = null;
        
        this.$router.push('/');
      }
    }
  };
  </script>
  
  <style scoped>
.profile-view {
  background-color: rgb(209, 219, 225);
  min-height: 100vh;
  padding: 20px;
}

.container {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
}

.profile-box, .login-prompt {
  background: rgba(255, 255, 255, 0.95);
  padding: 40px;
  border-radius: 15px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 600px;
  transition: all 0.3s ease;
}

h1, h2 {
  margin-bottom: 30px;
  text-align: center;
  color: #333;
  font-weight: 300;
}

.profile-info {
  display: flex;
  margin-bottom: 30px;
}

.profile-avatar {
  margin-right: 30px;
  display: flex;
  align-items: center;
}

.avatar-circle {
  width: 80px;
  height: 80px;
  background-color: #858a91;
  border-radius: 50%;
  display: flex;
  align-items: center;
  justify-content: center;
}

.initials {
  font-size: 30px;
  color: white;
  font-weight: bold;
}

.profile-details {
  flex: 1;
}

.profile-field {
  margin-bottom: 20px;
}

.profile-field h3 {
  font-size: 14px;
  color: #666;
  margin-bottom: 5px;
}

.profile-field p {
  font-size: 16px;
  color: #333;
}

.btn-logout, .btn-login {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  border: none;
  cursor: pointer;
  font-size: 16px;
  display: block;
  width: fit-content;
  margin: 0 auto;
  text-decoration: none;
  text-align: center;
}

</style>