<template lang="">
    <div class="col py-3">
    <div class="alert alert-dark" v-text="user"></div>
        <div class="container-fluid bg-light">
            <div class="row">
                <div class="col p-2">                    
                    <div class="d-flex align-item-start">
                        <h2>Product List</h2>
                         <div class="col">
                            <router-link :to="{ name: 'create-product' }" class="btn btn-secondary btn-sm float-end">Create</router-link>
                        </div>
                    </div>
                    
                   
                    <div class="row">
                        <div class="col-lg-6 col-md-12 col-sm-12">
                            <div class="row form-group mb-1">
                                <label class="col-lg-2 col-md-2 col-sm-12 col-form-label" for="search">Search:</label>
                                <div class="col-lg-5 col-md-12 col-sm-12">
                                    <input type="text" class="form-control" placeholder="Name or Description" v-on:keyup="searchProduct($event)" :value="search">
                                </div>
                            </div>
                        </div>                        
                        <div class="col-lg-6">
                            <div class="row form-group mb-1">
                                <div class="col-lg-5 col-md-12 col-sm-12 ms-auto">
                                    <select class="form-control" v-on:change="filterProduct($event)">
                                        <option value="0">-- filter category --</option>
                                        <option v-for="category in category" :value="category.id">{{ category.category }}</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                </div>
                
                <table class="table table-hover table-bordered">
                    <thead>
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Category</th>
                        <th scope="col">Name</th>
                        <th scope="col">Description</th>
                        <th scope="col">Date Created</th>
                        <th scope="col">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="(product,index) in products" :key="index">
                        <th scope="row">{{ (index + from) }}</th>
                        <td><span class="d-inline-block text-truncate" style="max-width: 150px;">{{ product.category }}</span></td>
                        <td><span class="d-inline-block text-truncate" style="max-width: 150px;">{{ product.name }}</span></td>
                        <td><span class="d-inline-block text-truncate" style="max-width: 200px;">{{ product.description }}</span></td>
                        <td>{{ product.formatDateAdded }}</td>
                        <td class="text-center">
                            <router-link :to="{ name: 'update-product',params: {id: product.id} }" class="btn btn-primary btn-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                            </svg>
                            </router-link>
                            <button v-on:click="deleteProduct(product.id)" class="btn btn-danger btn-sm">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash" viewBox="0 0 16 16">
                                <path d="M5.5 5.5A.5.5 0 0 1 6 6v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm2.5 0a.5.5 0 0 1 .5.5v6a.5.5 0 0 1-1 0V6a.5.5 0 0 1 .5-.5zm3 .5a.5.5 0 0 0-1 0v6a.5.5 0 0 0 1 0V6z"/>
                                <path fill-rule="evenodd" d="M14.5 3a1 1 0 0 1-1 1H13v9a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V4h-.5a1 1 0 0 1-1-1V2a1 1 0 0 1 1-1H6a1 1 0 0 1 1-1h2a1 1 0 0 1 1 1h3.5a1 1 0 0 1 1 1v1zM4.118 4 4 4.059V13a1 1 0 0 0 1 1h6a1 1 0 0 0 1-1V4.059L11.882 4H4.118zM2.5 3V2h11v1h-11z"/>
                                </svg>
                            </button>
                        </td>
                        </tr>
                    </tbody>
                    </table>
                    <nav v-if="hidePaginate==false">
                        <ul class="pagination float-end">                            
                            <li v-bind:class="[disabledPrevPage===true ? 'page-item disabled' : 'page-item']"><button v-on:click="previousPage(pPage)" :disabled="disabledPrevPage" class="page-link">Previous</button></li>
                            <li v-bind:class="[disabledNextPage===true ? 'page-item disabled' : 'page-item']"><button v-on:click="nextPage(nPage)" :disabled="disabledNextPage" class="page-link">Next</button></li>
                        </ul>
                    </nav>
            </div>
        </div>
    </div>
</template>
<script>

export default {
    data(){
        return{
            search: '',
            products: {},
            links: {},
            category: {},
            categoryID: 0,
            nPage: 1,
            pPage:1,
            from: 1,
            lastPage: 0,
            disabledNextPage: false,
            disabledPrevPage: true,
            hidePaginate: false,
            secret: '',
            user: ''
        }
    },
    methods:{
        async loadProductList(page=1){
            const get = await axios.get('/api/product?page='+page);
            console.log(get);
            if(get.status === 200)
            {
                this.products    = get.data.data;
                this.links       = get.data.data.links;
                this.lastPage    = get.data.meta.last_page;
                this.from        = get.data.meta.from;
                if(get.data.meta.total <= 15)
                {
                    this.hidePaginate = true;
                }
                else 
                {
                    this.hidePaginate = false;
                }
            }
        },
        nextPage(page){
            this.nPage++;
            this.pPage = this.nPage - 1;
            this.loadProductList(this.nPage)
            this.disabledPrevPage = false;
            if(this.nPage >= this.lastPage)
            {
                this.disabledNextPage = true;
            }
        },
        previousPage(page){
            this.nPage--;
            this.loadProductList(page);
            this.pPage--;
            this.disabledNextPage = false;
            if(this.pPage < 1)
            {
                this.disabledPrevPage = true;
            }
        },
        async loadCategory(){
            const get = await axios.get('/api/category');
            if(get.status === 200)
            {

                if(get.data.status === 'success')
                {
                    this.category = get.data.result;
                }
            }
        },
        async filterProduct(event){
            const get = await axios.get(`/api/product/${event.target.value}/filter`);
            if(get.status === 200)
            {
                // this.categoryID = event.target.value;
                this.search = '';
                this.products = get.data.data;
                this.links       = get.data.data.links;
                this.lastPage    = get.data.meta.last_page;
                this.from        = get.data.meta.from;
                if(get.data.meta.total <= 15)
                {
                    this.hidePaginate = true;
                }
                else
                {
                    this.hidePaginate = false;
                }
            }
        },
        async searchProduct(event){
            this.search = event.target.value;
            const get = await axios.post(`/api/product/search`,{
                search: event.target.value
            }).then(response => {
                console.log(response.data.data.length);
                if(response.status === 200)
                {
                    this.products = response.data.data;
                    this.links       = response.data.data.links;
                    this.lastPage    = response.data.meta.last_page;
                    this.from        = response.data.meta.from;
                    if(response.data.meta.total <= 15)
                    {
                        this.hidePaginate = true;
                    }
                    else
                    {
                        this.hidePaginate = false;
                    }
                }

            }).catch(e => {
                console.log(e);
            });
        },
        deleteProduct(id){
            const dis = this;
            Swal.fire({
                title: 'Are you sure you want to delete this Product?',
                text: "You won't be able to revert this!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Yes, delete it!'
            }).then((result) => {
                if(result.isConfirmed === true)
                {
                    const get = axios.delete(`/api/product/${id}`).then(response => {
                        if(response.status === 200)
                        {
                            dis.loadProductList();
                        }
                    }).catch(e => { console.log(e); });
                }                
            });
            return;
            
        },
        async loadSecret(){
            const get = await axios.get('/secret');
            if(get.status === 200)
            {
                if(get.data.status === 'success')
                {
                    localStorage.setItem('csrf_token',get.data.result.token);
                    localStorage.setItem('api_token', get.data.result.apiToken);

                    this.user = `You are logged as ${get.data.result.name}`;
                }
            }
        }
    },
    mounted(){        
        this.loadProductList();
        this.loadCategory();
        this.loadSecret();
     }
}
</script>
<style lang="">
    
</style>