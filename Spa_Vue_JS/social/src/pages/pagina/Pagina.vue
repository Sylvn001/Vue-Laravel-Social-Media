<template>
<site-template>
    <span slot="menuEsquerdo">
        <div class="row valign-wrapper">
            <grid-vue tamanho="4">
                <router-link :to="'/pagina/'+donoPagina.id+'/'+$slug(usuario.name, {lower: true})">
                    <img :src="donoPagina.imagem" :alt="donoPagina.name" class="circle responsive-img"> <!-- notice the "circle" class -->
                </router-link>
            </grid-vue>
            <grid-vue tamanho="8">
                <span class="black-text">
                    <router-link :to="'/pagina/'+donoPagina.id +'/'+$slug(usuario.name, {lower: true}) ">
                        <h5 class="black-text"> {{donoPagina.name}} </h5>
                        <button v-if="exibeBtnSeguir" @click="amigo(donoPagina.id)" class=" btn blue">{{textoBtn}} </button>
                    </router-link>
                </span>
            </grid-vue>
        </div>
    </span>

    <span slot="menuesquerdoamigos">
        <h4>Amigos </h4>
        <router-link v-for="item in amigos" :key="item.id" :to="'/pagina/'+item.id+'/'+$slug(item.name,{lower: true})">
            <li>{{item.name}}</li>
        </router-link>
        <li v-if="!amigos.length">Nenhum Usuario</li>

        <h4>Seguidores </h4>
        <router-link v-for="item in seguidores" :key="item.id" :to="'/pagina/'+item.id+'/'+$slug(item.name,{lower: true})">
            <li>{{item.name}}</li>
        </router-link>
        <li v-if="!seguidores.length">Nenhum Seguidor</li>
    </span>

    <span slot="principal">
        <publicar-conteudo-vue />

        <card-conteudo-vue v-for="item in listaConteudos" :key="item.id" :id="item.id" :totalcurtidas="item.total_curtidas" :comentarios="item.comentarios" :curtiuconteudo="item.curtiu_conteudo" :perfil="item.user.imagem" :nome="item.user.name" :data="item.data" :usuarioid="item.user.id">
            <card-detalhe-vue :img="item.imagem" :titulo="item.titulo" :txt="item.texto" :link="item.link" />
        </card-conteudo-vue>
        <div v-scroll="handleScroll">

        </div>
    </span>

</site-template>
</template>

<script>
import SiteTemplate from '@/templates/SiteTemplate'
import CardConteudoVue from '@/components/social/CardConteudoVue'
import CardDetalheVue from '@/components/social/CardDetalheVue'
import PublicarConteudoVue from '@/components/social/PublicarConteudoVue'
import GridVue from '@/components/layouts/GridVue'

export default {
    name: 'Pagina',
    data() {
        return {
            usuario: false,
            urlProximaPagina: null,
            pararScroll: false,
            donoPagina: {
                imagem: '',
                name: ''
            },
            exibeBtnSeguir: false,
            amigos: [],
            amigosLogado: [],
            textoBtn: 'Seguir',
            seguidores: []

        }
    },
    created() {
        this.atualizaPagina();
    },
    components: {
        SiteTemplate,
        CardConteudoVue,
        CardDetalheVue,
        PublicarConteudoVue,
        GridVue
    },
    watch: {
        '$route': 'atualizaPagina'
    },
    methods: {
        atualizaPagina() {
            let usuarioAux = this.$store.getters.getUsuario;

            if (usuarioAux) {
                this.usuario = this.$store.getters.getUsuario;
                this.$http.get(this.$urlAPI + `conteudo/pagina/lista/` + this.$route.params.id, {
                        "headers": {
                            "authorization": "Bearer " + this.$store.getters.getToken
                        }
                    })
                    .then(response => {
                        //console.log(response);
                        if (response.data.status) {
                            this.$store.commit('setConteudosLinhaTempo', response.data.conteudos.data);
                            this.urlProximaPagina = response.data.conteudos.next_page_url;
                            this.donoPagina = response.data.dono;
                            if (this.donoPagina.id != this.usuario.id) {
                                this.exibeBtnSeguir = true;
                            } else {
                                this.exibeBtnSeguir = false;
                            }

                            this.$http.get(this.$urlAPI + `usuario/listaamigospagina/` + this.donoPagina.id, {
                                    "headers": {
                                        "authorization": "Bearer " + this.$store.getters.getToken
                                    }
                                })
                                .then(response => {
                                    if (response.data.status) {
                                        //console.log(response.data);
                                        this.amigos = response.data.amigos;
                                        this.amigosLogado = response.data.amigoslogado;
                                        this.seguidores = response.data.seguidores;

                                        this.eAmigo();
                                    } else {
                                        alert(response.data.erro);
                                    }

                                })
                                .catch(e => {
                                    console.log(e)
                                    alert("Erro! Tente novamente mais tarde!");
                                })

                        }

                    })
                    .catch(e => {
                        console.log(e)
                        alert("Erro! Tente novamente mais tarde!");
                    })
            }
        },
        eAmigo() {

            for (let amigo of this.amigosLogado) {
                if (amigo.id == this.donoPagina.id) {
                    this.textoBtn = "Remover";
                    return;
                }
            }
            this.textoBtn = "Seguir";

        },
        amigo(id) {
            console.log("id: " + id);

            this.$http.post(this.$urlAPI + `usuario/amigo`, {
                    id: id
                }, {
                    "headers": {
                        "authorization": "Bearer " + this.$store.getters.getToken
                    }
                })
                .then(response => {
                    if (response.data.status) {
                        //console.log(response);
                        this.amigosLogado = response.data.amigos;
                        this.seguidores = response.data.seguidores;
                        this.eAmigo();
                    } else {
                        alert(response.data.erro);
                    }
                }).catch(e => {
                    console.log(e)
                    alert("Erro! Tente novamente mais tarde!");
                });

        },
        handleScroll() {
            //console.log(window.scrollY);
            //console.log(document.body.clientHeight);
            if (this.pararScroll) {
                return;
            }

            if (window.scrollY >= document.body.clientHeight - 949) {
                this.pararScroll = true;
                this.carregaPaginacao();
            }
        },
        carregaPaginacao() {
            if (!this.urlProximaPagina) {
                return;
            }

            this.$http.get(this.urlProximaPagina, {
                    "headers": {
                        "authorization": "Bearer " + this.$store.getters.getToken
                    }
                })
                .then(response => {
                    //console.log(response);
                    if (response.data.status && this.$route.name == "Pagina") {
                        this.$store.commit('setPaginacaoConteudosLinhaTempo', response.data.conteudos.data);
                        this.urlProximaPagina = response.data.conteudos.next_page_url;
                        this.pararScroll = false;
                    }

                })
                .catch(e => {
                    console.log(e)
                    alert("Erro! Tente novamente mais tarde!");
                })
        }
    },
    computed: {
        listaConteudos() {
            return this.$store.getters.getConteudosLinhaTempo;
        }
    }
}
</script>

<!-- Add "scoped" attribute to limit CSS to this component only -->

<style scoped>

</style>
