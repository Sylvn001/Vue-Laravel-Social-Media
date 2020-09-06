<template>

  <login-template>

      <span slot="principal">
           
        <h2> Cadastro </h2>
        <input type="text" placeholder="Nome" v-model="usuario.name">
        <input type="text" placeholder="E-mail" value="" v-model="usuario.email">
        <input type="password"  placeholder="Senha" v-model="usuario.password">
        <input type="password"  placeholder="Confirme sua Senha" v-model="usuario.password_confirmation">
         <button class="btn" type="submit" v-on:click="cadastrar()">Cadastrar</button>
        <router-link to="/login" class="btn orange" type="submit">Já tenho conta </router-link>

      </span>

    <span slot="menuEsquerdo">
            <img src="https://wbweb.com.br/images/blog/o-que-um-social-media-faz.png" class="responsive-img" >
    </span>
    
  </login-template>

            
</template>

<script>
import LoginTemplate from '@/templates/LoginTemplate'
import axios from 'axios';


export default {
  name: 'Cadastro',
  components:{
      LoginTemplate,

      
  },
  data () {
    return {
    
      usuario: {name: '' , email: '', password: '', password_confirmation: ''}
    }
  },
    methods:{
      cadastrar(){
        this.$http.post(this.$urlAPI+`cadastro`, {
          email: this.usuario.email, 
          name: this.usuario.name,
          password: this.usuario.password,
          password_confirmation: this.usuario.password_confirmation
        })
        .then(response => {
        
          if(response.data.status){
            //success login 
            this.$store.commit('setUsuario', response.data.usuario)
            sessionStorage.setItem('usuario', JSON.stringify(response.data.usuario));
       
            this.$router.push('/')
          }else if(response.data.status == false && response.data.validacao){
            //login erro 
            let erros = ''
            for(let erro of Object.values(response.data)){
              erros += erro + " ";
            }
            alert(erros)
          }else{
            // validation erro 
          alert('Não foi possivel criar a conta! Erro no cadastro')
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
