<template>
  <div class="container-btn">
    <button type="submit" class="btn">{{ label }}</button>
  </div>
</template>

<script>
export default {
  name: "Button",
  props: {
    label: String,
  },
};
</script>

<style scoped>
.container-btn {
  margin-top: 2em;
  display: flex;
  justify-content: center;
  align-items: center;
}

button {
  /* Font */
  font-family: "Poppins";

  padding: 10px 15px;
  background: #3f51b5;
  color: white;
  text-transform: uppercase;
  letter-spacing: 1.2px;
  border: none;
  border-radius: 5px;
  font-weight: 550;
  font-size: 0.8em;
  cursor: pointer;
  box-shadow: 2px 3px 10px #0000006e;
  transition: 0.2s ease-in-out;
}

button:hover {
  background: #344297;
  box-shadow: none;
}
</style>