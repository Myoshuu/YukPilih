<template>
  <section class="container-home">
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
  </section>
</template>

<script>
import axios from "axios";
var url = "http://localhost:8000/api";

export default {
  name: "Home",
  data() {
    return {
      token: localStorage.token,
      user: "",
    };
  },
  mounted() {
    if (localStorage.username) {
      this.user = localStorage.username;
    }
  },
  components: {
    //
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
  },
};
</script>

<style scoped>
.navbar-main {
  /* border: 2px solid black; */
  /* padding: 5px 0; */
  color: white;
}

.navbar-main .content {
  display: flex;
  justify-content: space-between;
  align-items: center;
  background: #3f51b5;
  padding: 12px 20px;
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
</style>