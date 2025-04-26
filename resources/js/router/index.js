import Vue from 'vue'
import VueRouter from 'vue-router'
import ExampleComponent from '../components/ExampleComponent'
import ContactUsComponent from "../components/ContactUsComponent.vue";
import HomeSliderComponent from "../components/HomeSliderComponent";
import HomeHighlightiesComponent from "../components/HomeHighlightiesComponent";
import HomeVideoComponent from "../components/HomeVideoComponent";
import HomeRomanticComponent from "../components/HomeRomanticComponent";
import HomeIngredientComponent from "../components/HomeIngredientComponent";
import ProductsComponent from "../components/ProductsComponent";
import OrdersComponent from "../components/OrdersComponent.vue";
import AboutUsDataComponent from "../components/AboutUsDataComponent";
import AwardsComponent from "../components/AwardsComponent";
import NewsComponent from "../components/NewsComponent";
import FAQComponent from "../components/FAQComponent";
import PrivacyPolicyComponent from "../components/PrivacyPolicyComponent";
import TermComponent from "../components/TermComponent";
import CategoriesComponent from "../components/CategoriesComponent";

Vue.use(VueRouter);

const routes = [
  {
    path: '/dashboard',
    name: 'Dashboard',
    component: ExampleComponent
  },
  {
    path: '/dashboard/contact_us',
    name: 'ContactUs',
    component: ContactUsComponent
  },
  {
    path: '/dashboard/home_slider',
    name: 'HomeSlider',
    component: HomeSliderComponent
  },
  {
    path: '/dashboard/home_highlighties',
    name: 'HomeHighlighties',
    component: HomeHighlightiesComponent
  },
  {
    path: '/dashboard/home_video',
    name: 'HomeVideo',
    component: HomeVideoComponent
  },
  {
    path: '/dashboard/home_romantic',
    name: 'HomeRomantic',
    component: HomeRomanticComponent
  },
  {
    path: '/dashboard/home_ingredient',
    name: 'HomeIngredient',
    component: HomeIngredientComponent
  },
  {
    path: '/dashboard/products',
    name: 'Products',
    component: ProductsComponent
  },
  {
    path: '/dashboard/orders',
    name: 'Orders',
    component: OrdersComponent
  },
  {
    path: '/dashboard/about_us_data',
    name: 'AboutUsData',
    component: AboutUsDataComponent
  },
  {
    path: '/dashboard/awards',
    name: 'Awards',
    component: AwardsComponent
  },
  {
    path: '/dashboard/newses',
    name: 'News',
    component: NewsComponent
  },
  {
    path: '/dashboard/faqs',
    name: 'FAQS',
    component: FAQComponent
  },
  {
    path: '/dashboard/privacy_policy',
    name: 'PrivacyPolicy',
    component: PrivacyPolicyComponent
  },
  {
    path: '/dashboard/terms',
    name: 'Term',
    component: TermComponent
  },
  {
    path: '/dashboard/categories',
    name: 'Categories',
    component: CategoriesComponent
  },


];
Vue.config.devtools=true;
const router = new VueRouter({
  mode: 'history',
  linkActiveClass: "linkActiveClass",
  routes
});

export default router
