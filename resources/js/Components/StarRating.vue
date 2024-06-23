<template>
    <div class="star-rating">
      <span v-for="n in 5" :key="n" class="star" :class="{ 'filled': n <= rating }">
        ★
      </span>
    </div>
  </template>

  <script>
  export default {
    props: {
      rating: {
        type: Number,
        required: true,
      },
    },
  };
  </script>

  <style scoped>
  .star-rating {
    font-size: 1.5rem;
    color: #ccc; /* Cor das estrelas vazias */
  }

  .star.filled {
    color: #f59e0b; /* Cor das estrelas preenchidas (laranja) */
  }
  </style>
