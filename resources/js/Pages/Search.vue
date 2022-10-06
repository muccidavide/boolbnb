<template>
  <div class="wrapper">
    <section class="container my-5 p-5 shadow bg_trend">
      <h1 class="p-2">Effettua una nuova ricerca</h1>
      <div class="row   ">
        <div>
          <!-- Advanced search -->
          <form method="POST" @submit.prevent="getGeoPosition">
            <div class="group">
              <input autocomplete="off" required="" type="text" id="query_address" v-model="query"
                @keyup="getAutocomplete" @keyup.38="listUp" @keyup.40="listDown" @keyup.enter="getGeoPosition"
                class="input" />
              <span class="highlight"></span>
              <span class="bar"></span>
              <label>Cerca per città o per indirizzo:</label>
              <ul class="dropdown_menu w-50" v-if="query.length > 0">
                <li v-for="(address, index) in autocomplete" :key="index">
                  <input type="text" class="w-100" readonly :value="address" @click="setQuery(address)" />
                </li>
              </ul>
            </div>
            <div class="row">
              <div class="sx col-md-6">
                <div class="group mt-3">
                  <label for="radius">Distanza dal centro (in km):</label>
                  <br><br>
                  <input type="number" class="form-control" name="radius" id="radius" min="0" step="10" v-model="radius"
                    @keyup.enter="getGeoPosition" />
                  <span class="highlight"></span>
                  <span class="bar"></span>
                </div>

                <div class="group">
                  <label for="rooms" class="form-label">Numero minimo di stanze:</label>
                  <br><br>
                  <input type="number" class="form-control" name="rooms" id="rooms" min="1" max="10" v-model="rooms" />
                </div>
              </div>

              <div class="dx col-md-6">
                <div class="group">
                  <label for="beds" class="form-label">Numero minimo di letti:</label>
                  <br><br>
                  <input type="number" class="form-control" name="beds" id="beds" min="1" max="20" v-model="beds" />
                </div>

                <div class="group">
                  <label for="baths" class="form-label">Numero minimo di bagni:</label>
                  <br><br>
                  <input type="number" class="form-control" name="baths" id="baths" min="1" max="20" v-model="baths" />
                </div>
              </div>
            </div>

            <div class="group">
              <label for="services" class="form-label">Seleziona uno o più servizi:</label>
              <br><br>
              <div class="row row-cols-3 flex-wrap">
                <div class="col" v-for="service in services" :key="service.id">
                  <div class="custom-control custom-checkbox">
                    <input class="service custom-control-input" type="checkbox" name="service" id="service"
                      :value="service.id">
                    <span class="custom-control-indicator"></span>
                    <span class="custom-control-description">{{ service.name }}</span>
                  </div>
                </div>
              </div>
              <!--               <select class="form-select" name="services" id="services" v-model="selectedServices" multiple>
                <option :value="service.id" v-for="service in services" :key="service.id">
                  {{ service.name }}
                </option>
              </select> -->
            </div>
            <button type="submit">
              <div class="svg-wrapper-1">
                <div class="svg-wrapper">
                  <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                    <path fill="none" d="M0 0h24v24H0z"></path>
                    <path fill="currentColor"
                      d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z">
                    </path>
                  </svg>
                </div>
              </div>
              <span>cerca</span>
            </button>
          </form>
        </div>
      </div>
      <!-- Results Advanced Search -->
      <div class="results">
        <div class="container">
          <div v-if="apartments.length > 0">
            <h4 class="d-flex justify-content-end mt-4 m-2 p-3">
              I nostri appartamenti
            </h4>
            <div class="row 
            row-cols-xl-5 
            row-cols-lg-4
            row-cols-md-3
            row-cols-sm-1
            g-4 py-3">
              <div class="col" v-for="apartment in apartments" :key="apartment.id">
                <router-link :to="{
                  name: 'apartment',
                  params: {
                    slug: apartment.slug,
                    query: query,
                    radius: radius,
                  },
                }">
                  <div class="card h-100 text-start">
                    <img :src="'storage/' + apartment.thumb" :alt="apartment.title" />
                    <div class="header-card ">
                      <h4 class=" card-title custom-title">{{ apartment.title }}</h4>
                    </div>
                    <div class="description-card">
                      <p class="costum-text">{{ apartment.description }}</p>
                    </div>
                  </div>
                </router-link>
              </div>
            </div>
          </div>
          <!-- Loading -->
          <div v-else-if="loading" class="mt-5">
            <h2 class="text-center d-block">Loading:</h2>
            <div class="loader">
              <svg id="page-loader">
                <circle cx="75" cy="75" r="20"></circle>
                <circle cx="75" cy="75" r="35"></circle>
                <circle cx="75" cy="75" r="50"></circle>
                <circle cx="75" cy="75" r="65"></circle>
              </svg>
            </div>
          </div>
          <!-- No Results-->
          <div v-else-if="!loading && lat && lon" class="mt-5">
            😴😴😴Nessun Risultato
          </div>
          <!-- Start your search -->
          <div v-else class="mt-5">
            🔎Inzia la tua ricerca: cerca un appartemento in base alla città o
            all'indirizzo🔎
          </div>
        </div>
      </div>
    </section>
  </div>
</template>

<script>
import axios from "axios";

export default {
  name: "Search",
  data() {
    return {
      query: "",
      autocomplete: [],
      apartments: [],
      services: [],
      lat: "",
      lon: "",
      radius: 20,
      loading: false,
      rooms: 1,
      beds: 1,
      baths: 1,
      selectedServices: [],
    };
  },
  methods: {
    getAutocomplete() {
      //console.log('digitando');
      if (this.query) {
        axios
          .get(
            `https://api.tomtom.com/search/2/search/${this.query}.json?key=OQPgwY4eUitV7IRklnutdiB8DVqRx8kG&limit=5&countrySet=IT&language=it-IT`
          )
          .then((response) => {
            const results = response.data.results;
            this.autocomplete = [];
            results.forEach((result) => {
              let address = result.address.freeformAddress;
              this.autocomplete.push(address);
            });
          })
          .catch((e) => {
            console.log(e);
          });
      }
    },
    setQuery(add) {
      this.query = add;
      this.autocomplete = [];
    },
    getServices() {
      axios
        .get("api/services")
        .then((response) => {
          this.services = response.data;
        })
        .catch((error) => {
          console.log(error);
        });
    },
    getGeoPosition() {
      this.apartments = [];
      // Get Geodata from Axios based on input and radius(2000 standard)
      let query = this.query;
      let radius = this.radius * 1000;

      if (query) {
        this.loading = true;
        axios
          .get(
            `https://api.tomtom.com/search/2/geocode/${query}.json?key=OQPgwY4eUitV7IRklnutdiB8DVqRx8kG&limit=1&radius=${radius}`
          )
          .then((response) => {
            let lat = response.data.results[0].position.lat;
            let lon = response.data.results[0].position.lon;
            this.lat = lat;
            this.lon = lon;
            //console.log(document.querySelectorAll("input#service:checked"))
            let nodeServices = document.querySelectorAll("input#service:checked");
            let selectedServices = [];
            nodeServices.forEach(nodeService => {
              //console.log(nodeService.value);
              selectedServices.push(nodeService.value)
            });
            if (selectedServices.length === 0) {
              this.selectedServices = ["all"];
            } else {
              this.selectedServices = selectedServices;
            }

            // Pass Geo data to ApiController and recieve apartements filtered as response
            axios
              .get("api/search", {
                params: {
                  lat: this.lat,
                  lon: this.lon,
                  radius: radius,
                  rooms: this.rooms,
                  beds: this.beds,
                  baths: this.baths,
                  services: this.selectedServices,
                },
              })
              .then((response) => {
                //console.log(response);
                //console.log(this.lat, this.lon, this.radius);
                //console.log(response.data);
                this.apartments = response.data;
                this.loading = false;
              })
              .catch((error) => console.error(error));
          })
          .catch((e) => console.error(e));
      }
    },
  },
  mounted() {
    if (this.$route.params.query) {
      this.query = this.$route.params.query;
    }
    if (this.$route.params.radius) {
      this.radius = this.$route.params.radius;
    }
    this.getServices();
    this.getGeoPosition();
  },
};
</script>

<style lang='scss' scoped>
.dropdown_menu {
  position: absolute;
  width: 100%;
  z-index: 100;

  input {
    cursor: pointer;

    &:focus {
      background-color: #3471eb;
    }
  }
}

.group {
  position: relative;
}

.input {
  font-size: 16px;
  padding: 10px 10px 10px 5px;
  display: block;
  width: 200px;
  border: none;
  border-bottom: 1px solid #515151;
  background: transparent;
}

.input:focus {
  outline: none;
}

label {
  color: #999;
  font-size: 18px;
  font-weight: normal;
  position: absolute;
  pointer-events: none;
  left: 5px;
  top: 10px;
  transition: 0.2s ease all;
  -moz-transition: 0.2s ease all;
  -webkit-transition: 0.2s ease all;
}

.input:focus~label,
.input:valid~label {
  top: -20px;
  font-size: 14px;
  color: #3471eb;
}

.bar {
  position: relative;
  display: block;
  width: 200px;
}

.bar:before,
.bar:after {
  content: '';
  height: 2px;
  width: 0;
  bottom: 1px;
  position: absolute;
  background: #3471eb;
  transition: 0.2s ease all;
  -moz-transition: 0.2s ease all;
  -webkit-transition: 0.2s ease all;
}

.bar:before {
  left: 50%;
}

.bar:after {
  right: 50%;
}

.input:focus~.bar:before,
.input:focus~.bar:after {
  width: 50%;
}

.highlight {
  position: absolute;
  height: 60%;
  width: 100px;
  top: 25%;
  left: 0;
  pointer-events: none;
  opacity: 0.5;
}

.input:focus~.highlight {
  animation: inputHighlighter 0.3s ease;
}

@keyframes inputHighlighter {
  from {
    background: #3471eb;
  }

  to {
    width: 0;
    background: transparent;
  }
}

.loader {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  align-items: center;
  justify-content: center;
}

#page-loader {
  width: 150px;
  height: 150px;

  circle {
    fill: none;
    stroke-width: 5;
    stroke-linecap: round;
    animation-name: loader;
    animation-duration: 4s;
    animation-iteration-count: infinite;
    animation-timing-function: ease-in-out;
    transform-origin: center center;

    &:nth-child(1) {
      stroke: #ffc114;
      stroke-dasharray: 50;
      animation-delay: -0.2s;
    }

    &:nth-child(2) {
      stroke: #ff5248;
      stroke-dasharray: 100;
      animation-delay: -0.4s;
    }

    &:nth-child(3) {
      stroke: #19cdca;
      stroke-dasharray: 180;
      animation-delay: -0.6s;
    }

    &:nth-child(4) {
      stroke: #4e88e1;
      stroke-dasharray: 350;
      stroke-dashoffset: -100;
      animation-delay: -0.8s;
    }

    @keyframes loader {
      50% {
        transform: rotate(360deg);
      }
    }
  }
}

.card {
  border: none;
  height: 100%;
  padding: 0.5rem;
  background-color: #F8FAFC;
  transition: border 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  border-radius: 5px;
  transition: transform .5s;

  &:hover {
    box-shadow: 0 0 10px 4px #d0d0d0e8;
    transform: scale(1.05);
    z-index: 1;
  }

  img {
    width: 100%;
    min-height: 160px;
    border-radius: 10px;
  }
}

.header-card {
  margin-top: 10px;
  height: 45px;
  padding: 0;
  display: flex;
  justify-content: space-between;

  .custom-title {
    color: #050505;
    font-size: 13px;
    font-weight: bold;
    display: -webkit-box;
    line-height: 1.2rem;
    overflow: hidden;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    /*     white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis; */
  }
}

.costum-text {
  color: #515151;
  display: -webkit-box;
  overflow: hidden;
  -webkit-line-clamp: 2;
  -webkit-box-orient: vertical;
}

form>.row {
  align-items: flex-end;
}

/* From uiverse.io by @adamgiebl */
button {
  font-family: inherit;
  font-size: 20px;
  background: #3471eb;
  color: white;
  padding: 0.2em 0.5em;
  padding-left: 0.7em;
  display: flex;
  align-items: center;
  border: none;
  border-radius: 16px;
  overflow: hidden;
  transition: all 0.2s;
  margin-top: 15px;
}

button span {
  display: block;
  margin-left: 0.3em;
  transition: all 0.3s ease-in-out;
}

button svg {
  display: block;
  transform-origin: center center;
  transition: transform 0.3s ease-in-out;
}

button:hover .svg-wrapper {
  animation: fly-1 0.6s ease-in-out infinite alternate;
}

button:hover svg {
  transform: translateX(1.2em) rotate(45deg) scale(1.1);
}

button:hover span {
  transform: translateX(5em);
}

button:active {
  transform: scale(0.95);
}

@keyframes fly-1 {
  from {
    transform: translateY(0.1em);
  }

  to {
    transform: translateY(-0.1em);
  }
}

.wrapper {
  min-height: calc(100vh - 173px);
}
</style>