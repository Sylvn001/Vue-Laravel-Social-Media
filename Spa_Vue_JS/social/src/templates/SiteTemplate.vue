<template>
<span>
    <header>
        <nav-bar logo="Social" url="/" cor="42a5f5 blue lighten-1">
            <li>
                <router-link to="/">Home</router-link>
            </li>
            <li v-if="!usuario">
                <router-link to="/login" class="active">Entrar</router-link>
            </li>
            <li v-if="!usuario">
                <router-link to="/cadastro">Cadastrar</router-link>
            </li>
            <li v-if="usuario">
                <router-link to="/perfil">{{usuario.name}}</router-link>
            </li>
            <li v-if="usuario"><a v-on:click="sair()">Sair</a></li>
        </nav-bar>
    </header>

    <main>
        <div class="container">
            <div class="row">
                <grid-vue tamanho='4'>
                    <card-menu-vue>
                        <slot name="menuEsquerdo" />
                    </card-menu-vue>
                    <card-menu-vue>
                        <slot name="menuesquerdoamigos" />
                    </card-menu-vue>

                </grid-vue>
                <grid-vue tamanho='8'>
                    <slot name="principal" />
                </grid-vue>

            </div>

        </div>

    </main>

    <footer-vue cor="#42a5f5 blue lighten-1" logo="Social" descricao="teste de descricao" ano='2020'>
        <li><a class="grey-text text-lighten-3" href="#!">Home</a></li>
        <li><a class="grey-text text-lighten-3" href="#!">Link 2</a></li>
        <li><a class="grey-text text-lighten-3" href="#!">Link 3</a></li>
        <li><a class="grey-text text-lighten-3" href="#!">Link 4</a></li>
    </footer-vue>

</span>
</template>

<script>
// Vue Components Import
import NavBar from '@/components/layouts/NavBar'
import FooterVue from '@/components/layouts/FooterVue'
import GridVue from '@/components/layouts/GridVue'
import CardMenuVue from '@/components/layouts/CardMenuVue'
export default {
    name: 'SiteTemplate',
    components: {
        NavBar,
        FooterVue,
        GridVue,
        CardMenuVue
    },
    data() {
        return {
            usuario: false
        }
    },
    created() {
        let usuarioAux = this.$store.getters.getUsuario;
        if (usuarioAux) {
            this.usuario = this.$store.getters.getUsuario;
        } else {
            this.$router.push('/login')
        }
    },
    methods: {
        sair() {
            this.$store.commit('setUsuario', null)
            sessionStorage.clear();
            this.usuario = false;
            this.$router.push('/login')
        }
    }
}
</script>

<style>

</style>
