<template>
  <div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Építőipari Gépek</h1>
      <router-link to="/" class="back-button">Vissza</router-link>
    </div>

    <div v-if="loading" class="text-center py-8">
      <p>Betöltés...</p>
    </div>

    <div v-else-if="error" class="text-center py-8 text-red-600">
      <p>{{ error }}</p>
    </div>

    <div v-else class="grid grid-cols-3 gap-4">
      <div v-for="(item, index) in items" :key="index" class="product-container bg-white rounded shadow hover:shadow-md transition-shadow">
        <div class="product-inner border border-gray-300 p-4 text-center h-full flex flex-col">
          <div class="img-wrapper">
            <img :src="item.image_url || getDefaultImage(item.name || item.nev)" alt="Gép" class="product-image">
          </div>
          <div class="product-details">
            <p class="font-semibold">{{ item.name || item.nev }}</p>
            <p>{{ item.description || item.leiras }}</p>
            <p>Ár: {{ item.price || item.ar }} Ft</p>
          </div>
          <button @click="addToBasket(item)" class="button mt-auto">Kosárba</button>
        </div>
      </div>
    </div>
  </div>
</template>
  
<script>
import sarokcsiszolo from '@/photos/sarokcsiszolo.png';
import furogep from '@/photos/furogep.png';
import vesogep from '@/photos/vesogep.png';
import betonkevero from '@/photos/betonkevero.png';
import lezeres from '@/photos/lezeres.png';
import holegfuvo from '@/photos/holegfuvo.png';
import magasnyomasu from '@/photos/magasnyomasu.png';
import koszoru from '@/photos/koszoru.png';
import korfuresz from '@/photos/korfuresz.png';
import kompresszor from '@/photos/kompresszor.png';
import gervago from '@/photos/gervago.png';
import aszfaltvago from '@/photos/aszfaltvago.png';

import axios from 'axios';

export default {
  name: 'ConstructionView',
  data() {
    return {
      items: [],
      basket: JSON.parse(localStorage.getItem('basket')) || [],
      loading: true,
      error: null,
      defaultImages: {
        'Sarokcsiszoló': sarokcsiszolo,
        'Fúrógép': furogep,
        'Vésőgép': vesogep,
        'Betonkeverő': betonkevero,
        'Lézeres Szintező': lezeres,
        'Hőlégfúvó': holegfuvo,
        'Magasnyomású Mosó': magasnyomasu,
        'Köszörű': koszoru,
        'Körfűrész': korfuresz,
        'Kompresszor': kompresszor,
        'Gérvágó': gervago,
        'Aszfaltvágó': aszfaltvago
      }
    };
  },
  methods: {
    addToBasket(item) {
    // Create a copy of the item with consistent property names and add image
    const basketItem = {
      id: item.id,
      name: item.name || item.nev,
      description: item.description || item.leiras,
      price: item.price || item.ar,
      image: item.image_url || this.getDefaultImage(item.name || item.nev)
    };
    
    this.basket.push(basketItem);
    localStorage.setItem('basket', JSON.stringify(this.basket));
    
    // Show confirmation to user
    alert('Termék hozzáadva a kosárhoz!');
  },
    
  fetchProducts() {
  this.loading = true;
  this.error = null;
  
  axios.get('http://127.0.0.1:8000/api/termekek', { withCredentials: false })
    .then(response => {
      console.log('API Response:', response.data);
      // Check if data is an array and maintain the specific slice for construction products (24-36)
      if (Array.isArray(response.data)) {
        this.items = response.data.slice(24, 36);
      } else if (response.data.data && Array.isArray(response.data.data)) {
        // Handle wrapped data format if needed
        this.items = response.data.data.slice(24, 36);
      } else {
        console.error('Unexpected data format:', response.data);
        this.error = 'Váratlan adatformátum az API válaszában';
      }
      this.loading = false;
    })
    .catch(error => {
      console.error('Error fetching products:', error);
      this.error = 'Hiba történt a termékek betöltése közben. Kérjük, próbálja újra később.';
      this.loading = false;
    });
},
    
    getDefaultImage(name) {
      // Return default image based on product name or a generic default
      return this.defaultImages[name] || this.defaultImages['Sarokcsiszoló'];
    }
  },
  
  created() {
    this.fetchProducts();
  }
};
</script>
  
<style scoped>
.product-container {
  transition: transform 0.2s;
}

.product-inner {
  display: flex;
  flex-direction: column;
}

.product-container:hover {
  transform: translateY(-5px);
}

.img-wrapper {
  height: 200px;
  display: flex;
  align-items: center;
  justify-content: center;
  margin-bottom: 10px;
}

.product-image {
  max-width: 100%;
  max-height: 100%;
  object-fit: contain;
}

.product-details {
  flex: 1;
  display: flex;
  flex-direction: column;
  justify-content: flex-start;
  margin-bottom: 10px;
}

.container {
  max-width: 1200px;
  margin: 0 auto;
}

.grid {
  display: grid;
}

.grid-cols-3 {
  grid-template-columns: repeat(3, 1fr);
}

.gap-4 {
  gap: 1rem;
}

.back-button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
  margin-left: auto; 
}

.button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
  margin-top: auto;
}
</style>