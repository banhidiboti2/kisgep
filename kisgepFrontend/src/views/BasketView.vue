<template>
  <div class="basket-view">
    <div class="container">
      <h1>Kosár</h1>
      
      <div v-if="basket.length === 0" class="empty-basket">
        <p>A kosár üres.</p>
        <router-link to="/" class="back-button">Vissza a főoldalra</router-link>
      </div>
      
      <div v-else>
        <div class="basket-items">
          <div v-for="(item, index) in basket" :key="index" class="basket-item">
            <div class="item-image-container">
              <img :src="item.image" alt="Termék kép" class="product-image">
            </div>
            <div class="item-details">
              <h3>{{ item.name }}</h3>
              <p>{{ item.description }}</p>
              <p class="item-price">{{ item.price }} Ft / nap</p>
            </div>
            <button @click="removeItem(index)" class="delete-button">
              Törlés
            </button>
          </div>
        </div>
        
        <div class="order-section">
          <h2>Bérlés időtartama</h2>
          <div class="rental-days">
            <button @click="decrementDays">-</button>
            <span>{{ rentalDays }} nap</span>
            <button @click="incrementDays">+</button>
          </div>
        </div>
        
        <div class="order-section">
          <h2>Megjegyzés a rendeléshez</h2>
          <textarea 
            v-model="orderComment" 
            placeholder="Itt adhat meg megjegyzést a rendeléshez (opcionális)..."
            class="order-comment"
            rows="3"
          ></textarea>
        </div>
        
        <div class="order-section">
          <h2>Rendelési adatok</h2>
          
          <div class="form-group">
            <label for="email">E-mail cím*</label>
            <input 
              type="email" 
              id="email" 
              v-model="orderEmail" 
              class="order-input" 
              placeholder="Az Ön e-mail címe" 
              required
            />
          </div>
          
          <div class="form-group">
            <label for="orderComment">Megjegyzés (opcionális)</label>
            <textarea 
              id="orderComment"
              v-model="orderComment" 
              class="order-comment" 
              rows="3" 
              placeholder="Itt adhat meg megjegyzést a rendeléshez..."
            ></textarea>
          </div>
        </div>
        
        <div class="order-section">
          <h2>Rendelés összegzése</h2>
          <div class="order-summary">
            <div class="summary-row">
              <span>Napi díj:</span>
              <span>{{ dailyTotal }} Ft</span>
            </div>
            <div class="summary-row">
              <span>Napok száma:</span>
              <span>{{ rentalDays }}</span>
            </div>
            <div class="summary-row">
              <span>Részösszeg:</span>
              <span>{{ subtotalPrice }} Ft</span>
            </div>
            <div class="summary-row">
              <span>Kaució:</span>
              <span>{{ depositAmount }} Ft</span>
            </div>
            <div class="summary-row total">
              <span>Végösszeg:</span>
              <span>{{ totalPrice }} Ft</span>
            </div>
          </div>
        </div>
        
        <div class="top-buttons">
          <button @click="clearBasket" class="clear-button">Kosár ürítése</button>
          <div>
            <button v-if="isLoggedIn" @click="placeOrder" :disabled="orderInProgress" class="order-button">
              {{ orderInProgress ? 'Feldolgozás...' : 'Megrendelés' }}
            </button>
            <button v-else @click="emergencyOrder" class="order-button emergency">
              Gyors megrendelés
            </button>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from 'axios';

axios.defaults.baseURL = 'http://localhost:8000';
axios.defaults.withCredentials = false;

export default {
  name: 'BasketView',
  data() {
    return {
      basket: JSON.parse(localStorage.getItem('basket')) || [],
      orderInProgress: false,
      rentalDays: 1,
      isLoggedIn: false,
      depositAmount: 50000,
      orderComment: '',
      orderEmail: '' // Új adat a rendelési e-mailhez
    };
  },
  computed: {
    dailyTotal() {
      return this.basket.reduce((total, item) => total + (parseFloat(item.price) || 0), 0);
    },
    subtotalPrice() {
      return this.dailyTotal * this.rentalDays;
    },
    totalPrice() {
      return this.subtotalPrice + this.depositAmount;
    }
  },
  created() {
    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user');
    if (token && user) {
      console.log('Created hook: Setting login state to true');
      this.isLoggedIn = true;
    }

    // Ha be van jelentkezve a felhasználó, automatikusan betöltjük az e-mail címét
    const userData = localStorage.getItem('user');
    if (userData) {
      try {
        const user = JSON.parse(userData);
        if (user.email) {
          this.orderEmail = user.email;
        }
      } catch (e) {
        console.error('User data parsing error:', e);
      }
    }
  },
  mounted() {
    const token = localStorage.getItem('token');
    const user = localStorage.getItem('user');
    if (token && user) {
      console.log('Mounted hook: Setting login state to true');
      this.isLoggedIn = true;
    }
    
    window.addEventListener('focus', this.checkLoginStatus);
  },
  beforeDestroy() {
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

    generateOrderIdentifier() {
      // 6 jegyű szám generálása (100000-999999 között)
      return Math.floor(100000 + Math.random() * 900000).toString();
    },
    
    debugLoginStatus() {
      const token = localStorage.getItem('token');
      const user = localStorage.getItem('user');
      
      alert(`Login status: ${this.isLoggedIn ? 'Logged in' : 'Not logged in'}\n` +
            `Token exists: ${token ? 'Yes' : 'No'}\n` +
            `User data exists: ${user ? 'Yes' : 'No'}`);
    },
    
    async emergencyOrder() {
      if (this.basket.length === 0) {
        alert('A kosár üres!');
        return;
      }
      
      // E-mail cím ellenőrzése
      if (!this.orderEmail || !this.validateEmail(this.orderEmail)) {
        alert('Kérjük, adjon meg egy érvényes e-mail címet!');
        return;
      }
      
      // Felhasználói adatok kinyerése a localStorage-ból vendég rendelés esetén is
      const userData = localStorage.getItem('user');
      let userId = null;
      
      if (userData) {
        try {
          const user = JSON.parse(userData);
          userId = user.id;
        } catch (e) {
          console.error('User data parsing error:', e);
        }
      }
      
      try {
        // Rendelésazonosító generálása
        const orderIdentifier = this.generateOrderIdentifier();
        
        const orderData = {
          // Megjegyzés mező hozzáadása a user input alapján
          megjegyzes: this.orderComment,
          email: this.orderEmail, // E-mail küldése a backendnek
          
          // Kosár elemek a megfelelő szerkezetben
          basket_items: this.basket.map(item => ({
            termek_id: item.id,
            mennyiseg: 1,
            kezdo_datum: new Date().toISOString().slice(0, 10),
            vegso_datum: this.getEndDate(this.rentalDays)
          })),
          
          // Egyéb adatok
          total_price: this.totalPrice,
          deposit_amount: this.depositAmount,
          rendeles_azonosito: orderIdentifier,
          // Explicit felhasználói ID átadása, ha be van jelentkezve
          user_id: userId,
          is_guest: userId === null
        };
        
        const response = await axios.post('http://localhost:8000/api/rendeles/direct', orderData, {
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json'
          }
        });
        
        // Mentjük a rendelésazonosítót localStorage-ba
        const finalOrderId = response.data?.rendeles_azonosito || orderIdentifier;
        localStorage.setItem('lastOrderId', finalOrderId);
        
        // Kosár ürítése
        this.clearBasket();
        
        // Átirányítás a megerősítő oldalra alert helyett
        this.$router.push('/order-confirmation');
      } catch (error) {
        console.error('Emergency order error:', error);
        alert('Hiba történt a rendelés során: ' + (error.response?.data?.message || error.message));
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
    placeOrder() {
      if (this.basket.length === 0) {
        alert('A kosár üres!');
        return;
      }
      
      const token = localStorage.getItem('token');
      let userId = null;
      let userEmail = this.orderEmail;

      if (token) {
        try {
          const userData = JSON.parse(localStorage.getItem('user') || '{}');
          if (userData.id) {
            userId = userData.id;
          }
        } catch (e) {
          console.error('User parsing error:', e);
        }
      }

      this.orderInProgress = true;
      
      const orderIdentifier = this.generateOrderIdentifier();
      
      const orderData = {
        megjegyzes: this.orderComment,
        email: userEmail,
        
        basket_items: this.basket.map(item => ({
          termek_id: item.id,
          mennyiseg: 1,
          kezdo_datum: new Date().toISOString().slice(0, 10),
          vegso_datum: this.getEndDate(this.rentalDays)
        })),
        
        total_price: this.totalPrice,
        deposit_amount: this.depositAmount,
        rendeles_azonosito: orderIdentifier,
        user_id: userId
      };
      
      axios.post('http://localhost:8000/api/rendeles/direct', orderData, {
        headers: {
          'Content-Type': 'application/json',
          'Accept': 'application/json',
          'Authorization': `Bearer ${token}`
        }
      })
      .then(response => {
        console.log('Order response:', response.data);
        const finalOrderId = response.data.rendeles_azonosito || orderIdentifier;
        localStorage.setItem('lastOrderId', finalOrderId);
        
        this.clearBasket();
        this.orderInProgress = false;
        
        this.$router.push('/order-confirmation');
      })
      .catch(error => {
        console.error('Order error:', error);
        alert('Hiba történt a rendelés során: ' + (error.response?.data?.message || error.message));
        this.orderInProgress = false;
      });
    },
    
    validateEmail(email) {
      const re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      return re.test(email);
    }
  }
};

</script>

<style scoped>
.basket-view {
  background-color: rgb(209, 219, 225);
  min-height: 100vh;
  display: flex;
  flex-direction: column;
  align-items: center;
  padding: 20px;
}

.container {
  width: 100%;
  max-width: 1200px;
  background-color: white;
  border-radius: 15px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  padding: 20px;
}

h1 {
  color: #333;
  font-size: 2rem;
  font-weight: bold;
  margin-bottom: 20px;
  text-align: center;
}

h2 {
  font-weight: 600;
  margin-bottom: 10px;
}

.empty-basket {
  text-align: center;
  padding: 30px 0;
}

.basket-items {
  margin-bottom: 20px;
}

.basket-item {
  display: flex;
  align-items: center;
  padding: 15px 0;
  border-bottom: 1px solid #e2e8f0;
}

.item-image-container {
  width: 80px;
  height: 80px;
  flex-shrink: 0;
}

.product-image {
  width: 100%;
  height: 100%;
  object-fit: contain;
}

.item-details {
  flex-grow: 1;
  margin-left: 15px;
}

.item-details h3 {
  font-weight: 600;
  margin-bottom: 5px;
}

.item-price {
  color: #4a5568;
}

.order-section {
  background-color: #f8fafc;
  border-radius: 8px;
  padding: 15px;
  margin-bottom: 15px;
}

.order-summary {
  width: 100%;
}

.summary-row {
  display: flex;
  justify-content: space-between;
  margin-bottom: 8px;
}

.total {
  font-weight: bold;
  font-size: 1.2rem;
  margin-top: 10px;
  padding-top: 10px;
  border-top: 1px solid #e2e8f0;
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
  border: none;
  cursor: pointer;
  margin: 0 8px;
}

.rental-days span {
  margin: 0 15px;
  font-size: 1.1rem;
}

.top-buttons {
  display: flex;
  justify-content: space-between;
  margin-top: 20px;
}

button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  border: none;
  cursor: pointer;
}

.back-button, .clear-button, .rental-button, .delete-button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
}

.delete-button {
  color: #e53e3e;
  background: transparent;
}

.order-button {
  background-color: #4CAF50;
  color: white;
  font-weight: bold;
  padding: 0.8rem 1.5rem;
  font-size: 1.1rem;
}



.order-button:hover {
  opacity: 0.9;
}

.order-button:disabled {
  background-color: #9ca3af;
  cursor: not-allowed;
}

.order-comment {
  width: 100%;
  padding: 10px;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  font-family: inherit;
  font-size: 1rem;
  resize: vertical;
  margin-top: 8px;
}

.order-comment:focus {
  outline: none;
  border-color: #858a91;
  box-shadow: 0 0 5px rgba(133, 138, 145, 0.3);
}

.form-group {
  margin-bottom: 15px;
}

label {
  display: block;
  margin-bottom: 5px;
  font-weight: 500;
}

.order-input {
  width: 100%;
  padding: 10px;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  font-family: inherit;
  font-size: 1rem;
}

.order-input:focus,
.order-comment:focus {
  outline: none;
  border-color: #858a91;
  box-shadow: 0 0 5px rgba(133, 138, 145, 0.3);
}
</style>