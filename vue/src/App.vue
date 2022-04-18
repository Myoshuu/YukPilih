<template>
  <Login
    v-if="!authData.loggedIn"
    @logIn="getLoginData"
    @me="me"
    v-bind="authData.loggedIn"
  />
  <section class="container-main" v-else>
    <ResetPassword v-if="authData.resetPass" @resetPass="getResetPassData" />
    <!-- <button type="button" @click="reset">RESET PASS</button> -->
    <div v-else>
      <Home @logout="logout" :user="this.authData.user.username" />
    </div>
  </section>
</template>

<script>
// Components
import Login from "@/components/Auth/Login";
import ResetPassword from "@/components/Auth/ResetPassword";
import Home from "@/components/Home";

import axios from "axios";

var url = "http://localhost:8000/api";
export default {
  name: "App",
  data() {
    return {
      authData: {
        loggedIn: localStorage.token,
        user: {},
        resetPass: false,
      },
    };
  },
  methods: {
    getLoginData(data) {
      const token = `Bearer ${data.token}`;
      localStorage.setItem("token", token);
      this.authData.loggedIn = localStorage.token;
      // this.authData.resetPass = true;
    },

    me() {
      axios.defaults.headers.common["Authorization"] = `${localStorage.token}`;
      axios.post(`${url}/auth/me`).then((res) => {
        this.authData.user = res.data;
      });
    },

    getResetPassData() {
      localStorage.clear();
      this.authData.loggedIn = localStorage.token;
      this.authData.resetPass = true;
    },

    logout() {
      localStorage.clear();
      this.authData.loggedIn = localStorage.token;
    },
  },
  mounted() {
    if (localStorage.token) {
      this.me();
    }
  },
  components: {
    Login,
    ResetPassword,
    Home,
  },
};
</script>

<style>
@import url("https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;1,100;1,200;1,300;1,400;1,500;1,600&display=swap");
* {
  padding: 0;
  margin: 0;
  box-sizing: border-box;
}

body {
  font-family: "Poppins";
  width: 100vw;
  height: 100vh;
}

div.container-main {
  width: 100vw;
  height: 100vh;
  display: grid;
  /* grid-template-rows: 10% auto; */
}
</style>
