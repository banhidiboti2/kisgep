<template>
  <div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Kosár</h1>
    
    <div v-if="basket.length === 0" class="text-center py-8">
      <p>A kosár üres.</p>
      <router-link to="/" class="inline-block mt-4 px-4 py-2 bg-gray-200 rounded">Vissza a főoldalra</router-link>
    </div>
    
    <div v-else>
      <!-- Items in the basket -->
      <div class="bg-white rounded shadow-md p-4 mb-4">
        <div v-for="(item, index) in basket" :key="index" class="border-b py-4 flex items-center">
          <div class="w-20 h-20 flex-shrink-0">
            <img :src="item.image" alt="Termék kép" class="w-full h-full object-contain">
          </div>
          <div class="ml-4 flex-grow">
            <h3 class="font-semibold">{{ item.name }}</h3>
            <p>{{ item.description }}</p>
            <p class="text-gray-700">{{ item.price }} Ft / nap</p>
          </div>
          <button @click="removeItem(index)" class="ml-4 text-red-500">
            Törlés
          </button>
        </div>
      </div>
      
      <!-- Rental days selector -->
      <div class="bg-white rounded shadow-md p-4 mb-4">
        <h2 class="font-semibold mb-2">Bérlés időtartama</h2>
        <div class="flex items-center">
          <button @click="decrementDays" class="px-3 py-1 border rounded">-</button>
          <span class="mx-4">{{ rentalDays }} nap</span>
          <button @click="incrementDays" class="px-3 py-1 border rounded">+</button>
          <button @click="promptRentalDays" class="ml-4 text-blue-500">Egyedi</button>
        </div>
      </div>
      
      <!-- Order summary -->
      <div class="bg-white rounded shadow-md p-4 mb-4">
        <h2 class="font-semibold mb-2">Rendelés összegzése</h2>
        <div class="flex justify-between mb-2">
          <span>Napi díj:</span>
          <span>{{ dailyTotal }} Ft</span>
        </div>
        <div class="flex justify-between mb-2">
          <span>Napok száma:</span>
          <span>{{ rentalDays }}</span>
        </div>
        <div class="flex justify-between font-bold text-lg">
          <span>Végösszeg:</span>
          <span>{{ totalPrice }} Ft</span>
        </div>
      </div>
      
      <!-- Action buttons -->
      <div class="flex justify-between">
        <button @click="clearBasket" class="px-4 py-2 bg-gray-300 rounded">Kosár ürítése</button>
        <div>
          <button v-if="isLoggedIn" @click="placeOrder" :disabled="orderInProgress" class="px-4 py-2 bg-green-500 text-white rounded mr-2">
            {{ orderInProgress ? 'Feldolgozás...' : 'Megrendelés' }}
          </button>
          <button v-else @click="emergencyOrder" class="px-4 py-2 bg-yellow-500 text-white rounded">
            Gyors megrendelés
          </button>
        </div>
      </div>
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
    
    // Debug method for testing
    debugLoginStatus() {
      const token = localStorage.getItem('token');
      const user = localStorage.getItem('user');
      
      alert(`Login status: ${this.isLoggedIn ? 'Logged in' : 'Not logged in'}\n` +
            `Token exists: ${token ? 'Yes' : 'No'}\n` +
            `User data exists: ${user ? 'Yes' : 'No'}`);
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
      // ... your existing placeOrder method code ...
    }
  }
};
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