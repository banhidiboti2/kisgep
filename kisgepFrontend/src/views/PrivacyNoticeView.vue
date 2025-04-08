<template>
    <div class="container mt-5">
      <h2 class="text-center mb-4">Adatkezelési Tájékoztató</h2>

      <div class="accordion" id="privacyAccordion">
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingOne">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseOne"
              aria-expanded="false"
              aria-controls="collapseOne"
            >
              1. Bevezetés
            </button>
          </h2>
          <div
            id="collapseOne"
            class="accordion-collapse collapse"
            aria-labelledby="headingOne"
            data-bs-parent="#privacyAccordion"
          >
            <div class="accordion-body">
              Ez az adatkezelési tájékoztató ismerteti, hogy hogyan kezeljük a személyes adatokat, amelyeket a weboldalon keresztül gyűjtünk. A személyes adatok védelme kiemelt fontosságú számunkra, ezért az alábbiakban ismertetjük az általunk alkalmazott adatkezelési gyakorlatot.
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingTwo">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseTwo"
              aria-expanded="false"
              aria-controls="collapseTwo"
            >
              2. Az adatkezelő
            </button>
          </h2>
          <div
            id="collapseTwo"
            class="accordion-collapse collapse"
            aria-labelledby="headingTwo"
            data-bs-parent="#privacyAccordion"
          >
            <div class="accordion-body">
              <p><strong>Cég neve</strong>: A&B Kisgép Kölcsönző Kft.</p>
              <p><strong>Cég székhelye</strong>: 1032 Budapest, Bécsi út 134</p>
              <p><strong>Kapcsolattartó e-mail cím</strong>: abkisgep@gmail.com</p>
              <p><strong>Telefonszám</strong>: +36308849345</p>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingThree">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseThree"
              aria-expanded="false"
              aria-controls="collapseThree"
            >
              3. Az adatkezelés célja
            </button>
          </h2>
          <div
            id="collapseThree"
            class="accordion-collapse collapse"
            aria-labelledby="headingThree"
            data-bs-parent="#privacyAccordion"
          >
            <div class="accordion-body">
              <ul>
                <li>Szolgáltatásaink nyújtása</li>
                <li>Számlázás és pénzügyi tranzakciók</li>
                <li>Weboldal működtetése és javítása</li>
                <li>Jogszabályi kötelezettségek teljesítése</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingFour">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseFour"
              aria-expanded="false"
              aria-controls="collapseFour"
            >
              4. A kezelt személyes adatok köre
            </button>
          </h2>
          <div
            id="collapseFour"
            class="accordion-collapse collapse"
            aria-labelledby="headingFour"
            data-bs-parent="#privacyAccordion"
          >
            <div class="accordion-body">
              <ul>
                <li>Kapcsolattartási adatok (Név, cím, telefonszám, e-mail cím)</li>
                <li>Számlázási adatok</li>
                <li>Szolgáltatás igénybevételével kapcsolatos adatok</li>
                <li>Weboldal használati adatok</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingFive">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseFive"
              aria-expanded="false"
              aria-controls="collapseFive"
            >
              5. Az adatkezelés jogalapja
            </button>
          </h2>
          <div
            id="collapseFive"
            class="accordion-collapse collapse"
            aria-labelledby="headingFive"
            data-bs-parent="#privacyAccordion"
          >
            <div class="accordion-body">
              <ul>
                <li>Szerződéses kapcsolat</li>
                <li>Jogszabályi kötelezettség</li>
                <li>Hozzájárulás</li>
              </ul>
            </div>
          </div>
        </div>
        <div class="accordion-item">
          <h2 class="accordion-header" id="headingSix">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              data-bs-target="#collapseSix"
              aria-expanded="false"
              aria-controls="collapseSix"
            >
              6. Adatmegőrzés
            </button>
          </h2>
          <div
            id="collapseSix"
            class="accordion-collapse collapse"
            aria-labelledby="headingSix"
            data-bs-parent="#privacyAccordion"
          >
            <div class="accordion-body">
              A személyes adatokat az alábbi időtartamokig tároljuk:
              <ul>
                <li>Szerződéses adatok: 5 év</li>
                <li>Számlázási adatok: 8 év</li>
                <li>Marketing célú adatok: Hozzájárulás visszavonásáig</li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="button-container">
        <router-link to="/" class="back-button">Vissza</router-link>
      </div>
  </template>
  
  <script>
  export default {
    name: "PrivacyPolicyAccordion",
  };
  </script>
  

  

  <style scoped>
  .container {
    max-width: 1200px;
    margin: 0 auto;
  }
  .button-container {
    display: flex;
    justify-content: center;
    margin-top: 1rem;
  }

  .back-button {
    background-color: #858a91;
    color: black;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    text-decoration: none;
  }
  </style>