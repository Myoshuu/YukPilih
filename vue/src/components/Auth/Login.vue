<template>
  <div class="container-login">
    <form @submit.prevent="formDataLogin(loginData)" method="post">
      <div class="form-control">
        <input
          type="text"
          id="username"
          name="username"
          placeholder=" "
          v-model="loginData.username"
        />
        <label for="username">Username</label>
      </div>
      <div class="form-control">
        <input
          type="password"
          id="password"
          name="password"
          placeholder=" "
          v-model="loginData.password"
        />
        <label for="password">Password</label>
      </div>
      <Button label="Login" />
    </form>
  </div>
</template>

<script>
// Axios
import axios from "axios";

// Component
import Button from "@/components/Button";

var url = "http://localhost:8000/api";

export default {
  name: "Login",
  data() {
    return {
      loginData: {
        username: "",
        password: "",
      },
    };
  },
  methods: {
    formDataLogin(loginData) {
      axios
        .post(`${url}/auth/login`, loginData)
        .then((res) => {
          this.$emit("logIn", res.data);
          this.$emit("me");
        })
        .catch((err) => {
          alert(err.response.data.message);
        });
    },
  },
  components: {
    Button,
  },
};
</script>

<style scoped>
div.container-login {
  height: 100vh;
  display: flex;
  justify-content: center;
  align-items: center;
}

form {
  position: relative;
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
  border-bottom: 1.5px solid #000000a9;
  padding: 5px 0;
  width: 200px;
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