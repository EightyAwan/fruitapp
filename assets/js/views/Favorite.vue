<template>
    <div>
      <div>
        <h1>Total Protein</h1>
        <b>{{  }}</b>
      </div> 
      <div>
        <h1>Total Fat</h1>
        <b>{{  }}</b>
      </div> 
      <div>
        <h1>Total Calories</h1>
        <b>{{  }}</b>
      </div> 
      <div>
        <h1>Total Sugar</h1>
        <b>{{  }}</b>
      </div> 

      <table>
      <thead>
        <tr>
          <th>ID</th>
          <th>Name</th>
          <th>Family</th>
          <th>Order</th>
        </tr>
      </thead>
      <tbody>
        <tr v-for="item in items" :key="item.id">
          <td>{{ item.id }}</td>
          <td>{{ item.name }}</td>
          <td>{{ item.family }}</td>
          <td>{{ item.order }}</td>
          <td><FruitItem :item="item" /></td>
        </tr>
      </tbody>
    </table>
      <div>
        <button @click="prevPage" :disabled="page === 1">Previous</button>
        <button @click="nextPage" :disabled="page === lastPage">Next</button>
      </div>
    </div>
  </template>
  
  <script>
  import FruitItem from '../components/FruitItem.vue';
  import axios from 'axios';
  
  export default {
    components: {
    FruitItem
    },
    data() {
      return {
        items: [],
        page: 1,
        perPage: 10,
        total: 0,
      };
    },
    computed: {
      lastPage() {
        return Math.ceil(this.total / this.perPage);
      },
    },
    async mounted() {
      await this.fetchData();
    },
    methods: {
      async fetchData() {
        const response = await axios.get('/favorite/fruits', {
          params: {
            page: this.page,
            per_page: this.perPage,
          },
        }); 
        this.items = response.data.data.items;
        this.total = response.data.data.totalItems;
      },
      async prevPage() {
        this.page -= 1;
        await this.fetchData();
      },
      async nextPage() {
        this.page += 1;
        await this.fetchData();
      } 
      
    },
  };
  </script> 