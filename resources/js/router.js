import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from './components/front/Home.vue';
import App from './components/App.vue';
import CategoryDetail from './components/front/CategoryDetail.vue';
import ArticleDetail from './components/front/ArticleDetail.vue';
import Dashboard from './components/admin/Dashboard.vue';
import Category from './components/admin/category/Category.vue';

Vue.use(VueRouter)

const router = new VueRouter({
    routes : [
        {
            path: '/',
            name: 'home',
            component: Home
        },
        {
            path: '/categorie/:slug',
            name: 'category',
            component: CategoryDetail
        },
        {
            path: '/:categorie/:slug',
            name: 'article',
            component: ArticleDetail
        },
        {
            path: '/dashboard',
            name: 'dashboard',
            component: Dashboard,
            children: [
                {
                    path: 'category',
                    name: 'categorie',
                    component: Category
                }

            ]
        }
    ]
})
export default router