import Vue from 'vue'
import Vuesax from 'vuesax'
import Router from 'vue-router'
import VueGoodTablePlugin from 'vue-good-table'
import Tagger from '@/components/Tagger'

import 'vue-good-table/dist/vue-good-table.css'
import 'vuesax/dist/vuesax.css'
import 'material-icons/iconfont/material-icons.css'

Vue.use(VueGoodTablePlugin)
Vue.use(Router)
Vue.use(Vuesax)

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Tagger',
      component: Tagger
    }
  ]
})
