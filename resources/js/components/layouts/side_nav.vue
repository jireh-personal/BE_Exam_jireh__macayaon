<template lang="">
    <div class="col-auto col-md-3 col-xl-2 px-sm-2 px-0 bg-dark">
    
                    <div class="d-flex flex-column align-items-center align-items-sm-start px-3 pt-2 text-white min-vh-100">
                        <ul class="nav nav-pills flex-column mb-sm-auto mb-0 align-items-sm-start" id="menu">
                            <li class="nav-item">
                                <router-link :to="{ name: 'create-product' }" class="nav-link px-0 text-light">Create Product</router-link>
                            </li>
                            <li class="nav-item">
                                <router-link :to="{ name: 'products' }" class="nav-link px-0 text-light">Products</router-link>
                            </li>
                        </ul>
                        <hr>
                    </div>
                    
                </div>
</template>
<script>
export default {
    
}
</script>
<style lang="">
    
</style>