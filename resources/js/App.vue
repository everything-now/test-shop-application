<template>
<div>
   <div class="container mt-5">
      <div class="row">
         <div class="col-xs-3 text-center my-5" v-for="product in products" :key="product.id">
            <img class="img-responsive" :src="product.imageUrl" alt="" >
            <h5 class="my-4">{{ product.name }}</h5>
            <p class="text-center ">
                <input v-model="product.quantity" type="number" class="form-control" placeholder="Qty" min="1"/>
            </p>
            <button @click="toCheckout(product)" :disabled="!product.quantity" class="btn btn-sm btn-primary">Buy</button>
         </div>
      </div>
   </div>

    <div class="modal fade show" v-if="product">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">New order</h5>
                <button type="button" class="close" @click="product=null" aria-label="Close">
                <span aria-hidden="true">×</span>
                </button>
            </div>
            <div class="modal-body">
                <input v-model="order.email" type="email" class="form-control my-1" placeholder="Email"/>
                <input v-model="order.phone" type="tel" class="form-control my-1" placeholder="Phone"/>
                <select v-model="order.country_code" type="text" class="form-control my-1" placeholder="Country">
                    <option value="EN">England</option>
                    <option value="US">USA</option>
                    <option value="CA">Canada</option>
                </select>
                <input v-model="order.city" type="text" class="form-control my-1" placeholder="City"/>
                <input v-model="order.zip_postal_code" type="text" class="form-control my-1" placeholder="Zip Code"/>
                <input v-model="order.shipping_adress_1" type="text" class="form-control my-1" placeholder="Address 1"/>
                <input v-model="order.shipping_adress_2" type="text" class="form-control my-1" placeholder="Address 2"/>
                <input v-model="order.shipping_adress_3" type="text" class="form-control my-1" placeholder="Address 3"/>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" @click="product=null">Close</button>
                <button type="button" class="btn btn-primary" @click="orderProduct()" :disabled="!order.email || !order.phone || !order.country_code || !order.city || !order.zip_postal_code || !order.shipping_adress_1">Order</button>
            </div>
            </div>
        </div>
    </div>

</div>
</template>


<script>
import axios from 'axios'

export default {
    data: () => ({
        products: [],
        product: null,
        order: {}
    }),
    methods: {
        getProducts () {
            axios.get('/api/products')
                .then(response => {
                    this.products = response.data.data;
                });
        },
        toCheckout (product) {
            this.product = product;
            this.order.product_id = product.id;
            this.order.quantity = product.quantity;
        },
        orderProduct () {
            axios.post('/api/orders', this.order)
            .then(response => { alert(response.data.message); this.product=null })
            .catch(error => alert(error.response.data.message));
        }
    },
    mounted() {
        this.getProducts()
    },
  }
</script>

<style lang="scss">
    .modal{
        display: block !important;
    }

    .form-control {
        display: inline !important;
        width: 80% !important;
    }
</style>
