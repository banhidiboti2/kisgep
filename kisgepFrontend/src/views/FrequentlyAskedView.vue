<template>
    <div class="faq-container">
      <h2 class="text-center mb-4">Gyakran Ismételt Kérdések</h2>
      <div class="accordion" id="faqAccordion">
        <div class="accordion-item" v-for="(faq, index) in faqs" :key="index">
          <h2 class="accordion-header" :id="'heading' + index">
            <button
              class="accordion-button collapsed"
              type="button"
              data-bs-toggle="collapse"
              :data-bs-target="'#collapse' + index"
              aria-expanded="false"
              :aria-controls="'collapse' + index"
            >
              {{ faq.question }}
            </button>
          </h2>
          <div
            :id="'collapse' + index"
            class="accordion-collapse collapse"
            :aria-labelledby="'heading' + index"
            data-bs-parent="#faqAccordion"
          >
            <div class="accordion-body">
              {{ faq.answer }}
            </div>
          </div>
        </div>
      </div>
      <div class="button-container">
        <router-link to="/" class="back-button">Vissza</router-link>
      </div>
    </div>
  </template>
  
  <script>
  export default {
    name: "FAQComponent",
    data() {
      return {
        faqs: [
          {
            question: "Hogyan tudok gépet kölcsönözni?",
            answer:
              "Egyszerűen válaszd ki a gépet, tedd kosárba, majd rendeld meg online és vedd át a boltunkban.",
          },
          {
            question: "Szükséges előzetes foglalás?",
            answer:
              "Igen, különösen hétvégén és szezonban javasolt előre foglalni, hogy biztosan elérhető legyen a kívánt gép.",
          },
          {
            question: "Van lehetőség házhoz szállításra?",
            answer:
              "Jelenleg sajnos nincs lehetőség házhoz szállításra, de a boltunkban átveheted a gépeket.",
          },
          {
            question: "Kell kauciót fizetni?",
            answer:
              "Igen, a legtöbb gépnél kaució szükséges, amelyet a visszahozatal után visszatérítünk.",
          },
          {
            question: "Mennyi a kaució?",
            answer:
              "A kaució minden esetben 50 ezer forint, amelyet készpénzben kell letétbe helyezni.",
          },
          {
            question: "Mi történik, ha meghibásodik a gép?",
            answer:
              "Ha a meghibásodás nem a bérlő hibájából történt, cseréljük vagy visszatérítjük a bérleti díjat.",
          },
          {
            question: "Mennyi időre bérelhetek gépet?",
            answer:
              "Akár néhány órára, de hosszabb távra is. A bérleti időszak minimum 1 nap.",
          },
          {
            question: "Milyen dokumentum szükséges a kölcsönzéshez?",
            answer:
              "Személyi igazolvány és lakcímkártya.",
          },
          {
            question: "Milyen állapotban kapom meg a gépeket?",
            answer:
              "Minden gépet tisztított, működésre kész állapotban adunk át, igény esetén használati útmutatással.",
          },
          {
            question: "Mit tartalmaz az ár?",
            answer:
              "Az ár a gép bérleti díját tartalmazza. Üzemanyag, kopó alkatrészek.",
          },
        ],
      };
    },
  };
  </script>
  
  <style scoped>
  .faq-container {
    max-width: 800px;
    margin: 0 auto;
    padding: 2rem 1rem;
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
  