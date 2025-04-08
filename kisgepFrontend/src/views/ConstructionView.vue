<template>
  <div class="container mx-auto p-4">
    <div class="flex justify-between items-center mb-4">
      <h1 class="text-2xl font-bold">Építőipari Gépek</h1>
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
        items: [
          {
            image: sarokcsiszolo,
            name: 'Sarokcsiszoló',
            description: 'Gyártó: Makita',
            price: 4000
          },
          {
            image: furogep,
            name: 'Fúrógép',
            description: 'Gyártó: Bosch',
            price: 2000
          },
          {
            image: vesogep,
            name: 'Vésőgép',
            description: 'Gártó: Bosch',
            price: 5000
          },
          {
            image: betonkevero,
            name: 'Betonkeverő',
            description: 'Gyártó: Leziter',
            price: 13000
          },
          {
            image: lezeres,
            name: 'Lézeres Szintező',
            description: 'Gyártó: Handy',
            price: 7000
          },
          {
            image: holegfuvo,
            name: 'Hőlégfúvó',
            description: 'Gyártó: Expert',
            price: 2000
          },
          {
            image: magasnyomasu,
            name: 'Magasnyomású Mosó',
            description: 'Gyártó: Kärcher',
            price: 3000
          },
          {
            image: koszoru,
            name: 'Köszörű',
            description: 'Gyártó: Crown',
            price: 5000
          },
          {
            image: korfuresz,
            name: 'Körfűrész',
            description: 'Gyártó: Expert',
            price: 6000
          },
          {
            image: kompresszor,
            name: 'Kompresszor',
            description: 'Gyártó: Fubag',
            price: 2000
          },
          {
            image: gervago,
            name: 'Gérvágó',
            description: 'Gyártó: DeWalt',
            price: 4000
          },
          {
            image: aszfaltvago,
            name: 'Aszfaltvágó',
            description: 'Gyártó: Ya Yao Qgj',
            price: 10000
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