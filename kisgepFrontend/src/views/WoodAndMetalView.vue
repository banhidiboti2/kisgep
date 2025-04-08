<template>
  <div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Kerti Gépek</h1>
      <router-link to="/" class="back-button">Vissza</router-link>
    </div>

    <div class="grid grid-cols-3 gap-4">
      <div v-for="(item, index) in items" :key="index" class="product-container bg-white rounded shadow hover:shadow-md transition-shadow">
        <div class="product-inner border border-gray-300 p-4 text-center h-full flex flex-col">
          <div class="img-wrapper">
            <img :src="item.image" alt="Gép" class="product-image">
          </div>
          <div class="product-details">
            <p class="font-semibold">{{ item.name }}</p>
            <p>{{ item.description }}</p>
            <p>Ár: {{ item.price }} Ft</p>
          </div>
          <button @click="addToBasket(item)" class="button mt-auto">Kosárba</button>
        </div>
      </div>
    </div>
  </div>
</template>
  
  <script>
 import dekopir from '@/photos/dekopirfuresz.png';
import asztali from '@/photos/asztali.png';
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
  name: 'WoodAndMetalView',
  data() {
    return {
      items: [
        {
          image: dekopir,
          name: 'Dekopírfűrész',
          description: 'Gyártó: Makita',
          price: 2000
        },
        {
          image: asztali,
          name: 'Asztali Körfűrész',
          description: 'Gyártó: Belle',
          price: 8000

        },
        {
          image: gyalu,
          name: 'Gyalu',
          description: 'Gyártó: Makita',
          price: 6000

        },
        {
          image: marogep,
          name: 'Felső Marógép',
          description: 'Gyártó: Bosch',
          price: 3000

        },
        {
          image: szalag,
          name: 'Szalagfűrész',
          description: 'Gyártó: Elektro',
          price: 5000

        },
        {
          image: csiszolo,
          name: 'Rezgőcsiszoló',
          description: 'Gyártó: JCB',
          price: 3000

        },
        {
          image: egyenes,
          name: 'Egyenes Csiszoló',
          description: 'Gyártó: Bosch',
          price: 4000
        },
        {
          image: oszlopos,
          name: 'Oszlopos Fúrógép',
          description: 'Gyártó: Dake',
          price: 5000
        },
        {
          image: plazma,
          name: 'Plazmavágó',
          description: 'Gyártó: Swift',
          price: 7000
        },
        {
          image: hegeszto,
          name: 'Hegesztőgép',
          description: 'Gyártó: Invertec',
          price: 12000
        },
        {
          image: lemez,
          name: 'Lemezvágó',
          description: 'Gyártó: Extol',
          price: 1000
        },
        {
          image: eszterga,
          name: 'Esztergagép',
          description: 'Gyártó: Hungsam',
          price: 25000
        },
        ],
        basket: JSON.parse(localStorage.getItem('basket')) || []
      };
    },
    methods: {
    addToBasket(item) {
      this.basket.push(item);
      localStorage.setItem('basket', JSON.stringify(this.basket));
    },
    /*
    fetchProducts() {
      axios.get('/termekek')
        .then(response => {
          this.items = response.data;
        })
        .catch(error => {
          console.error('Error fetching products:', error);
        });
    },
      */
  },
  /*
  created() {
    this.fetchProducts();
  }
  */
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