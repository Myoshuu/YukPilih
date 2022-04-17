<template>
  <div class="container">
    <form @submit.prevent="formDataReset(resetPassData)" method="post">
      <div class="form-control">
        <input
          type="password"
          id="old_password"
          name="old_password"
          placeholder=" "
          v-model="resetPassData.old_password"
        />
        <label for="old_password">Old Password</label>
      </div>
      <div class="form-control">
        <input
          type="password"
          id="new_password"
          name="new_password"
          placeholder=" "
          v-model="resetPassData.new_password"
        />
        <label for="new_password">New Password</label>
      </div>
      <div class="form-control">
        <input
          type="password"
          id="confirm_password"
          name="confirm_password"
          placeholder=" "
          v-model="resetPassData.confirm_password"
        />
        <label for="confirm_password">Confirm Password</label>
      </div>
      <Button label="Reset" />
    </form>
  </div>
</template>

<script>
// Axios
import axios from "axios";

// Components
import Button from "@/components/Button";

var url = "http://localhost:8000/api";

export default {
  name: "ResetPassword",
  data() {
    return {
      resetPassData: {
        old_password: "",
        new_password: "",
        confirm_password: "",
      },
    };
  },
  methods: {
    formDataReset(resetPassData) {
      axios
        .post(`${url}/auth/reset_password`, resetPassData, {
          headers: { Authorization: localStorage.token },
        })
        .then((res) => {
          this.$emit("resetPass");
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
div.container {
  height: 100vh;
  display: flex;
  /* border: 2px solid black; */
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