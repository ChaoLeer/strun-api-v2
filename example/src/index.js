import axios from '../node_modules/_axios@0.17.1@axios'
import qs from 'qs'

const service = axios.create({
  baseURL: 'http://localhost:3000/Api', // api的base_url
  timeout: 50000, // 请求超时时间
  headers: {
    'USERID': 'b91aacd034c311e7bec600163e055a18'
    // 'Content-Type': 'application/json;charset=utf-8',
    // 'Content-Type': 'application/json;charset=utf-8;'
  }
})
// request拦截器
// service.interceptors.request.use(config => {
//   // Do something before request is sent
//   // if (store.getters.token) {
//   //   config.headers['token'] = getToken() // 让每个请求携带token--['X-Token']为自定义key 请根据实际情况自行修改
//   // }
//   // config.data = qs.stringify(config.data)
//   return config
// }, error => {
//   // Do something with request error
//   console.log(error) // for debug
//   Promise.reject(error)
// })

// service.get('/article/page', {
//   params: {
//     page: 1,
//     row: 20,
//     userId: 'b91aacd034c311e7bec600163e055a14',
//     // classify: 'Linux',
//     // searchInfo: '运行'
//   }
// }).then(res => {
//   console.info(res)
//   console.info(res.data)
// })

// service.post('/article', {
//   authorId: 'b91aacd034c311e7bec600163e055a18'
// }).then(res => {
//   console.info(res)
//   console.info(res.data)
// })

// service.put('/article/3aa6d1a642a711e8bfe800163e055a14', {
//   userId: 'b91aacd034c311e7bec600163e055a18',
//   authorId: 'b91aacd034c311e7bec600163e055a18',
//   articleId: '3aa6d1a642a711e8bfe800163e055a14',
//   title: '测试标题',
//   content: '测试内容',
//   articleIntro: '测试摘要',
//   classify: '测试文章类型'
// }).then(res => {
//   console.info(res)
//   console.info(res.data)
// })
// service.delete('/article/491601e442a711e8bfe800163e055a14').then(res => {
//   console.info(res)
//   console.info(res.data)
// })

service.get('/code/type/ARTICLE_TYPE').then(res => {
  console.info(res)
  console.info(res.data)
})