<template>
  <div class="basket-view">
    <h1>Kosár Tartalma</h1>
    <div class="total-price">
      <div class="top-buttons">
        <button @click="clearBasket" class="clear-button">Összes törlése</button>
        <router-link to="/" class="back-button">Vissza</router-link>
      </div>
      <div class="rental-controls">
        <button @click="promptRentalDays" class="rental-button">Bérlés napok megadása</button>
        <div class="rental-days">
          <button @click="decrementDays">-</button>
          <span>{{ rentalDays }} nap</span>
          <button @click="incrementDays">+</button>
        </div>
      </div>
      <div class="price-summary">
        <p>Napi ár összesen: {{ dailyTotal }} Ft</p>
        <h1>Végösszeg ({{ rentalDays }} napra): {{ totalPrice }} Ft</h1>
      </div>
      
      <!-- Rendelés leadása gomb bejelentkezett felhasználóknak -->
      <div class="order-section">
        <div v-if="isLoggedIn && basket.length > 0">
          <button @click="placeOrder" class="order-button">Rendelés leadása</button>
        </div>
        <div v-else-if="!isLoggedIn && basket.length > 0" class="login-notice">
          <p>A rendeléshez <router-link to="/login">jelentkezz be</router-link>!</p>
        </div>
      </div>

      <div v-if="basket.length > 0" style="margin-top: 15px;">
  <button @click="emergencyOrder" style="background-color: #fd7e14; color: white;">
    Vészhelyzeti rendelés (login nélkül)
  </button>
</div>
      
      <br>
      <br>
    </div>
    <div class="container">
      <div v-if="basket.length === 0">A kosár üres.</div>
      <div v-else>
        <!-- Display basket items here -->
        <div v-for="(item, index) in basket" :key="index" class="basket-item">
          <div class="item-details">
            <img v-if="item.image" :src="item.image" alt="Termék kép" class="product-image">
            <div class="item-info">
              <h3>{{ item.name }}</h3>
              <p>Ár: {{ item.price }} Ft</p>
              <p v-if="item.description">{{ item.description }}</p>
              <button @click="removeItem(index)" class="remove-button">Eltávolítás</button>
            </div>
          </div>
        </div>
      </div>
      <br>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

// Configure axios with a proper base URL and CSRF protection
axios.defaults.baseURL = 'http://localhost:8000'; // Adjust to your Laravel API URL
axios.defaults.withCredentials = false; // Set to false to avoid CORS issues with Laravel Sanctum

export default {
  name: 'BasketView',
  data() {
    return {
      basket: JSON.parse(localStorage.getItem('basket')) || [],
      orderInProgress: false,
      rentalDays: 1, // Default rental days
      isLoggedIn: false // We'll update this in created/mounted
    };
  },
  computed: {
    dailyTotal() {
      return this.basket.reduce((total, item) => total + (parseFloat(item.price) || 0), 0);
    },
    totalPrice() {
      return this.dailyTotal * this.rentalDays;
    }
    // Remove the isLoggedIn computed property and use data property instead
  },
  created() {
  // Do a manual check
  const token = localStorage.getItem('token');
  const user = localStorage.getItem('user');
  if (token && user) {
    console.log('Created hook: Setting login state to true');
    this.isLoggedIn = true;
  }
},
mounted() {
  // Double manual check
  const token = localStorage.getItem('token');
  const user = localStorage.getItem('user');
  if (token && user) {
    console.log('Mounted hook: Setting login state to true');
    this.isLoggedIn = true;
  }
  
  // Add event listener to recheck login when tab gets focus
  window.addEventListener('focus', this.checkLoginStatus);
},
  beforeDestroy() {
    // Remove event listener when component is destroyed
    window.removeEventListener('focus', this.checkLoginStatus);
  },
  methods: {
    checkLoginStatus() {
  const token = localStorage.getItem('token');
  const user = localStorage.getItem('user');
  
  console.log('Raw token value:', token);
  console.log('Raw user data:', user);
  
  try {
    // Better validation of token and user
    if (token && token.length > 10 && user && user.includes('{')) {
      this.isLoggedIn = true;
      console.log('VALID LOGIN DETECTED: User is logged in ✅');
    } else {
      this.isLoggedIn = false;
      console.log('Login check failed: Invalid token or user data ❌');
    }
  } catch (e) {
    console.error('Error checking login status:', e);
    this.isLoggedIn = false;
  }
},

  methods: {
  checkLoginStatus() {
    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user');
    
    console.log('Token:', token);
    console.log('User data:', user);
    
    if (token && user) {
      this.isLoggedIn = true;
      console.log('User is logged in ✅');
    } else {
      this.isLoggedIn = false;
      console.log('User is not logged in ❌');
    }
  },

  async emergencyOrder() {
  // This bypasses the login check
  if (this.basket.length === 0) {
    alert('A kosár üres!');
    return;
  }
  
  const confirmed = confirm('Ez a funkció login nélkül teszi lehetővé a rendelést. Biztos folytatja?');
  if (!confirmed) return;
  
  // The rest is similar to placeOrder but without login checks
  try {
    // Prepare the order data
    const orderData = {
      items: this.basket.map(item => ({
        product_id: item.id,
        quantity: 1,
        price: item.price,
        name: item.name
      })),
      rental_days: this.rentalDays,
      start_date: new Date().toISOString().slice(0, 10),
      end_date: this.getEndDate(this.rentalDays),
      total_price: this.totalPrice
    };
    
    // Send the order (without auth header)
    const response = await axios.post('http://localhost:8000/api/rendeles/direct', orderData, {
      headers: {
        'Content-Type': 'application/json',
        'Accept': 'application/json'
      }
    });
    
    alert('Sikeres rendelés!');
    this.clearBasket();
  } catch (error) {
    console.error('Emergency order error:', error);
    alert('Hiba történt a rendelés során.');
  }
},
  
  // Add debug method for testing
  debugLoginStatus() {
    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user');
    
    alert(`Login status: ${this.isLoggedIn ? 'Logged in' : 'Not logged in'}\n` +
          `Token exists: ${token ? 'Yes' : 'No'}\n` +
          `User data exists: ${user ? 'Yes' : 'No'}`);
  },
  
  // Rest of your methods...
  
  // Add debug method for testing
  debugLoginStatus() {
    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user');
    
    alert(`Login status: ${this.isLoggedIn ? 'Logged in' : 'Not logged in'}\n` +
          `Token exists: ${token ? 'Yes' : 'No'}\n` +
          `User data exists: ${user ? 'Yes' : 'No'}`);
  },
  
  // Rest of your methods...
    
    // Rest of your methods remain the same
    removeItem(index) {
      this.basket.splice(index, 1);
      localStorage.setItem('basket', JSON.stringify(this.basket));
    },
    
    clearBasket() {
      this.basket = [];
      localStorage.setItem('basket', JSON.stringify(this.basket));
    },
    
    promptRentalDays() {
      const days = prompt("Hány napra szeretné bérelni a termékeket?", this.rentalDays);
      const parsedDays = parseInt(days);
      if (!isNaN(parsedDays) && parsedDays > 0) {
        this.rentalDays = parsedDays;
      }
    },
    
    incrementDays() {
      this.rentalDays++;
    },
    
    decrementDays() {
      if (this.rentalDays > 1) {
        this.rentalDays--;
      }
    },
    
    getEndDate(days) {
      const date = new Date();
      date.setDate(date.getDate() + days - 1);
      return date.toISOString().slice(0, 10);
    },
    
    async placeOrder() {
      if (!this.isLoggedIn) {
        this.$router.push('/login');
        return;
      }
      
      if (this.basket.length === 0) {
        alert('A kosár üres!');
        return;
      }
      
      
      if (this.orderInProgress) {
        return; // Prevent multiple submissions
      }
      
      this.orderInProgress = true;
      
      try {
        // Get token from localStorage
        const token = localStorage.getItem('token');
        
        if (!token) {
          throw new Error('Nincs bejelentkezve! Kérjük jelentkezzen be újra.');
        }
        
        // Prepare the order data
        const orderData = {
  items: this.basket.map(item => ({
    product_id: item.id,
    quantity: 1, // You may need to add this if your API expects it
    price: item.price,
    name: item.name
  })),
  rental_days: this.rentalDays,
  start_date: new Date().toISOString().slice(0, 10),
  end_date: this.getEndDate(this.rentalDays),
  total_price: this.totalPrice
};

console.log('Sending order data:', orderData); // Add this for debugging
        
        // Send the order to the backend
        const response = await axios.post('http://localhost:8000/api/rendeles/direct', orderData, {
        headers: {
        'Authorization': `Bearer ${token}`,
        'Content-Type': 'application/json',
        'Accept': 'application/json'
         }
});
        
        // Handle successful order
        alert('Sikeres rendelés! Rendelési azonosító: ' + response.data.order_id);
        
        // Clear the basket after successful order
        this.clearBasket();
        
        // Redirect to confirmation or orders page
        this.$router.push('/confirmation');
      } catch (error) {
  console.error('Order placement error details:', error);
  
  let errorMessage = 'Hiba történt a rendelés során.';
  
  if (error.response) {
    // The server responded with a status code outside the 2xx range
    console.error('Error response status:', error.response.status);
    console.error('Error response data:', error.response.data);
    
    errorMessage = error.response.data.message || errorMessage;
  } else if (error.request) {
    // The request was made but no response was received
    console.error('No response received:', error.request);
    errorMessage = 'A szerver nem válaszolt. Kérjük próbálja újra később.';
  } else {
    // Something happened in setting up the request
    console.error('Request setup error:', error.message);
  }
  
  alert(errorMessage);
} finally {
  this.orderInProgress = false;
}
    }
  }
}};





</script>

<style scoped>
/* Add these new styles */
.order-section {
  margin: 20px 0;
}

.order-button {
  background-color: #4CAF50;
  color: white;
  font-weight: bold;
  padding: 0.8rem 1.5rem;
  border-radius: 0.25rem;
  text-decoration: none;
  border: none;
  cursor: pointer;
  font-size: 1.1rem;
  transition: background-color 0.3s;
}

.order-button:hover {
  background-color: #45a049;
}

.login-notice {
  margin: 20px 0;
  padding: 15px;
  background-color: #f8f9fa;
  border-radius: 8px;
  border: 1px solid #dee2e6;
}

.login-notice p {
  margin: 0;
  font-size: 1rem;
}

.login-notice a {
  color: #007bff;
  text-decoration: underline;
}
.basket-view {
  background-color: rgb(209, 219, 225);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  align-items: center;
  text-align: center;
  padding-top: 20px;
}

.basket-view h1 {
  color: #333;
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 20px;
}

.container {
  width: 100%;
  max-width: 1200px;
  background-color: white;
  border-radius: 15px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

.basket-item {
  border-bottom: 1px solid #ccc;
  padding: 10px 0;
}

.product-image {
  width: 100px;
  height: 100px;
  object-fit: cover;
  margin-bottom: 10px;
}

button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
  margin: 0.5rem; 
}

.back-button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
  margin: 0.5rem; 
}

.clear-button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
  margin: 0.5rem;
}

.rental-button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
  margin: 0.5rem;
}

.rental-days {
  display: flex;
  align-items: center;
}

.rental-days button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem;
  border-radius: 0.25rem;
  text-decoration: none;
  margin: 0.5rem;
}

.rental-days span {
  margin: 0 1rem;
}

.top-buttons {
  display: flex;
  justify-content: space-between;
  margin-bottom: 10px;
}

.rental-controls {
  margin-bottom: 10px;
}
</style>