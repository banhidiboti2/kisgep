import { createRouter, createWebHistory } from 'vue-router'
import MainView from '../views/MainView.vue'
import LoginView from '../views/LoginView.vue'
import RegisterView from '../views/RegisterView.vue'
import BasketView from '../views/BasketView.vue'
import ConstructionView from '@/views/ConstructionView.vue'
import GardenView from '@/views/GardenView.vue'
import WoodAndMetalView from '@/views/WoodAndMetalView.vue'
import ProfileView from '@/views/ProfileView.vue'
import FrequentlyAskedView from '@/views/FrequentlyAskedView.vue'
import PrivacyNoticeView from '@/views/PrivacyNoticeView.vue'

const routes = [
  {
    path: '/',
    name: 'Main',
    component: MainView
  },
  {
    path: '/login',
    name: 'Login',
    component: LoginView
  },
  {
    path: '/register',
    name: 'Register',
    component: RegisterView
  },
  {
    path: '/basket',
    name: 'Basket',
    component: BasketView
  },
  {
    path: '/construction',
    name: 'ConstructionView',
    component: ConstructionView,
  },
  {
    path: '/garden',
    name: 'GardenView',
    component: GardenView,
  },
  {
    path: '/woodandmetal',
    name: 'WoodAndMetalView',
    component: WoodAndMetalView,
  },
  {
    path: '/profile',
    name: 'ProfileView',
    component: ProfileView,

  },
  {
    path: '/frequently',
    name: 'FrequentlyAskedView',
    component: FrequentlyAskedView,

  },
  {
    path: '/Privacy',
    name: 'PrivacyNoticeView',
    component: PrivacyNoticeView,

  },
]

const router = createRouter({
  history: createWebHistory(),
  routes
})

export default router






