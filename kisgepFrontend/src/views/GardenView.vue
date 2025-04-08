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
import fuyniro from '@/photos/funyiro.png';
import fukasza from '@/photos/fukasza.png';
import lombfuvo from '@/photos/lombfuvo.png';
import ronkhasito from '@/photos/ronkhasito.png';
import sovenynyiro from '@/photos/sovenynyiro.png';
import agaprito from '@/photos/agaprito.png';
import permetezo from '@/photos/permetezo.png';
import talajfuro from '@/photos/talajfuro.png';
import szivattyu from '@/photos/szivattyu.png';
import gyepszellozteto from '@/photos/gyep.png';
import magassagi from '@/photos/magassagi.png';
import tuskomaro from '@/photos/tuskomaro.png';

import axios from 'axios';

export default {
  name: 'GardenView',
  data() {
    return {
      items: [
        {
          image: fuyniro,
          name: 'Fűnyíró',
          description: 'Gyártó: Atlas',
          price: 6000
        },
        {
          image: fukasza,
          name: 'Fűkasza',
          description: 'Gyártó: Stihl',
          price: 5000
        },
        {
          image: lombfuvo,
          name: 'Lombfúvó',
          description: 'Gyártó: Stihl',
          price: 3000
        },
        {
          image: ronkhasito,
          name: 'Rönkhasító',
          description: 'Gyártó: Cub Cadet',
          price: 15000
        },
        {
          image: sovenynyiro,
          name: 'Sövénynyíró',
          description: 'Gyártó: Ryobi',
          price: 3000
        },
        {
          image: agaprito,
          name: 'Ágaprító',
          description: 'Gyártó: Cub Cadet',
          price: 4000
        },
        {
          image: permetezo,
          name: 'Permetező',
          description: 'Gyártó: Firman',
          price: 2000
        },
        {
          image: talajfuro,
          name: 'Talajfúró',
          description: 'Gyártó: Stihl',
          price: 7000
        },
        {
          image: szivattyu,
          name: 'Szivattyú',
          description: 'Gyártó: Firman',
          price: 6000
        },
        {
          image: gyepszellozteto,
          name: 'Gyepszellőztető',
          description: 'Gyártó: Ryan',
          price: 5000
        },
        {
          image: magassagi,
          name: 'Magassági Ágvágó',
          description: 'Gyártó: Ryobi',
          price: 4000
        },
        {
          image: tuskomaro,
          name: 'Tuskómaró',
          description: 'Gyártó: Cub Cadet',
          price: 9000
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