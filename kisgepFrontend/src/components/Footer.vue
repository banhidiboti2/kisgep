<template>
  <footer class="footer">
    <div class="container">
      <div class="d-flex flex-wrap justify-content-between align-items-center py-3">
        <p class="col-md-4 mb-0 " id="text" >&copy; 2025 A&B Kisgép Kölcsönző</p>
    
   
    
        <ul class="nav col-md-4 justify-content-end">
          <li class="nav-item"><router-link to="/Privacy" class="nav-link px-2">Adatkezelési Tájékoztató</router-link></li>
          <li class="nav-item"><router-link to="/Frequently" class="nav-link px-2">Gyakran Ismételt Kérdések</router-link></li>

          

        </ul>
      </div>
    </div>
  </footer>
</template>

<script>
export default {
  name: 'Footer'
};
</script>

<style scoped>
.footer {
  background-color: #858a91;
  color: rgba(255, 255, 255, 0.75);
  padding: 0;
  margin-top: auto;
}


.footer a {
  color: black;
  font-size: 0.9rem;
    font-weight: bold;
    white-space: nowrap;
}

#text{
  color: black;
  font-size: 0.9rem;
    font-weight: bold;
    white-space: nowrap;
}


.nav-item {
  margin-left: 10px;
  margin-right: 10px;
}
</style>