<template>
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <br>
                    <hr>
                    <br>
                    <div class="panel-heading">{{message}} Vuejs also welcomes you!</div>
                    <br>
                    <div class="panel-body">
                        This is vue code being loaded!
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>

import axios from 'axios';

export default {
  
  data: () => ({
    message: '',
  }),

  mounted() {
    console.log('Component mounted.');
    axios
    .get(`/api/v1/test`)
    .then((response) => {
      this.message = response.data.message;
    });
  }
}
</script>
