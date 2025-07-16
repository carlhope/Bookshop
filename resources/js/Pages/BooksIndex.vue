<template>
  <div class="container mx-auto p-6">
    <h1 class="text-2xl font-bold mb-4">All Books</h1>

    <div v-if="books?.data?.length"> <!-- ✅ Corrected -->
      <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        <BookCard
          v-for="book in books.data"
          :key="book.id + cartVersion"
          :book="book"
          :cartItem="getCartItem(book.id).value"
          @add-to-cart="addToCart"
          @increase-quantity="increaseQuantity"
          @decrease-quantity="decreaseQuantity"
        />
      </div>
    </div>


    <p v-else class="text-gray-500 text-lg">Loading books...</p>
      <!-- Pagination Links -->
      <template v-for="(link, index) in books.links">
          <button
              v-if="link?.url"
              :key="index"
              @click="router.get(link.url, {}, { preserveScroll: true })"
              v-html="link.label"
              class="px-3 py-2 rounded bg-gray-200 hover:bg-gray-300 text-sm"
          />
      </template>
  </div>
</template>

<script setup>
import { ref, computed, watch, nextTick } from 'vue'
import { usePage } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import BookCard from '../components/BookCard.vue'

// Fetch data from Laravel session via Inertia
const page = usePage()
const books = computed(() => page.props.books)
const cart = ref({})
const cartVersion = ref(0) // Used to force re-renders

// Computed function to ensure cart updates properly
const getCartItem = (bookId) => computed(() => {
  return cart.value[bookId] ? { ...cart.value[bookId] } : null;
});

const updateCart = () => {
  const cartData = JSON.parse(JSON.stringify(page.props.cart)) || {}
  cart.value = {}

  nextTick(() => {
    cart.value = { ...cartData }
    cartVersion.value += 1
    console.log("Updated cart state:", cart.value)
      console.log(books)
  })
}

watch(() => page.props.cart, (newCart) => {
  console.log("Cart updated from Laravel:", newCart)
  updateCart()
}, { deep: true })

const addToCart = (bookId) => {
  router.post(`/cart/add/${bookId}`, {}, {
    preserveScroll: true,
    onSuccess: ({ props }) => {
      console.log("Cart response from Laravel:", props.cart);


      cart.value = JSON.parse(JSON.stringify(props.cart));
      cartVersion.value += 1;
    }
  });
};

const increaseQuantity = (bookId) => {
  if (cart.value[bookId]) {
    cart.value[bookId].quantity++;
    router.post(`/cart/update/${bookId}`, { quantity: cart.value[bookId].quantity }, {
      preserveScroll: true,
      onSuccess: updateCart
    })
  }
}

const decreaseQuantity = (bookId) => {
  if (cart.value[bookId]?.quantity > 1) {
    cart.value[bookId].quantity--;
    router.post(`/cart/update/${bookId}`, { quantity: cart.value[bookId].quantity }, {
      preserveScroll: true,
      onSuccess: updateCart
    })
  } else {
    delete cart.value[bookId]
    router.post(`/cart/remove/${bookId}`, {}, {
      preserveScroll: true,
      onSuccess: updateCart
    })
  }
}
updateCart()
</script>
