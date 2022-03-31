<template lang="">
    <div class="col py-3">
    <div class="alert alert-dark" v-text="user"></div>
        <div class="container col-lg-5 col-md-5 col-sm-12">
            <div class="card">
                <div class="card-header">Create Product - Final Stage</div>
                <div class="card-body">
                    <div clss="row">
                        <label class="col">Date and Time</label>
                        <div class="col">
                            <input type="date" multiple class="form-control" v-model="date" v-on:change="setDate($event)">
                            <p class="text-danger" v-text="errors.date"></p>
                        </div>                        
                    </div>
                </div>
                <div class="card-footer">
                    <div class="col ms-auto">                
                    <button class="btn btn-primary btn-sm float-end ml-2" v-on:click="FinalStep()">Save</button>
                    <router-link :to="{ name: 'create-product-step2' }" class="btn btn-secondary btn-sm float-end">Previous</router-link>
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
            date: '',
            errors: {
                date: '',
            },
            user: ''
        }
    },
    methods: {
        async FinalStep(){
            const param = {
                date_added: this.date
            }
            this.errors = {
                date: ''
            }
           await axios.post('/api/product/create/step3',param).then(e => {
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
        console.log(localStorage.getItem('file'));
    }
}
</script>
<style lang="">
    
</style>