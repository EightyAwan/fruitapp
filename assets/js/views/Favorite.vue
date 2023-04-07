<template>
    <div>
      <div>
        <h3>Total Protein</h3>
        <b>{{ totalFruitDiet?.total_protein }}</b>
      </div> 
      <div>
        <h3>Total Fat</h3>
        <b>{{ totalFruitDiet?.total_fat }}</b>
      </div> 
      <div>
        <h3>Total Calories</h3>
        <b>{{ totalFruitDiet?.total_calories }}</b>
      </div> 
      <div>
        <h3>Total Sugar</h3>
        <b>{{ totalFruitDiet?.total_sugar }}</b>
      </div> 
      <hr>
      <label>Search By Name/Family</label>
      <input type="text" v-model="searchQuery">

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
        <tr v-for="item in filteredItems" :key="item.name">
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
        searchQuery: '',
        items: [], 
        page: 1,
        totalFruitDiet: [],
        perPage: 10,
        total: 0,
      };
    },
    computed: {
      lastPage() {
        return Math.ceil(this.total / this.perPage);
      },
      filteredItems() {
      return this.items.filter(item => {
        return item.name.toLowerCase().includes(this.searchQuery.toLowerCase()) || item.family.toLowerCase().includes(this.searchQuery.toLowerCase());
      });
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
        this.totalFruitDiet = response.data.data.totalFruitDiet; 
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