<template>
  <div id="SingleApartment" class="mt-5">
    <div id="titleAndThumb" class="container">
      <router-link
        :to="{ name: 'search', params: { query: query, radius: radius } }"
        >Torna Alla tua ricerca</router-link
      >
      <h2>
        <strong>{{ apartment.title }}</strong>
      </h2>
      <div class="d-flex">
        <!-- Icona stella da implementare con voto -->
        <div class="">
          <div class="d-flex align-item-center">
            <span class="icon_color px-1">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                fill="currentColor"
                class="bi bi-person-badge"
                viewBox="0 0 16 16"
              >
                <path
                  d="M6.5 2a.5.5 0 0 0 0 1h3a.5.5 0 0 0 0-1h-3zM11 8a3 3 0 1 1-6 0 3 3 0 0 1 6 0z"
                />
                <path
                  d="M4.5 0A2.5 2.5 0 0 0 2 2.5V14a2 2 0 0 0 2 2h8a2 2 0 0 0 2-2V2.5A2.5 2.5 0 0 0 11.5 0h-7zM3 2.5A1.5 1.5 0 0 1 4.5 1h7A1.5 1.5 0 0 1 13 2.5v10.795a4.2 4.2 0 0 0-.776-.492C11.392 12.387 10.063 12 8 12s-3.392.387-4.224.803a4.2 4.2 0 0 0-.776.492V2.5z"
                />
              </svg>
            </span>
            &bull;
            <p class="px-2">
              {{ apartment.user ? apartment.user.name : "" }}
            </p>
          </div>
        </div>
        <div class="">
          <!-- Icona location -->
          <div class="d-flex align-item-center">
            <span class="icon_color px-1">
              <svg
                xmlns="http://www.w3.org/2000/svg"
                width="22"
                height="22"
                fill="currentColor"
                class="bi bi-geo-alt-fill"
                viewBox="0 0 16 16"
              >
                <path
                  d="M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10zm0-7a3 3 0 1 1 0-6 3 3 0 0 1 0 6z"
                />
              </svg>
            </span>
            &bull;
            <p class="px-2">{{ apartment.address }}</p>
          </div>
        </div>

        <!-- /.col sx -->
      </div>

      <div class="my-3 d-flex justify-content-center align-items-center">
        <img
          style="
            width: 100%;
            height: 600px;
            object-fit: cover;
            object-position: bottom;
          "
          class="rounded-3"
          :src="'/storage/' + apartment.thumb"
          :alt="apartment.title"
        />
      </div>
      <!-- /titleAndThumb -->

      <!-- INFO APPARTAMENTO -->
      <div class="row row-cols-1 row-cols-lg-2 mt-4 border-bottom" id="hosting">
        <div class="my-3">
          <div class="row border-bottom pb-1">
            <div class="d-flex justify-content-between align-items-top">
              <div
                class="
                  apartment-info
                  d-flex
                  justify-content-between
                  align-items-center
                "
              >
                <div>
                  <h3 class="font-weight-bold">
                    <strong>
                      {{ apartment.title }}
                    </strong>
                    <br />
                  </h3>
                  <p>
                    Host:
                    {{ apartment.user ? apartment.user.name : "" }}
                  </p>
                </div>
              </div>
              <div class="profile-img">
                <img
                  style="width: 100px; aspect-ratio: 1/1"
                  class="rounded-circle"
                  src="https://picsum.photos/200/300"
                  alt=""
                />
              </div>
            </div>
          </div>
          <div class="row">
            <div class="col mt-4">
              <h5>Informazioni alloggio:</h5>
              <ul>
                <li><strong>Camere</strong> : {{ apartment.rooms }}</li>
                <li><strong>Letti</strong> : {{ apartment.beds }}</li>
                <li><strong>Bagni</strong> : {{ apartment.baths }}</li>
              </ul>
            </div>
            <div class="services mt-2">
              <h5>Servizi:</h5>
              <ul>
                <li v-for="service in apartment.services" :key="service.id">
                  <span v-html="service.icon"></span>

                  {{ service.name }}
                </li>
              </ul>
            </div>
          </div>
        </div>
        <div>
          <div class="map">
            <div id="map" style="width: 100%; height: 100%"></div>
          </div>
        </div>
        <!-- /.col dx-->

        <!-- /.col info hosting -->
      </div>
      <!-- /.col sx-->

      <!-- /HostingAndbooking -->
      <div class="col mt-4 border-bottom mb-3">
        <h5>Descrizione alloggio:</h5>
        <p class="description">
          {{ apartment.description }}
        </p>
      </div>
      <!-- /Description -->

      <!-- Gallery -->
      <div class="gallery">
        <h5>Galleria:</h5>

        <div
          class="
            row
            row-cols-1
            row-cols-md-2
            row-cols-lg-3
            row-cols-lg-4
            row-cols-xl-5
            g-3
          "
        >
          <!--           <div class="col" v-for="image in apartment.images" :key="image.id">
            <div class="img-container h-100">
              <img
                style="width: 100%; object-fit: cover; object-position: center"
                class="rounded-3 h-100 img-fluid"
                :src="'/storage/' + image.src"
                :alt="apartment.title"
              />
            </div>
          </div> -->
          <div
            class="col"
            v-for="(image, index) in apartment.images"
            :key="image.id"
          >
            <div class="img-container h-100">
              <img
                style="height: 100px"
                class="rounded-3 h-100 img-fluid"
                v-lazy="'/storage/' + image.src || '/storage/' + image.src"
                @click="openGallery(index)"
              />
            </div>
          </div>
        </div>
        <!--  Implementare successivamente l'eventualità che nella galleria non ci sono immagini  <div>
          <p> Non sono presenti immagini nella galleria </p>
        </div> -->
      </div>
      <!-- Gallery Component -->

      <LightBox
        ref="lightbox"
        :media="media"
        :show-caption="true"
        :show-light-box="false"
        :autoPlay="false"
      />

      <div class="message mt-4">
        <h3>Contatta il proprietario dell'appartamento:</h3>
        <form class="pb-3" @submit.prevent="sendMessage">
          <div v-if="success" class="alert alert-success" role="alert">
            <h3>{{ message }}</h3>
          </div>
          <div class="mb-3 row">
            <div class="sx col-md-6">
              <div class="group my-5">
                <input
                  v-model="email"
                  required
                  type="email"
                  name="email"
                  id="email"
                  class="input"
                  placeholder=""
                />
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="full_name" class="form-label">Email</label>
              </div>

              <div class="group my-5">
                <input
                  required
                  v-model="full_name"
                  type="text"
                  name="full_name"
                  id="full_name"
                  class="input"
                  placeholder=""
                />
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="full_name" class="form-label">Nome e Cognome</label>
              </div>

              <div class="group my-5">
                <select
                  v-model="subject"
                  required
                  type="text"
                  class="input"
                  name="subject"
                  id="subject"
                  aria-describedby="subjecthelpId"
                >
                <option>informazione prenotazioni</option>
                <option>informazione servizi</option>
                <option>informazione disponibilità</option>
                <option>altro</option>
                </select>
                
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="full_name" class="form-label">Subject</label>
              </div>
              <small id="subjecthelpId" class="form-text text-muted"
                >Inserisci il "Subject" dell'email</small
              >
            </div>

            <div class="dx col-md-6">
              <div class="group mt-3">
                <textarea
                  v-model="content"
                  required
                  type="text"
                  class="input"
                  name="content"
                  id="content"
                  rows="6"
                  aria-describedby="subjecthelpId"
                ></textarea>
                <span class="highlight"></span>
                <span class="bar"></span>
                <label for="content" class="form-label">Messaggio:</label>
              </div>
            </div>
          </div>

          <button type="submit">
            <div class="svg-wrapper-1">
              <div class="svg-wrapper">
                <svg
                  xmlns="http://www.w3.org/2000/svg"
                  viewBox="0 0 24 24"
                  width="24"
                  height="24"
                >
                  <path fill="none" d="M0 0h24v24H0z"></path>
                  <path
                    fill="currentColor"
                    d="M1.946 9.315c-.522-.174-.527-.455.01-.634l19.087-6.362c.529-.176.832.12.684.638l-5.454 19.086c-.15.529-.455.547-.679.045L12 14l6-8-8 6-8.054-2.685z"
                  ></path>
                </svg>
              </div>
            </div>
            <span>invia</span>
          </button>
        </form>
      </div>
      <!-- /Services -->
    </div>
  </div>
  <!-- /#SingleApartment -->
</template>

<script>
import tt from "@tomtom-international/web-sdk-maps";
import VueLazyLoad from "vue-lazyload";
import LightBox from "vue-image-lightbox";
export default {
  name: "Apartment",
  components: {
    LightBox,
  },
  data() {
    return {
      apartment: "",
      success: false,
      query: "",
      radius: "",
      email: "",
      full_name: "",
      content: "",
      subject: "",
      message: "",
      lat: "",
      lon: "",
      media: [],
    };
  },
  methods: {
    getApartment() {
      this.query = this.$route.params.query;
      this.radius = this.$route.params.radius;
      axios
        .get("/api/apartments/" + this.$route.params.slug)
        .then((response) => {
          this.apartment = response.data;
          console.log(response.data.images);
          this.lat = response.data.lat;
          this.lon = response.data.lon;
          response.data.images.forEach((element, index) => {
            console.log(element.src);
            let newImage = {
              thumb: "/storage/" + element.src,
              src: "/storage/" + element.src,
              caption: "Immagine n°" + (index + 1),
            };

            this.media.push(newImage);
          });

          this.getMap();
        })
        .catch((e) => {
          console.error(e);
        });
    },
    sendMessage() {
      this.success = false;
      let data = {
        email: this.email,
        full_name: this.full_name,
        content: this.content,
        apartment_id: this.apartment.id,
        subject: this.subject,
      };

      axios
        .post("/message/create", data)
        .then((response) => {
          (this.content = ""), (this.subject = ""), (this.success = true);
          this.message = response.data.message;
        })
        .catch((e) => {
          console.error(e);
          this.success = true;
          this.message = "ERRORE - Messaggio Non Inviato";
        });
    },
    getMap() {
      let cordinate = [this.lon, this.lat];
      console.log(cordinate);
      var map = tt.map({
        key: "wwBjO0iyrGBDWYAR81J5EY7D4Y0HJGQj",
        container: "map",
        center: cordinate,
        zoom: 13,
      });

      let marker = new tt.Marker().setLngLat(cordinate).addTo(map);
      let popupOffsets = {
        top: [0, 0],
        bottom: [0, -45],
        "bottom-right": [0, -70],
        "bottom-left": [0, -70],
        left: [25, -35],
        right: [-25, -35],
      };

      // Show pop-up
      let popup = new tt.Popup({
        offset: popupOffsets,
      }).setHTML(this.apartment.title + "<br>" + this.apartment.address);
      marker.setPopup(popup).togglePopup();
    },
    openGallery(index) {
      this.$refs.lightbox.showImage(index);
    },
  },
  mounted() {
    this.getApartment();
    if (window.User) {
      this.email = window.User.email;
      this.full_name = window.User.name;
    }
  },
};
</script>

<style lang='scss' scoped>
.map {
  height: 500px;
  width: 100%;
  margin-bottom: 3rem;
}
.group {
  position: relative;
}

.input {
  font-size: 16px;
  margin: 15px 0;
  padding: 10px 10px 10px 5px;
  display: block;
  width: 80%;
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

.input:focus ~ label,
.input:valid ~ label {
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
  content: "";
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

.input:focus ~ .bar:before,
.input:focus ~ .bar:after {
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

@media screen and (max-width: 720px) {
  .input {
    width: 100%;
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

