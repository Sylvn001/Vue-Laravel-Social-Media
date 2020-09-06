<template>

  <site-template>

      <span slot="principal">
           
        <h2> Perfil </h2>
        <input type="text" placeholder="Nome" v-model="usuario.name">
        <input type="text" placeholder="E-mail" value="" v-model="usuario.email">

          <div class="file-field input-field">
            <div class="btn">
              <span>Imagem</span>
              <input  v-on:change="salvaimagem" type="file">
            </div>
            <div class="file-path-wrapper">
              <input class="file-path validate" type="text">
            </div>
          </div>

        <input type="password"  placeholder="Senha" v-model="usuario.password">
        <input type="password"  placeholder="Confirme sua Senha" v-model="usuario.password_confirmation">
         <button class="btn" type="submit" v-on:click="perfil()">Atualizar</button>

      </span>

    <span slot="menuEsquerdo">
            <img :src="user.imagem" class="responsive-img" >
    </span>
    
  </site-template>

            
</template>

<script>

import SiteTemplate from '@/templates/SiteTemplate'

export default {
  name: 'perfil',
  data () {
    return {
      user: false,
      usuario: {name: '' , email: '', password: '', password_confirmation: '' , imagem: ''}
    }
  },
  created(){
    let usuarioAux =  this.$store.getters.getUsuario;
    if(usuarioAux){
      this.user =  this.$store.getters.getUsuario;
      this.usuario.name = this.user.name
      this.usuario.email = this.user.email
    }
  },
  components:{
    SiteTemplate
  },
  methods:{
    perfil(){
      this.$http.put(this.$urlAPI+`perfil`, {
        email: this.usuario.email, 
        name: this.usuario.name,
        password: this.usuario.password,
        password_confirmation: this.usuario.password_confirmation,
        imagem: this.usuario.imagem
      }, {"headers": {"authorization": "Bearer " + this.$store.getters.getToken}})
      .then(response => {
        console.log(response)

        if(response.data.status){
          //success login 
          this.user = response.data.usuario
          this.$store.commit('setUsuario', response.data.usuario)
          sessionStorage.setItem('usuario', JSON.stringify(this.user));
          alert('Perfil Atualizado');
        }
        else if(response.data.status == false && response.data.validacao){
          // validation erro 
          let erros = ''
          for(let erro of Object.values(response.data.erros)){
            erros += erro + " ";
          }
          alert(erros)
        }
      })
      .catch(e => {
        console.log(e)
        alert('Tente novamente mais tarde')
      })
     
    },
    salvaimagem(e){
        //
        let arquivo = e.target.files || e.dataTransfer.files;  
        if(!arquivo.length){
          return
        }
        let reader = new FileReader();
        reader.onloadend = (e) => {
          this.usuario.imagem = e.target.result
        }

        reader.readAsDataURL(arquivo[0])

      }
    

  }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->
<style scoped>

</style>
