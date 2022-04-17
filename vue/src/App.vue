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
      <Home @logout="logout" />
    </div>
  </section>
</template>

<script>
// Components
import Login from "@/components/Auth/Login";
import ResetPassword from "@/components/Auth/ResetPassword";
import Home from "@/components/Home";

import axios from "axios";

export default {
  name: "App",
  data() {
    return {
      authData: {
        loggedIn: localStorage.token,
        user: localStorage.username,
        resetPass: true,
      },
    };
  },
  methods: {
    getLoginData(data) {
      const token = `Bearer ${data.token}`;
      localStorage.setItem("token", token);
      this.authData.loggedIn = localStorage.token;
    },

    getResetPassData() {
      localStorage.clear();
      this.authData.loggedIn = localStorage.token;
      this.authData.resetPass = false;
    },

    me(data) {
      console.log(data);
    },

    logout() {
      localStorage.clear();
      this.authData.loggedIn = localStorage.token;
    },
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
