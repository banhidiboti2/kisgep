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
          <span>{{ rentalDays }}</span>
          <button @click="incrementDays">+</button>
        </div>
      </div>
      <h1>Végösszeg: {{ totalPrice }} Ft</h1>
      <br>
      <br>
    </div>
    <div class="container">
      <div v-if="basket.length === 0">A kosár üres.</div>
      <div v-else>
        <div v-for="(item, index) in basket" :key="index" class="basket-item">
          <img :src="item.image" alt="Gép" class="product-image">
          <p class="font-semibold">{{ item.name }}</p>
          <p>{{ item.description }}</p>
          <p>Ár: {{ item.price }} Ft</p>
          <button @click="removeItem(index)">Törlés</button>
        </div>
      </div>
      <br>
    </div>
  </div>
</template>

<script>
export default {
  name: 'BasketView',
  data() {
    return {
      basket: JSON.parse(localStorage.getItem('basket')) || [],
      rentalDays: 1
    };
  },
  computed: {
    totalPrice() {
      return this.basket.reduce((total, item) => total + item.price, 0) * this.rentalDays;
    }
  },
  methods: {
    removeItem(index) {
      this.basket.splice(index, 1);
      localStorage.setItem('basket', JSON.stringify(this.basket));
    },
    clearBasket() {
      this.basket = [];
      localStorage.setItem('basket', JSON.stringify(this.basket));
    },
    promptRentalDays() {

    },
    incrementDays() {
      this.rentalDays++;
    },
    decrementDays() {
      if (this.rentalDays > 1) {
        this.rentalDays--;
      }
    }
  }
};
</script>

<style scoped>
.clear-button, .rental-button {
  margin-top: 10px;
  padding: 10px;
  background-color: red;
  color: white;
  border: none;
  cursor: pointer;
}
</style>

<style scoped>
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