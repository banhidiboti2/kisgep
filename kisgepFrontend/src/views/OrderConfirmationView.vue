<template>
  <div class="confirmation-view">
    <div class="container">
      <div class="confirmation-box">
        <h1>Rendelés megerősítve!</h1>
        <div class="icon-container">
        </div>
        <p>Köszönjük a rendelését! A rendelés feldolgozása folyamatban van.</p>
        <p v-if="orderId" class="order-id">Az Ön rendelésének azonosítója: <strong>{{ orderId }}</strong></p>
        <div class="button-container">
          <router-link to="/" class="btn home-button">Vissza a főoldalra</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: 'OrderConfirmationView',
  data() {
    return {
      orderId: ''
    }
  },
  created() {
    console.log('OrderConfirmationView component created');
    this.orderId = localStorage.getItem('lastOrderId') || '';
    console.log('orderId:', this.orderId);
  }
}
</script>

<style scoped>
.confirmation-view {
  background-color: rgb(209, 219, 225);
  min-height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

.container {
  width: 100%;
  max-width: 600px;
}

.confirmation-box {
  background: rgba(255, 255, 255, 0.95);
  padding: 40px;
  border-radius: 15px;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
  text-align: center;
}

.confirmation-box h1 {
  color: #333;
  margin-bottom: 20px;
}

.icon-container {
  margin: 30px 0;
}

.check-icon {
  display: inline-block;
  width: 80px;
  height: 80px;
  line-height: 80px;
  background-color: #4CAF50;
  color: white;
  font-size: 40px;
  border-radius: 50%;
}

.button-container {
  margin-top: 30px;
}

.home-button {
  display: inline-block;
  width: 100%;
  padding: 10px;
  border: 1px solid #e2e8f0;
  border-radius: 6px;
  font-family: inherit;
  font-size: 1rem;
  background-color: #9ca3af;
  color: #333;
  text-align: center;
  text-decoration: none;
  cursor: pointer;
  transition: all 0.3s ease;
}

.order-id {
  font-size: 1.1rem;
  margin: 20px 0;
  padding: 10px;
  background-color: #f8f9fa;
  border-radius: 8px;
  display: inline-block;
}

.order-id strong {
  color: #212529;
  font-weight: bold;
  font-size: 1.2rem;
}
</style>