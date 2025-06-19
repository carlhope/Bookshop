<template>
  <div v-if="book" class="book-card bg-white shadow-md p-4 rounded-lg flex flex-col items-center w-full max-w-sm">
    <img :src="book.cover_image || '/default-cover.jpg'" :alt="book.title" class="w-40 h-56 object-contain rounded">

    <div class="flex-1">
      <h3 class="text-lg font-bold">{{ book.title }}</h3>
      <p class="text-gray-600">Author: {{ book.author }}</p>
      <p class="text-gray-600">Price: £{{ book.price }}</p>

      <div class="flex items-center space-x-4 mt-2">
        <div class="cart-controls">
          <button v-if="!cartItem || cartItem.quantity === undefined || cartItem.quantity === 0"
            @click="$emit('add-to-cart', book.id)"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Add to Cart
          </button>

          <template v-if="cartItem?.quantity && cartItem.quantity > 0">
            <button @click="$emit('decrease-quantity', book.id)"
              class="bg-red-500 text-white px-2 py-1 rounded">−</button>
            <span class="text-lg font-bold w-8 text-center">{{ cartItem.quantity }}</span>
            <button @click="$emit('increase-quantity', book.id)"
              class="bg-blue-500 text-white px-2 py-1 rounded">+</button>
          </template>
        </div>

        <a :href="`/books/${book.id}`" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
          View Details
        </a>
      </div>
    </div>
  </div>
  <p v-else class="text-gray-500 text-lg">Loading book data...</p>
</template>

<script setup>
defineProps({
  book: Object,
  cartItem: Object
});
</script>

