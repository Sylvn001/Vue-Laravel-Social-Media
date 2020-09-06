<template>

  <login-template>

      <span slot="principal">
        <span>
           <h2> Login </h2>

          <input type="text" placeholder="email" v-model="usuario.email">
          <input type="password" name="password" v-model="usuario.password" id="" placeholder="senha">
          <button class="btn" type="submit" v-on:click="login()">Entrar</button>
           <router-link to="/cadastro" class="btn orange" type="submit">Cadastre-se </router-link>
        </span>


      </span>

        <span slot="menuEsquerdo">
              <img src="https://wbweb.com.br/images/blog/o-que-um-social-media-faz.png" class="responsive-img" >
        </span>
  </login-template>

            
</template>

<script>
import LoginTemplate from '@/templates/LoginTemplate'


export default {
  name: 'login',
  components:{
      LoginTemplate,
  
      
  },
  data () {
    return {
      usuario: {email: '' , password: ''}
    }
  },
  methods:{
    login(){
     
    this.$http.post(this.$urlAPI+`login`, {
      email: this.usuario.email, 
      password: this.usuario.password
      })
      .then(response => {
        console.log(response)

        if(response.data.status){
          //success login 
          this.$store.commit('setUsuario', response.data.usuario)
          sessionStorage.setItem('usuario', JSON.stringify(response.data.usuario));
          this.$router.push('/')
        }else if(response.data.status == false && response.data.validacao){
          //login erro 
            for(let erro of Object.values(response.data.erros)){
            erros += erro + " ";
          }
        
          alert(erros)
        }else{
          // validation erro 
          console.log('Login nao existe')
          
      
          alert('login invalido!')
        }
      })
      .catch(e => {
        console.log(e)
        alert('Tente novamente mais tarde')
      })
    }

  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
