import CreateProduct from '../products/create.vue';
import UpdateProduct from '../products/update.vue';
import Products from '../products/index.vue';
import CreateProductStepTwo from '../products/create-step2.vue';
import CreateProductStepThree from '../products/create-step3.vue';

export default{

    routes: [
        {
            path: '/',
            name: 'product',
            component: Products
        },
        {
            path: '/create-product',
            name: 'create-product',
            component: CreateProduct
        },
        {
            path: '/products',
            name: 'products',
            component: Products
        },
        {
            path: '/create-product/step2',
            name: 'create-product-step2',
            component: CreateProductStepTwo
        },
        {
            path: '/create-product/step3',
            name: 'create-product-step3',
            component: CreateProductStepThree
        },
        {
            path: '/update-product/:id',
            name: 'update-product',
            component: UpdateProduct
        },
        {
            path: '/update-product/step2/:id',
            name: 'update-product-step2',
            component: CreateProductStepTwo
        },

    ]
}