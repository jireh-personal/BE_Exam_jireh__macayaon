<template lang="">
    <div class="col py-3">
    <div class="alert alert-dark" v-text="user"></div>
        <div class="container col-lg-5 col-md-5 col-sm-12">
            <div class="card">
                <div v-if="id===undefined" class="card-header">Create Product - Step 1</div>
                <div v-if="id!==undefined" class="card-header">Update Product - Step 1</div>
                <div class="card-body">
                    <div clss="row">
                        <label class="col">Name</label>
                        <div class="col">
                            <input type="text" class="form-control" v-model="name">
                            <p class="text-danger" v-text="errors.name"></p>
                        </div>                        
                    </div>
                    <div clss="row">
                        <label class="col">Category</label>
                        <div class="col">
                            <select class="form-control" v-model="category_id">
                                <option value=""></option>
                                <option v-for="category in category" :value="category.id">{{ category.category }}</option>
                            </select>
                            <p class="text-danger" v-text="errors.category_id"></p>
                        </div>                        
                    </div>
                    <div clss="row">
                        <label class="col">Description</label>
                        <div class="col">
                            <textarea class="form-control" v-model="description" style="min-height: 100px;"></textarea>
                            <p class="text-danger" v-text="errors.description"></p>
                        </div>                        
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col ms-auto">
                    <button class="btn btn-primary btn-sm float-end" v-on:click="StepOne()">Next</button>
                    </div>                    
                </div>
            </div>
        </div>
    </div>
</template>
<script>
export default {
    data(){
        return{
            id: this.$route.params.id,
            category: {},
            category_id: '',
            name: '',
            description: '',
            errors: {
                name: '',
                description: '',
                category_id: ''
            },
            user: ''
        }
    },
    methods: {
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
        async StepOne(){
            const param = {
                name: this.name,
                description: this.description,
                category_id: this.category_id
            }
            this.errors = {
                name: '',
                description: '',
                category_id: ''
            }
           await axios.post('/api/product/create/step1',param).then(e => {
                if(e.status === 200)
                {
                    if(e.data.status === 'success')
                    {
                        if(this.id !== undefined)
                        {
                            this.$router.push(`/update-product/step2/${this.id}`);
                        }
                        else 
                        {                            
                            this.$router.push('/create-product/step2');
                        }
                        localStorage.setItem('products.name',this.name);
                        localStorage.setItem('products.category_id',this.category_id);
                        localStorage.setItem('products.description',this.description);
                    }
                }
            }).catch(e => {

                if(e.response.status === 422)
                {
                    for(let i in e.response.data.errors)
                    {
                        this.errors[i] = e.response.data.errors[i][0];
                    }
                }
            });
        },
        // async loadStepOne(){
        //     const get = await axios.get('/api/product/load/step1');
        //     if(get.status === 200)
        //     {
        //         if(get.data.status === 'success')
        //         {
        //             this.name        = get.data.result.name;
        //             this.category_id = get.data.result.category_id;
        //             this.description = get.data.result.description;
        //         }
        //     }
        // },
        async loadEdit(id){
            const get = await axios.get(`/api/product/${id}`);
            if(get.status === 200)
            {
                if(get.data.status === 'success')
                {
                    this.name        = get.data.result.name;
                    this.category_id = get.data.result.category_id;
                    this.description = get.data.result.description;
                }
            }
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
        this.loadSecret();
        this.loadCategory();
        if(this.id !== undefined){
            this.loadEdit(this.id);
        }
        else{
            // this.loadStepOne();
            this.name        = '';
            this.category_id = '';
            this.description = '';
        }
        this.name = localStorage.getItem('products.name');
        this.category_id = localStorage.getItem('products.category_id');
        this.description = localStorage.getItem('products.description');
    }
}
</script>
<style lang="">
    
</style>