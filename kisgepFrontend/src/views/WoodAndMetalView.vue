<template>
  <div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Kerti Gépek</h1>
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
            <img :src="getProductImage(item)" alt="Gép" class="product-image">
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
import dekopir from '@/photos/dekopirfuresz.png';
import asztalifuresz from '@/photos/asztali.png';
import gyalu from '@/photos/gyalu.png';
import marogep from '@/photos/felsomaro.png';
import szalag from '@/photos/szalag.png';
import csiszolo from '@/photos/rezgocsiszolo.png';
import egyenes from '@/photos/egyenescsiszolo.png';
import oszlopos from '@/photos/oszlopos.png';
import plazma from '@/photos/plazmavago.png';
import hegeszto from '@/photos/hegeszto.png';
import lemez from '@/photos/lemezvago.png';
import eszterga from '@/photos/eszterga.png';

import axios from 'axios';

export default {
  name: 'GardenView',
  data() {
  return {
    items: [],
    basket: JSON.parse(localStorage.getItem('basket')) || [],
    loading: true,
    error: null,
    fetchedData: false, // Add this flag
    defaultImages: {
        'Dekopírfűrész': dekopir,
        'Asztali Körfűrész': asztalifuresz,
        'Gyalu': gyalu,
        'Felső Marógép': marogep,
        'Szalagfűrész': szalag,
        'Rezgőcsiszoló': csiszolo,
        'Egyenes Csiszoló': egyenes,
        'Oszlopos Fúró': oszlopos,
        'Plazmavágó': plazma,
        'Hegesztő': hegeszto,
        'Lemezvágó': lemez,
        'Eszterga': eszterga
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
      image: item.image_url || this.getProductImage(item)
    };
    
    this.basket.push(basketItem);
    localStorage.setItem('basket', JSON.stringify(this.basket));
    
    // Show confirmation to user
    alert('Termék hozzáadva a kosárhoz!');
  },

  fetchProducts() {
  if (this.fetchedData) return; // Prevent duplicate calls
  
  this.loading = true;
  this.error = null;

  axios.get('http://127.0.0.1:8000/api/termekek', { withCredentials: false })
    .then(response => {
      console.log('API Response:', response.data);
      this.items = Array.isArray(response.data) ? response.data : [];
      this.loading = false;
      this.fetchedData = true; // Set the flag
    })
    .catch(error => {
      // ...error handling
    });
},

    getProductImage(item) {
      if (item.image_url) {
        return item.image_url;
      }

      const name = item.name || item.nev;

      if (name && this.defaultImages[name]) {
        return this.defaultImages[name];
      }

      for (const key in this.defaultImages) {
        if (name && name.includes(key)) {
          return this.defaultImages[key];
        }
      }

      return dekopir; // fallback
    },
  },

  created() {
    this.fetchProducts();
  }
};

</script>
  
<style scoped>
/* All styles remain the same */
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