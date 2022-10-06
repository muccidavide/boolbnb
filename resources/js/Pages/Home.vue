<template>
  <div class="wrapper mt-5">
    <section id="search" class="container my-5 position-relative">
      <img class="w-100 img-fluid hero-img" src="./../../img/airbnb.jpg" alt="" />
      <div>
        <div
          class=" jumbo-search 
            jumbo-costum
            row
            row-cols-1
            align-items-center
            position-absolute
            top-50
            start-50
            translate-middle
          "
        >
          <div class="col">
            <h1>Benvenuto in boolbnb</h1>
            <h3>Lasciati ispirare dai luoghi o effettua la tua ricerca</h3>
          </div>
          <!-- Benvenuto -->
          <div class="row flex-column">
            <div class="col">
              <div class="group my-3">
                <input 
                  autocomplete="off"
                  required="" 
                  type="text" 
                  id="query_address"
                  v-model="query"
                  @keyup="getAutocomplete"
                  @keyup.38="listUp"
                  @keyup.40="listDown"
                  @keyup.enter="getGeoPosition"
                  class="input"
                />
                <span class="highlight"></span>
                <span class="bar"></span>
                <label class="text-black costum-label">Inizia la tua ricerca</label>
                <ul class="dropdown_menu w-100" v-if="query.length > 0">
                  <li v-for="(address, index) in autocomplete" :key="index">
                    <input
                      type="text"
                      class="w-100"
                      readonly
                      :value="address"
                      @click="setQuery(address)"
                    />
                  </li>
                </ul>
              </div> 
            </div>
            <div class="col">
              <router-link
                class="ms-1"
                :to="{ name: 'search', params: { query: query } }"
              >
                <button type="\submit">
                  <div class="svg-wrapper-1">
                    <div class="svg-wrapper">
                      <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" width="24" height="24">
                        <path fill="none" d="M0 0h24v24H0z"></path>
                        <path fill="currentColor" d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"></path>
                      </svg>
                    </div>
                  </div>
                  <span>cerca</span>
                </button>
              </router-link>
            </div>
          </div>
          <!-- filter -->
        </div>
      </div>
    </section>
    <!-- /welcomepages -->
    

    <section id="sponsorizzate">
      <div class="container">
      
        <div v-if="apartmentPublicities.length === 0"></div>
        <div v-else>
            <h4 class="d-flex justify-content-end mt-4 m-2 p-3">I Trend del momento</h4>
            <div class="row align-items-end row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-5 g-4 gy-5 py-3">
              
              <div class="col" v-for="apartmentPublicity in apartmentPublicities" :key="apartmentPublicity.id">
              
                <router-link
                    :to="{
                      name: 'apartment',
                      params: { slug: apartmentPublicity.slug, query: query },
                    }"
                >
                  <div class="card-hover card text-start">

                    <div class="publicity_banner"><img class="costum-segnaposti" src="./../../img/segnaposti.png" alt=""></div>
                    <img class="img-fluid img-costum" :src="'storage/' + apartmentPublicity.thumb" />
                    
                    <div class="card-body">
                      <div class="header-card row">
                        <h4 class="col card-title costum-title">
                          {{ apartmentPublicity.title }}
                        </h4>
                       
                      </div>
                      <div class="description-card">
                        <p class="card-text costum-text">{{ trimText(apartmentPublicity.description) }}</p>
                      </div>
                    </div>
                  </div>

                </router-link>
              </div>
            </div>

        </div>

      </div>
    </section>

    <section id="normal" class="py-3">
      <div class="container">
        <h4 class="d-flex justify-content-end mt-4 m-2 p-3">
          I nostri appartamenti
        </h4>
        <div class="row row-cols-1 row-cols-sm-2 row-cols-lg-4 row-cols-xl-5 g-4 py-3">
          <div
            class="col mb-3"
            v-for="apartment in apartmentsResponse.data"
            :key="apartment.id"
          >
            <router-link
              :to="{
                name: 'apartment',
                params: { slug: apartment.slug, query: query },
              }"
            >
              <div  class="card-hover card text-start">

                <img
                  :src="'storage/' + apartment.thumb"
                  :alt="apartment.title"
                  class="img-costum"
                />
                <div class="card-body">
                  <div class="header-card">
                    <h4 class=" card-title costum-title">
                      {{ apartment.title }}
                    </h4>
                  </div>
                  <div class="description-card">
                    <p class="costum-text">
                      {{ trimText(apartment.description) }}
                    </p>
                  </div>
                </div>
                <!-- In valutazione perché optato per la soluzione del click sull'intera card dell'appartamento-->
                <!--  <router-link class="btn btn-primary" :to="{ name: 'apartment', params: { slug: apartment.slug } }">Visualizza</router-link>
             -->
              </div>
              
            </router-link>
          </div>
        </div>
        
        <!-- Struttura della paginazione -->   
        <div class="text-center py-4">
            <nav aria-label="Page navigation">
            <ul class="pagination justify-content-center">
                <li class="page-item" v-if="apartmentsResponse.current_page > 1">
                <a class="page-link" href="#" aria-label="Previous" @click.prevent="getApartments(apartmentsResponse.current_page - 1)">
                    <span aria-hidden="true">&laquo;</span>
                    <span class="sr-only text-primary">Precedente</span>
                </a>
                </li>

                <li :class="{ 'page-item': true, 'active text-primary': page == apartmentsResponse.current_page }" v-for="page in apartmentsResponse.last_page" :key="page.id">
                    <a class="page-link" href="#" @click.prevent="getApartments(page)">{{page}}</a>
                </li>
                

                <li class="page-item" v-if="apartmentsResponse.current_page < apartmentsResponse.last_page">
                <a class="page-link" href="#" aria-label="Next" @click.prevent="getApartments(apartmentsResponse.current_page + 1)">
                    <span aria-hidden="true">&raquo;</span>
                    <span class="sr-only text-primary">Prossima</span>
                </a>
                </li>
            </ul>
            </nav>
        </div>
      </div>
    </section>
    <!-- /#normal -->
    <!-- /FINE CARD -->

    <div
      class="
        btn btn-dark
        d-flex
        align-items-center
        shadow
        rounded-pill
        d-flex
        justify-content-center
        w_fix
        p_fixed_maps
        text-white
      "
    >
      <p class="me-2 mb-0">
        <a href="#search">Ricerca alloggio</a>
        <!-- <router-link :to="{ name: 'search' }"></router-link> -->
      </p>
      <svg
        xmlns="http://www.w3.org/2000/svg"
        width="16"
        height="16"
        fill="currentColor"
        class="bi bi-map"
        viewBox="0 0 16 16"
      >
        <path
          fill-rule="evenodd"
          d="M15.817.113A.5.5 0 0 1 16 .5v14a.5.5 0 0 1-.402.49l-5 1a.502.502 0 0 1-.196 0L5.5 15.01l-4.902.98A.5.5 0 0 1 0 15.5v-14a.5.5 0 0 1 .402-.49l5-1a.5.5 0 0 1 .196 0L10.5.99l4.902-.98a.5.5 0 0 1 .415.103zM10 1.91l-4-.8v12.98l4 .8V1.91zm1 12.98 4-.8V1.11l-4 .8v12.98zm-6-.8V1.11l-4 .8v12.98l4-.8z"
        />
      </svg>
    </div>
    <!-- /maps -->
  </div>
</template>

<script>
import axios from "axios";
export default {
  name: "Home",
  data() {
    return {
      apartments: "",
      query: "",
      autocomplete: [],
      apartmentPublicities: "",
      apartmentsResponse: ""
    };
  },
  methods: {
    getApartments(apartmentPage) {
            axios.get('/api/apartments', {
                params: {
                    page: apartmentPage
                }
            }).then((response) => {
            console.log(response);
            console.log(response.data);
           
            this.apartmentsResponse = response.data
        }).catch(e => {
            console.error(e);
        })
    },
    getPublicityApartment(){
      axios
      .get('/api/apartment/publicity')
      .then((response) => {
        this.apartmentPublicities = response.data;
      })
       .catch((e) => {
          console.error(e);
        });
    },
    listDown() {
      console.log("giu");
      const list = document.getElementById("dropdown_menu"); // targets the <ul>
      const first = document.getElementById("dropdown_menu").firstChild; // targets the first <li>
      const maininput = document.getElementById("query_address"); // targets the input, which triggers the functions populating the list
      if (document.activeElement == maininput) {
        // if the currently focused element is the main input --> focus the first <li>
        first.firstChild.focus();
      } else {
        // target the currently focused element -> <a>, go up a node -> <li>, select the next node, go down a node and focus it
        document.activeElement.parentNode.nextSibling.firstChild.focus();
      }
    },
    listUp() {
      console.log("su");
      const list = document.getElementById("dropdown_menu"); // targets the <ul>
      const first = list.firstChild; // targets the first <li>
      const maininput = document.getElementById("query_address"); // targets the input, which triggers the functions populating the list
      if (
        document.activeElement != maininput ||
        document.activeElement != first
      ) {
        // stop the script if the focus is on the input or first element
        // select the element before the current, and focus it
        document.activeElement.parentNode.previousSibling.firstChild.focus();
      }
    },
    setQuery(add) {
      this.query = add;
      this.autocomplete = [];
    },
    getAutocomplete() {
      // console.log('digitando');
      if (this.query) {
        axios
          .get(
            `https://api.tomtom.com/search/2/search/${this.query}.json?key=ZKEljqh55cAJVmD8GpeG3iI4JmV5HEDm&limit=5&countrySet=IT&language=it-IT`
          )
          .then((response) => {
            //console.log(response.data.results);
            const results = response.data.results;
            this.autocomplete = [];
            results.forEach((result) => {
              //console.log(result.address.freeformAddress);
              let address = result.address.freeformAddress;
              this.autocomplete.push(address);
            });
            //console.log(this.autocomplete);
          })
          .catch((e) => {
            
            console.log(e);
          });
      }
    },
    getCallApi() {
      axios
        .get("api/apartments")
        .then((response) => {
          this.apartments = response.data;
        })
        .catch((e) => {
          console.error(e);
        });
    },
    trimText(text) {
      if (text.length > 100) {
        return text.slice(0, 50) + "...";
      }
      return text;
    },
  },
  mounted() {
    this.getApartments(1);
    this.getCallApi();
    this.getPublicityApartment()
  },
};
</script>

<style lang='scss' scoped>
/* #search{
  height: 300px;
} */
.hero-img{
  height: 400px;
  object-fit: cover;
  border-radius: 10px;
}
.jumbo-search{
  padding: 1rem;
  border-radius: 10px;
  background-color: rgb(244 244 244 / 27%) !important;
  min-height: 200px;
}
.dropdown_menu {
  position: absolute;
  z-index: 100;
    width: 300px;
  border-radius: 10px;
  /* border: 1px solid #3471eb; */
  border-top: none;
  /* padding: 0.8rem 0.3rem;
  background-color: white; */

  input {
    
    cursor: pointer;

    &:focus {
      background-color: rgba(117, 124, 184, 0.331);
    }
  }
}

#trend img {
  fill: red;
}

.card {
  position: relative;
  padding:0.5rem;
  border: none;
  height: 100%;
  background-color: #f8fafc;
  transition: border 0.5s cubic-bezier(0.175, 0.885, 0.32, 1.275);
  border-radius: 5px;
   transition: transform .5s;
 &:hover{
    box-shadow: 0 0 10px 4px #d0d0d0e8;
    transform: scale(1.05);
    z-index: 1;
 }
 .publicity_banner {
  width: 30px;
  height: 50px;
  border-radius: 6px;
  position: absolute;
  top: 0;
  right: 6%;
  transition: transform .5s;
 }
  .img-costum {
    width: 100%;
    height: 160px;
    border-radius: 10px;
  }
  .card-body {
    height: 100px;
    padding: 0.2rem;
   /*  max-width: 240px; */
    .header-card {
      margin-top: 10px;
      height: 45px;
      padding: 0;
      display: flex;
      justify-content: space-between;

      .costum-rate {
        text-align: right;
      }
      .costum-title {
        color: #050505;
        font-size: 13px;
        font-weight: bold;
        /* white-space: nowrap; */
        /* overflow: hidden; */
        /* text-overflow: ellipsis; */
      }
    }
  }
}
.costum-text {
  color: #717171;
  font-size: 12px;
}
.search-bar {
  border-radius: 10px;
  border: 1px solid #c1c2c5;
  padding: 0.3rem 0.8rem;
}
.search-bar:focus-visible {
  outline: 1px solid #a5a5a5;
}
.dropdown_menu {

  li input {
    
    border: none;
    
    outline: none;
  }
}
a{
  color: white;
  &.page-link{
    color:#3471eb
  }
}
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
.group {
 position: relative;
}

.input {
 font-size: 16px;
 padding: 10px 10px 10px 5px;
 display: block;
 width: 20%;
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

.input:focus ~ label, .input:valid ~ label {
 top: -20px;
 font-size: 14px;
 color: #3471eb;
}

.bar {
 position: relative;
 display: block;
 width: 183px;
}

.bar:before, .bar:after {
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

.input:focus ~ .bar:before, .input:focus ~ .bar:after {
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

.input:focus ~ .highlight {
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
.costum-label{
  font-size: 14px;
}
@media screen and (max-width: 480px) {
  .input{
    width: 50%;
  }
  .costum-label  {
    font-size: 12px;
  }
}
.costum-segnaposti{
  height: 100%;
}

.costum-card-img{
  width: 100%;
  height: 180px;
}

.jumbo-costum{
  width: 70%;
  
}



</style>