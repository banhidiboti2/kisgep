<template>
    <div class="confirmation-view">
      <div class="container">
        <div class="confirmation-box">
          <h1>Rendelés megerősítve!</h1>
          <div class="icon-container">
            <i class="check-icon">✓</i>
          </div>
          <p>Köszönjük a rendelését! A rendelés feldolgozása folyamatban van.</p>
          <p>A rendelés részleteit és állapotát a fiókjában követheti nyomon.</p>
          <div class="button-container">
            <router-link to="/" class="btn home-button">Vissza a főoldalra</router-link>
          </div>
        </div>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: 'OrderConfirmationView'
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
    background-color: #f1c40f;
    color: white;
    padding: 12px 25px;
    border-radius: 50px;
    text-decoration: none;
    font-weight: bold;
    transition: background-color 0.3s;
  }
  
  .home-button:hover {
    background-color: #e2b60d;
  }
  </style>