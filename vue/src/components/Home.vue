<template>
  <section class="container-home">
    <div class="overlay"></div>
    <nav class="navbar-main">
      <div class="content">
        <div></div>
        <p class="title">YukPilih</p>
        <div class="profile">
          <p>{{ user }}</p>
          <span>|</span>
          <a href="#" @click="logout">Logout</a>
        </div>
      </div>
    </nav>
    <div class="fab" @click="toggle">
      <span> + </span>
    </div>
    <div class="modal" id="modal">
      <div class="modal-form">
        <div class="form-wrapper">
          <form method="post">
            <div class="form-control">
              <input type="text" id="title" name="title" placeholder=" " />
              <label for="title">Title</label>
            </div>
            <div class="form-control">
              <input
                type="text"
                name="description"
                id="description"
                placeholder=" "
              />
              <label for="description">Description</label>
            </div>
            <div class="form-control">
              <input
                type="datetime-local"
                name="deadline"
                id="deadline"
                placeholder=" "
              />
              <label for="deadline">Deadline</label>
            </div>
            <div class="action">
              <button type="submit">create</button>
              <button>cancel</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </section>
</template>

<script>
// Component
import Button from "@/components/Button";

import axios from "axios";
var url = "http://localhost:8000/api";

export default {
  name: "Home",
  props: {
    user: String,
  },
  data() {
    return {
      token: localStorage.token,
    };
  },

  components: {
    Button,
  },

  methods: {
    logout() {
      axios
        .post(`${url}/auth/logout`, this.token, {
          headers: { Authorization: localStorage.token },
        })
        .then((res) => {
          this.$emit("logout");
        })
        .catch((err) => {
          console.log(err.response.data.message);
        });
    },

    toggle() {
      // var fab = document.querySelector(".fab");
      // fab.classList.toggle("active");

      var modal = document.getElementById("modal");
      modal.classList.toggle("active");
    },
  },
};
</script>

<style scoped>
body {
  height: 100vh;
}

.navbar-main {
  /* border: 2px solid black; */
  /* padding: 5px 0; */
  color: white;
}

.overlay {
  position: fixed;
  display: none;
  background: rgba(0, 0, 0, 0.15);
  top: 0;
  z-index: 1;
  left: 0;
  width: 100vw;
  height: 100vh;
}

.navbar-main .content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #3f51b5;
  padding: 12px 20px;
  box-shadow: 0 5px 10px rgba(0, 0, 0, 0.15);
}

.content .title {
  font-weight: 500;
  font-size: 16px;
}

.content .profile {
  display: flex;
  align-items: center;
}

.profile span {
  margin: 0 5px;
  font-size: 12px;
  font-weight: 500;
}

.profile p {
  font-size: 12px;
  text-transform: uppercase;
  font-weight: 500;
}

.profile a {
  text-transform: uppercase;
  /*  */
  color: white;
  font-weight: 500;
  font-size: 12px;
  text-decoration: none;
}

/* FAB CSS */
.fab {
  z-index: 3;
  background: #3f51b5;
  position: fixed;
  bottom: 20px;
  right: 30px;
  width: 45px;
  height: 45px;
  border-radius: 50px;
  cursor: pointer;
  box-shadow: 4px 5px 10px rgba(0, 0, 0, 0.15);
}

.fab span {
  position: relative;
  display: flex;
  font-size: 20px;
  width: 100%;
  color: white;
  height: 100%;
  justify-content: center;
  align-items: center;
  transition: 0.2s ease-in-out;
}

.fab.active span {
  transform: rotate(125deg);
}

/* Modal CSS */
.modal-form {
  position: absolute;
  top: 50%;
  left: 50%;
  padding: 10px;
  transform: translate(-50%, -50%) scale(0);
  /* border: 2px solid black; */
  /* backdrop-filter: brightness(60%); */
  width: 250px;
  height: 350px;
  z-index: 2;
  background: white;
  box-shadow: 2px 3px 10px rgba(0, 0, 0, 0.15);
  border-radius: 5px;
  transition: 150ms cubic-bezier(0.165, 0.84, 0.44, 1);
}

.modal.active .overlay {
  display: block;
}

.modal.active .modal-form {
  transform: translate(-50%, -50%) scale(1);
}

/* Form */

.form-wrapper {
  display: flex;
  justify-content: center;
  align-items: center;
  /* transform: scale(0.5); */
  /* border: 2px solid red; */
}

form {
  position: relative;
  /* margin: em 0; */
}

.form-control {
  display: flex;
  align-items: center;
  margin: 1.6em 0;
}

.form-control input {
  outline: none;
  border: none;
  z-index: 1;
  background: unset;
  /* margin-top: 15px; */
  border-bottom: 1px solid #000000ad;
  padding: 5px 0;
  width: 100%;
}

.form-control label {
  position: absolute;
  left: 0;
  z-index: 0;
  /* margin-bottom: 10px; */
  font-weight: 300;
  color: #000000ad;
  font-size: 15px;
  transform-origin: 0 0;
  transition: 200ms linear;
}

.form-control input:focus + label,
input:not(:placeholder-shown) + label {
  transform: translateY(-1.4em) scale(0.9);
  font-size: 14px;
  font-weight: 500;
  transition: 200ms linear;
}

.form-control input:focus + label {
  color: #3f51b5;
}

.form-control input:focus {
  border-bottom: 2px solid #3f51b5;
}
</style>