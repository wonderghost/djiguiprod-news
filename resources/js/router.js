import Vue from 'vue'
import VueRouter from 'vue-router'
import Home from './components/front/Home.vue';
import CategoryDetail from './components/front/CategoryDetail.vue';
import ArticleDetail from './components/front/ArticleDetail.vue';
import Category from './components/admin/category/Category.vue';
import Dashboard from './components/admin/Dashboard.vue';
import SubCategory from './components/admin/subCategory/SubCategory.vue';
import User from "./components/admin/users/User.vue";
import AddArticle from './components/admin/article/AddArticle.vue';

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
            component: Dashboard
        },
        {
            path: '/category',
            component: Category
        },
        {
            path: '/sous-categorie',
            component: SubCategory,
        },
        {
            path: '/users',
            component: User,
        },
        {
            path: '/articles',
            component: AddArticle,
        }
    ],
})
export default router