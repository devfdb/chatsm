<template>
  <div>
    <vs-row>
      <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12">
        <div class="icons-example center">
          <vs-input icon="search" placeholder="Search" v-model="query" v-on:keyup.enter="search" style="margin: 6px"/>
        </div>
      </vs-col>
    </vs-row>
    <vs-row>
      <vs-col vs-type="flex" vs-justify="center" vs-align="center" vs-w="12">
        <vue-good-table
        v-if="rows"
        mode="remote"
        @on-page-change="onPageChange"
        @on-per-page-change="onPerPageChange"
        @on-selected-rows-change="selectRows"
        :columns="columns"
        :rows="rows"
        :totalRows="totalRows"
        :select-options="{
        enabled: true,
      }"
        :pagination-options="{
        enabled: true,
      }">
        <div slot="selected-row-actions">
          <vs-button @click="etiquetar">Etiquetar</vs-button>
        </div>
      </vue-good-table>
      </vs-col>
    </vs-row>
    <div>
      <vs-popup title="Etiquetador" :active.sync="popupActivo">
        <vs-input placeholder="Etiqueta" v-model="etiqueta"></vs-input>
        <vs-button @click="addTag">Agregar</vs-button>
        <vs-button @click="removeTag">Eliminar</vs-button>
        <vs-button @click="enviar">Enviar</vs-button>
        <p>{{etiquetas}}</p>
      </vs-popup>
    </div>
  </div>
</template>

<script>
import axios from 'axios'
export default {
  name: 'Tagger',
  data () {
    return {
      columns: [
        {
          label: 'tweet',
          field: 'tweet'
        },
        {
          label: 'lemas',
          field: 'lemas'
        }
      ],
      rows: null,
      query: '',
      totalRows: 0,
      serverParams: {
        page: 1,
        perPage: 10
      },
      selectedRows: null,
      popupActivo: false,
      etiquetas: [],
      etiqueta: ''
    }
  },
  methods: {
    search () {
      axios.post('http://localhost:5656/api/twitter/search', {
        query: this.query,
        pag: this.serverParams.page,
        limit: this.serverParams.perPage
      })
        .then(resp => {
          this.rows = resp.data.rows
          this.totalRows = resp.data.totalRows
        })
    },
    onPageChange (params) {
      this.serverParams.page = params.currentPage
      this.search()
    },
    onPerPageChange (params) {
      this.serverParams.perPage = params.currentPerPage
      this.search()
    },
    selectRows (params) {
      this.selectedRows = params.selectedRows
      console.log(params.selectedRows)
    },
    etiquetar () {
      this.popupActivo = true
    },
    addTag () {
      this.etiquetas.push(this.etiqueta)
      this.etiqueta = ''
    },
    removeTag () {
      this.etiquetas.pop()
    },
    enviar () {
      var ids = []
      for (var row in this.selectedRows) {
        console.log(this.selectedRows[row]._id)
        ids.push(this.selectedRows[row]._id)
        axios.put('http://localhost:5656/api/twitter/', {
          ids: ids,
          tags: this.etiquetas
        })
      }
    }
  }
}
</script>

<style scoped>

</style>
