<template>
  <div class="book-card bg-white shadow-md p-4 rounded-lg flex flex-col items-center w-full max-w-sm">
    <img :src="book.cover_image" :alt="book.title" class="w-40 h-56 object-contain rounded">
    
    <div class="flex-1">
      <h3 class="text-lg font-bold">{{ book.title }}</h3>
      <p class="text-gray-600">Author: {{ book.author }}</p>
      <p class="text-gray-600">Price: £{{ book.price }}</p>

      <div class="flex items-center space-x-4 mt-2">
        <div class="cart-controls">
          <button v-if="!inCart"
            @click="$emit('add-to-cart', book.id)"
            class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">
            Add to Cart
          </button>
          <div v-else class="flex items-center space-x-2">
            <button @click="$emit('decrease-quantity', book.id)"
              class="bg-red-500 text-white px-2 py-1 rounded">−</button>
            <span class="text-lg font-bold w-8 text-center">{{ cartQuantity }}</span>
            <button @click="$emit('increase-quantity', book.id)"
              class="bg-blue-500 text-white px-2 py-1 rounded">+</button>
          </div>
        </div>
        <a :href="`/books/${book.id}`" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">
          View Details
        </a>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  props: {
    book: Object,
    inCart: Boolean,
    cartQuantity: Number
  }
};
</script>
