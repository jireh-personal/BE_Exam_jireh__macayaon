<template lang="">
    <div class="col py-3">
    <div class="alert alert-dark" v-text="user"></div>
        <div class="container col-lg-5 col-md-5 col-sm-12">
            <div v-bind:class="[step2===true ? 'card' : 'card d-none']">
                <div v-if="id===undefined" class="card-header">Create Product - Step 2</div>
                <div v-if="id!==undefined" class="card-header">Update Product - Step 2</div>
                <div class="card-body">
                    <div clss="row">
                        <label class="col">Select Images</label>
                        <div class="col">
                            <input type="file" multiple class="form-control" v-on:change="setFile">
                            <p class="text-danger" v-for="error in errors.file">{{ error }}</p>
                            <ul class="list-group mt-2" v-for="attachments in attachments">
                                <li class="list-group-item list-group-item-action">{{ attachments.filename }}</li>
                            </ul>
                        </div>                        
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col ms-auto">                
                    <button class="btn btn-primary btn-sm float-end ml-2" v-on:click="StepTwo()">Next</button>
                    <router-link v-if="id===undefined" :to="{ name: 'create-product' }" class="btn btn-secondary btn-sm float-end">Previous</router-link>
                    <router-link v-if="id!==undefined" :to="{ name: 'update-product',params: { id: this.id } }" class="btn btn-secondary btn-sm float-end">Previous</router-link>
                    </div>                    
                </div>
            </div>
            <div v-bind:class="[step3===true ? 'card' : 'card d-none']">
                <div class="card-header">Create Product - Final Stage</div>
                <div class="card-body">
                    <div clss="row">
                        <label class="col">Date and Time</label>
                        <div class="col">
                            <input type="datetime-local" multiple class="form-control" v-model="date" v-on:change="setDate($event)">
                            <p class="text-danger" v-text="errors.date"></p>
                        </div>                        
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col ms-auto">                
                    <button class="btn btn-primary btn-sm float-end ml-2" v-on:click="FinalStep()">Save</button>
                    <button class="btn btn-secondary btn-sm float-end ml-2" v-on:click="Previous">Previous</button>
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
            file: [],
            errors: {
                file: [],
                date: ''
            },
            date: '',
            step3: false,
            step2: true,
            attachments: [],
            user: ''
        }
    },
    methods: {
        async StepTwo(){
            if(this.id === undefined)
            {
                if(this.file.length === 0)
                {
                    this.errors.file = ['Image upload is required'];
                    return;
                }

            }
            const param = {
                file: this.file
            }
            this.errors = {
                file: []
            }
           let formData = new FormData();
           var inc = 0;
           for(let i of this.file)
           {
               formData.append(`file[${inc++}]`,i);
           }
           await axios.post('/api/product/create/step2',formData,{headers: {
                "Content-Type": "multipart/form-data"
            }}).then(e => {
                if(e.status === 200)
                {
                    if(e.data.status === 'success')
                    {
                        this.step2 = false;
                        this.step3 = true;
                        // this.$router.push('/create-product/step3');
                    }
                }
            }).catch(e => {

                if(e.response.status === 422)
                {
                    for(let i in e.response.data.errors)
                    {
                        // console.log(e.response.data.errors[i][0]);
                        for(let b in e.response.data.errors[i])
                        {
                            this.errors.file.push(e.response.data.errors[i][b]);
                        }                        
                    }
                }
            });
        },
        setFile(e){
            this.file = e.target.files;

        },
        Previous(){
            this.step2 = true;
            this.step3 = false;
        },
        async FinalStep(){
            // const param = {
            //     date_added: this.date
            // }
            this.errors = {
                date: ''
            }
            
            if(this.id !== undefined)
            {
                await this.FinalEdit();
                return;
            }
            let formData = new FormData();
            var inc = 0;
            for(let i of this.file)
            {
                formData.append(`file[${inc++}]`,i);
            }
            formData.append('date_added',this.date);
            formData.append('name',localStorage.getItem('products.name'));
            formData.append('description',localStorage.getItem('products.description'));
            formData.append('category_id',localStorage.getItem('products.category_id'));
           await axios.post('/api/product/create/step3',formData,{headers: {
                "Content-Type": "multipart/form-data"
            }}).then(e => {
                if(e.status === 200)
                {
                    if(e.data.status === 'success')
                    {
                        Swal.fire({
                            title: 'Product successfully saved',
                            text: "",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Close'
                        }).then((result) => {
                            localStorage.removeItem('products.name');
                            localStorage.removeItem('products.category_id');
                            localStorage.removeItem('products.description');
                            this.$router.push('/products/');           
                        });
                        
                    }
                }
            }).catch(e => {

                if(e.response.status === 422)
                {
                    for(let i in e.response.data.errors)
                    {
                        this.errors.date = e.response.data.errors[i][0];
                    }
                }
            });
        },
        setDate(e){
            this.date = e.target.value;
            this.errors.date = '';
        },
        async loadEdit(id){
            const get = await axios.get(`/api/product/${id}`);
            if(get.status === 200)
            {
                if(get.data.status === 'success')
                {
                    this.date = get.data.result.date_added;
                    this.attachments = get.data.result.attachments;
                }
            }
        },
        FinalEdit(){
            let formData = new FormData();
            var inc = 0;
            for(let i of this.file)
            {
                formData.append(`file[${inc++}]`,i);
            }
            formData.append('id',this.id);
            axios.post('/api/product/update',formData,{headers: {
                "Content-Type": "multipart/form-data"
            }}).then(e => {
                if(e.status === 200){}
            }).catch(e => {  console.log(e) });
            axios.patch(`/api/product/${this.id}`,{
                date_added: this.date,
                name: localStorage.getItem('products.name'),
                category_id: localStorage.getItem('products.category_id'),
                description: localStorage.getItem('products.description'),
            }).then(e => {
                if(e.status === 200)
                {
                    if(e.data.status === 'success')
                    {
                        Swal.fire({
                            title: 'Product successfully saved',
                            text: "",
                            icon: 'success',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'Close'
                        }).then((result) => {
                            localStorage.removeItem('products.name');
                            localStorage.removeItem('products.category_id');
                            localStorage.removeItem('products.description');
                            this.$router.push('/products/');           
                        });
                        
                    }
                }
            }).catch(e => {

                if(e.response.status === 422)
                {
                    for(let i in e.response.data.errors)
                    {
                        this.errors.date = e.response.data.errors[i][0];
                    }
                }
            });
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
        this.step3 = false;
        this.step2 = true;
        if(this.id !== undefined){
            this.loadEdit(this.id);
        }
        this.loadSecret();
    }
}
</script>
<style lang="">
    
</style>