<template>
  <div class="RegisterView">
    <div class="container">
      <div class="form-box">
        <h2>Személyes adatok</h2>
        <div v-if="message" :class="['alert', messageClass]">
          {{ message }}
        </div>
        <form @submit.prevent="saveData">
          <div class="form-group">
            <label for="lastname">Vezetéknév</label>
            <input type="text" v-model="lastname" id="lastname" required />
          </div>
          <div class="form-group">
            <label for="firstname">Keresztnév</label>
            <input type="text" v-model="firstname" id="firstname" required />
          </div>
          <div class="form-group">
            <label for="password">Jelszó</label>
            <input type="password" v-model="password" id="password" required />
          </div>
          <div class="form-group">
            <label for="confirmPassword">Jelszó újra</label>
            <input type="password" v-model="confirmPassword" id="confirmPassword" required />
          </div>
          <div class="form-group">
            <label for="email">E-mail</label>
            <input type="email" v-model="email" id="email" required />
          </div>
          <div class="form-group">
            <label for="phone">Telefonszám</label>
            <input type="tel" v-model="phone" id="phone" required />
          </div>
          <div class="form-group">
            <button class="btn" type="submit" :disabled="isSubmitting">
              {{ isSubmitting ? 'Feldolgozás...' : 'Mentés' }}
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
      lastname: '',
      firstname: '',
      password: '',
      confirmPassword: '',
      email: '',
      phone: '',
      message: '',
      messageClass: '',
      isSubmitting: false
    };
  },
  methods: {
    async saveData() {
  if (this.password !== this.confirmPassword) {
    this.message = 'A jelszavak nem egyeznek!';
    this.messageClass = 'alert-danger';
    return;
  }

  this.isSubmitting = true;
  this.message = '';
  
  try {
    const response = await axios.post('http://localhost:8000/api/register', {
      vezeteknev: this.lastname,
      keresztnev: this.firstname,
      jelszo: this.password,
      email: this.email,
      telefonszam: this.phone
    }, { 
      withCredentials: false,
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    });
    
    console.log('Registration successful:', response.data);
    
    this.message = 'Sikeres regisztráció!';
    this.messageClass = 'alert-success';
    
    this.lastname = '';
    this.firstname = '';
    this.password = '';
    this.confirmPassword = '';
    this.email = '';
    this.phone = '';
    
    setTimeout(() => {
      this.$router.push('/login');
    }, 2000);
    
  } catch (error) {
    console.error('Full error object:', error);
    
    let errorMessage = 'Hiba történt a regisztráció során!';
    
    if (error.response) {
      console.error('Error response data:', error.response.data);
      console.error('Error status:', error.response.status);
      
      if (error.response.data && error.response.data.errors) {
        const validationErrors = Object.values(error.response.data.errors)
          .flat()
          .join(', ');
        errorMessage = validationErrors;
      } else if (error.response.data && error.response.data.message) {
        errorMessage = error.response.data.message;
      }
    } else if (error.request) {
      console.error('No response received:', error.request);
      errorMessage = 'A szerver nem válaszol. Ellenőrizze az internetkapcsolatot.';
    } else {
      console.error('Request setup error:', error.message);
    }
    
    this.message = errorMessage;
    this.messageClass = 'alert-danger';
  } finally {
    this.isSubmitting = false;
  }
}
  }
};
</script>

<style scoped>
.RegisterView {
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
  border-color: #858a91;
  box-shadow: 0 0 10px rgba(133, 138, 145, 0.3);
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

.btn:disabled {
  background: #ccc;
  cursor: not-allowed;
}

.alert {
  padding: 12px 15px;
  border-radius: 10px;
  margin-bottom: 20px;
  width: 100%;
  max-width: 400px;
  text-align: center;
}

.alert-success {
  background-color: #d4edda;
  color: #155724;
  border: 1px solid #c3e6cb;
}

.alert-danger {
  background-color: #f8d7da;
  color: #721c24;
  border: 1px solid #f5c6cb;
}
</style>