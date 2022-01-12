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
import Client from './components/admin/client/Client.vue';
import Banner from './components/admin/banner/Banner.vue';
import Article from './components/admin/article/Article.vue';
import UpdateArticle from './components/admin/article/UpdateArticle.vue';
import VueMeta from 'vue-meta'

Vue.use(VueRouter)
Vue.use(VueMeta, {
    keyName: 'metaInfo',
    attribute: 'data-vue-meta',
    ssrAttribute: 'data-vue-meta-server-rendered',
    tagIDKeyName: 'vmid',
    refreshOnceOnNavigation: true
})

const router = new VueRouter({
    mode: 'history',
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
            path: '/:subcategory/:slug',
            name: 'article',
            component: ArticleDetail
        },
        {
            path: '/admin/dashboard/list',
            name: 'dashboard',
            component: Dashboard
        },
        {
            path: '/admin/category/list',
            component: Category
        },
        {
            path: '/admin/sous-categorie/list',
            component: SubCategory,
        },
        {
            path: '/admin/users/list',
            component: User,
        },
        {
            path: '/admin/articles/list',
            component: Article,
        },
        {
            path: '/admin/add-article/add',
            component: AddArticle,
        },
        {
            path: '/admin/clients/list',
            component: Client,
        },
        {
            path: '/admin/banner/list',
            component: Banner,
        },
        {
            path: '/admin/articles/update/:slug',
            component: UpdateArticle
        }
    ],
})
export default router