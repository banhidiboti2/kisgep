<template>
  <div class="LoginView">
    <div class="container">
      <div class="form-box">
        <h2>Bejelentkezés</h2>
        <div v-if="message" :class="['alert', messageClass]">
          {{ message }}
        </div>
        <form @submit.prevent="login">
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" v-model="email" id="email" required />
          </div>
          <div class="form-group">
            <label for="password">Jelszó</label>
            <input type="password" v-model="password" id="password" required />
          </div>
          <div class="form-group button-group">
            <button class="btn" type="submit" :disabled="isSubmitting">
              {{ isSubmitting ? 'Bejelentkezés...' : 'Bejelentkezés' }}
            </button>
          </div>
        </form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

export default {
  data() {
    return {
      email: '',
      password: '',
      message: '',
      messageClass: '',
      isSubmitting: false
    };
  },
  methods: {
    async login() {
      this.isSubmitting = true;
      this.message = '';
      
      try {
  const response = await axios.post('http://localhost:8000/api/login', {
    email: this.email,
    jelszo: this.password
  }, {
    withCredentials: false,
    headers: {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    }
  });
        
        localStorage.setItem('token', response.data.token);
        localStorage.setItem('user', JSON.stringify(response.data.user));
        
        this.message = 'Sikeres bejelentkezés!';
        this.messageClass = 'alert-success';
        
        setTimeout(() => {
          this.$router.push('/');
        }, 1000);
        
      } catch (error) {
        console.error('Login error:', error);
        this.message = error.response?.data?.message || 'Hibás email vagy jelszó!';
        this.messageClass = 'alert-danger';
      } finally {
        this.isSubmitting = false;
      }
    }
  }
};
</script>

<style scoped>
.LoginView {
  background-color: rgb(209, 219, 225);
  min-height: 100vh;
}

.container {
  display: flex;
  align-items: center;
  justify-content: center;
  width: 100%;
}

.form-box {
  background: rgba(255, 255, 255, 0.95);
  padding: 40px;
  border-radius: 15px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  width: 100%;
  max-width: 500px;
  transition: all 0.3s ease;
}

.form-box h2 {
  margin-bottom: 30px;
  text-align: center;
  color: #333;
  font-weight: 300;
}

.form-group {
  margin-bottom: 25px;
  display: flex;
  flex-direction: column;
  align-items: center;
}

.form-group label {
  display: block;
  margin-bottom: 8px;
  color: #666;
  font-size: 14px;
  transition: color 0.3s ease;
}

.form-group input {
  width: 100%;
  max-width: 400px;
  padding: 12px 15px;
  border: 1px solid #ddd;
  border-radius: 10px;
  outline: none;
  transition: border-color 0.3s ease, box-shadow 0.3s ease;
  font-size: 15px;
}

.form-group input:focus {
  border-color: #f1c40f;
  box-shadow: 0 0 10px rgba(241, 196, 15, 0.3);
}

.button-group {
  display: flex;
  justify-content: center;
  width: 100%;
}

.btn {
  width: 100%;
  max-width: 400px;
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  border: none;
  cursor: pointer;
  text-decoration: none;
  margin-top: auto;
  font-size: 16px;
}
</style>