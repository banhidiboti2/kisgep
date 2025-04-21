<template>
  <div class="main-layout">
    <div class="sidebar">
      <div class="sidebar-content">
        
        <div class="card" style="width: 18rem;">
  <img src="@/photos/construction.png" id="menuimage">

    <h5 class="card-title" id="menuname">Építőipari Gépek</h5>
    <router-link class="dropdown-item" to="/construction" id="menubutton">Megnézem</router-link>

</div>

<div class="card" style="width: 18rem;">
  <img src="@/photos/garden.png" id="menuimage">

    <h5 class="card-title" id="menuname">Kerti Gépek</h5>
    <router-link class="dropdown-item" to="/garden" id="menubutton">Megnézem</router-link>

</div>

<div class="card" style="width: 18rem;">
  <img src="@/photos/Woodpng.png" id="menuimage">

    <h5 class="card-title" id="menuname">Fa és Fémipari Gépek</h5>
    <router-link class="dropdown-item" to="/woodandmetal" id="menubutton">Megnézem</router-link>

</div>


        <div class="logo-container">
          <img src="@/photos/logo.png" class="logo" alt="Logo">
        </div>
      </div>
    </div>

    <div class="map-area">
      <h1 id="location">Helyszín: 1032 Budapest, Bécsi út 134</h1>
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d1641.2746393753332!2d19.029328556821618!3d47.541053792765936!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x4741d9424b0c99ef%3A0x63bcf7f51b81250f!2zQnVkYXBlc3QsIELDqWNzaSDDunQgMTM0LCAxMDMy!5e1!3m2!1shu!2shu!4v1744058884317!5m2!1shu!2shu"
        width="100%" height="600" style="border:0;" allowfullscreen="true" loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>


      <ul class="list-group list-group-flush" id="open">
      <li class="list-group-item active"> <h1>Nyitvatartás</h1></li>
      <li class="list-group-item">Hétfő - Péntek: 8:00 - 17:00</li>
      <li class="list-group-item">Szombat: 9:00 - 13:00</li>
      <li class="list-group-item">Vasárnap: Zárva</li>
      </ul>
    </div>

    <div class="popular-products">
  <h1>Népszerű Termékek</h1>
  
  <div v-if="loading" class="text-center py-4">
    <p>Termékek betöltése...</p>
  </div>
  
  <div v-else-if="error" class="text-center py-4 text-red-600">
    <p>{{ error }}</p>
  </div>
  
  <div v-else-if="items.length === 0" class="text-center py-4">
    <p>Nem található népszerű termék.</p>
  </div>
  
  <div v-else class="grid grid-cols-2 gap-4">
    <div v-for="(item, index) in items" :key="index" class="border border-gray-300 p-4 text-center rounded shadow-sm hover:shadow-md transition-shadow">
      <div class="img-wrapper mb-2">
        <img :src="item.image" alt="Gép" class="product-image mx-auto">
      </div>
      <p class="font-semibold text-lg">{{ item.name }}</p>
      <p class="my-2">{{ item.description }}</p>
      <p class="font-bold my-2">Ár: {{ item.price }} Ft</p>
      <button @click="addToBasket(item)" class="button hover:bg-gray-400 transition-colors">Kosárba</button>
    </div>
  </div>
</div>
  </div>

</template>
<script>
import axios from 'axios';

import soveny from '@/photos/sovenynyiro.png';
import sarok from '@/photos/sarokcsiszolo.png';

export default {
  name: 'MainView',
  data() {
    return {
      items: [],
      loading: true,
      error: null,
      basket: JSON.parse(localStorage.getItem('basket')) || [],
      defaultImages: {
        'Sövénynyíró': soveny,
        'Sarokcsiszoló': sarok
      }
    };
  },
  methods: {
    addToBasket(item) {
      this.basket.push(item);
      localStorage.setItem('basket', JSON.stringify(this.basket));
    },
    
    fetchPopularProducts() {
  this.loading = true;
  this.error = null;
  
  axios.get('http://127.0.0.1:8000/api/termekek', { withCredentials: false })
    .then(response => {
      if (response.data && Array.isArray(response.data)) {
        const product17 = response.data.find(item => item.id === 17);
        const product25 = response.data.find(item => item.id === 25);
        
        const popularProducts = [];
        if (product17) popularProducts.push(product17);
        if (product25) popularProducts.push(product25);
        
        if (popularProducts.length === 0 && response.data.length > 0) {
          popularProducts.push(response.data[0]);
          if (response.data.length > 1) {
            popularProducts.push(response.data[1]);
          }
        }
        
        this.items = popularProducts.map(item => ({
          id: item.id,
          image: this.getProductImage(item),
          name: item.nev || item.name,
          description: item.leiras || item.description || `Gyártó: ${item.gyarto || 'Ismeretlen'}`,
          price: item.ar || item.price
        }));
      } else {
        this.error = 'Nem sikerült betölteni a termékeket';
        console.error('Unexpected data format:', response.data);
      }
      this.loading = false;
    })
    .catch(error => {
      console.error('Error fetching popular products:', error);
      this.error = 'Hiba történt a termékek betöltése közben. Kérjük, ellenőrizze, hogy a szerver fut-e.';
      this.loading = false;
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
      
      return soveny;
    }

  },
  
  created() {
    this.fetchPopularProducts();
  }
};
</script>



<style>
html, 
body,
#app {
  background-color: rgb(209, 219, 225) !important;
  min-height: 100vh;
  margin: 0;
  padding: 0;
}
</style>

<style scoped>
.main-layout {
  display: grid;
  grid-template-columns: 1fr 3fr 1fr;
  gap: 1rem;
  max-width: 100%;
  margin: 0 auto;
  padding: 1rem;
}

.sidebar,

.popular-products {
  background-color: #f8f9fa;
  padding: 1rem;
  border-radius: 10px;
}

.map-area
{
  background-color: #f8f9fa;
  padding: 1rem;
  border-radius: 10px;
}

.sidebar {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.sidebar {
  display: flex;
  flex-direction: column;
  align-items: center;

  position: relative;
}

.sidebar-content {
  display: flex;
  flex-direction: column;
  align-items: center;
  width: 100%;
  height: 100%;
}




.logo-container {
  margin-top: auto; 
  margin-bottom: 20px;
  text-align: center;
}


.logo {
  width: 300px;
  height: 250px;
}

.product-image {
  width: 100%;
  height: auto;
  max-width: 200px;
  object-fit: cover;
  margin: 0 auto;
}

.button {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
  border: none;
}

h1 {
  font-size: 1.5rem;
  margin-bottom: 1rem;
}

.mt-4 {
  margin-top: 1.5rem;
}

#open {
  margin-top: 20px;
  background-color: #858a91; 
  color: white;
  padding: 10px;
  border-radius: 5px;
  text-align: center;
}

.list-group-item.active {
  background-color: #858a91 !important;
  border-color: #858a91 !important;
  color: black !important;
}

#location {

  text-align: center;
  font-weight: bold;

}

#menuimage {
  width: 100px;
  height: 100px;
  max-width: 200px;
  object-fit: cover;
  margin: 0 auto;
} 

#menubutton {
  background-color: #858a91;
  color: black;
  padding: 0.5rem 1rem;
  border-radius: 0.25rem;
  text-decoration: none;
  border: none;
  text-align: center;
}

#menuname {
  text-align: center;
  font-weight: bold;
  margin-top: 10px;
}


</style>