 <template>
  <div> 
    <button @click="addToFavorites">{{ item.favorite == 1 ? "Remove From Favorite" : "Add To Favorite" }} </button> 
  </div>
</template>

<script>
import axios from 'axios';
import { toast } from 'vue3-toastify';
import 'vue3-toastify/dist/index.css'
export default { 
  props: ['item'],
  methods: {
    addToFavorites() {
      axios.post('/favorite/store', { id: this.item.id })
        .then(response => { 
          
          toast(response.data.message, {
            autoClose: 1000,
          });

          this.$router.push('/favorite');

         })
        .catch(error => {

          toast(error.data.message, {
            autoClose: 1000,
          }); 

        });
    }
  }
}
</script>