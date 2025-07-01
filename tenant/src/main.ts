import './permission'
import './styles/index.scss'
import 'virtual:svg-icons-register'

import { createApp } from 'vue'

import App from './App.vue'
import config from './config'
import install from './install'

const app = createApp(App)
app.use(install)
app.mount('#app')

const likeadminArt = `沐云智慧教育系统<a href="https://www.tutudati.com"></a>`

console.log(
    `%c tutudati %c v${config.version} `,
    'padding: 4px 1px; border-radius: 3px 0 0 3px; color: #fff; background: #bbb; font-weight: bold;',
    'padding: 4px 1px; border-radius: 0 3px 3px 0; color: #fff; background: #4A5DFF; font-weight: bold;'
)
console.log(`%c ${likeadminArt}`, 'color: #4A5DFF')
