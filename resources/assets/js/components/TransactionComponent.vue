<template>
    <div class="container-fluid">
        <nav  class="navbar navbar-light">
            <a class="navbar-brand" href="/transactions">Transactions</a>
        </nav>
        <!-- Search Filters -->
        <div class="row">
            <div class="form-group col-md-3">
                <label class="form-label">Filter by Transaction ID:</label>
                <input 
                  class="form-control" 
                  v-model="searchTransactionID"
                  @input="onChange"
                  type="number"
                  />
            </div>
            <div class="form-group col-md-3">
                <label class="form-label">Filter by Sacco Name:</label>
                <input 
                  class="form-control" 
                  v-model="searchSaccoName"
                  @input="onChange"
                  type="text"
                  />
            </div>
            <div class="form-group col-md-3">
                <label class="form-label">Filter by Individual Name:</label>
                <input 
                  class="form-control" 
                  v-model="searchIndividualName"
                  @input="onChange"
                  type="text"
                  />
            </div>
            <div class="form-group col-md-3">
                <label class="form-label">Filter by Country Name</label>
                <input 
                  class="form-control" 
                  v-model="searchSaccoCountryName"
                  @input="onChange"
                  type="text"
                  />
            </div>
            <div class="form-group col-md-5">
                <label class="form-label">Filter by Amount</label>
                <div class="row">
                    <div class="col-md-6">
                        <label>Min Amount(UGX)</label>
                        <input class="form-control" 
                          v-model="searchMinAmount"
                          @input="onChange"  
                          type="number" 
                          min="1" 
                          step="any"/>
                    </div>
                    <div class="col-md-6">
                        <label>Max Amount(UGX)</label>
                        <input class="form-control" 
                          v-model="searchMaxAmount"
                          @input="onChange"
                          type="number" 
                          min="1" 
                          step="any"/>
                    </div>
                </div>
            </div>
        </div>
        <!-- Search Table -->
        <div class="row">
            <table class="table">
                <thead>
                    <tr>
                        <th class="th-cell">Transaction ID</th>
                        <th class="th-cell">Transaction Type</th>
                        <th class="th-cell">Transaction Amount(UGX)</th>
                        <th class="th-cell">Individual ID</th>
                        <th class="th-cell">Individual NAME</th>
                        <th class="th-cell">Individual Email</th>
                        <th class="th-cell">Individual Gender</th>
                        <th class="th-cell">Sacco_id</th>
                        <th class="th-cell">Sacco Name</th>
                        <th class="th-cell">Sacco Country</th>
                    </tr>
                </thead>
               <tbody>
                   <tr v-for="transaction in transactions" v-bind:key="transaction.id">
                    <td class="td-cell">{{ transaction.id }}</td>
                    <td class="td-cell">{{ transaction.type }}</td>
                    <td class="td-cell">{{ transaction.amount }}</td>
                    <td class="td-cell">{{ transaction.individual_id }}</td>
                    <td class="td-cell">{{ transaction.first_name+" "+transaction.last_name }}</td>
                    <td class="td-cell">{{ transaction.email }}</td>
                    <td class="td-cell">{{ transaction.gender }}</td>
                    <td class="td-cell">{{ transaction.sacco_id }}</td>
                    <td class="td-cell">{{ transaction.name }}</td>
                    <td class="td-cell">{{ transaction.country }}</td> 
                   </tr>
               </tbody>
        </table>
        </div>
        <!-- Pagination -->
        <div class="row">
            <nav v-show="showPagination" aria-label="Page navigation example">
                <ul class="pagination">
                    <li 
                        v-bind:class="[{disabled: !pagination.prev_page_url}]" class="page-item">
                        <a 
                         class="page-link"
                        @click="getTransactions(pagination.prev_page_url)"
                        >Previous</a>
                    </li>
                    <li 
                        v-bind:class="[{disabled: true }]" 
                        class="page-item">
                        <a 
                        class="page-link"
                        >page 
                        {{ pagination.current_page }}
                         of
                        {{ pagination.last_page }}</a>
                    </li>
                <li 
                   v-bind:class="[{disabled: !pagination.next_page_url}]"
                   class="page-item">
                   <a class="page-link"
                   @click="getTransactions(pagination.next_page_url)">Next</a>
                </li>
            </ul>
        </nav>
        </div>
    </div>
</template>
<script>
export default {
    /**
     * returned types
     */
    data(){
        return{
            transactions:[],
            pagination: {},
            searchSaccoName: "",
            showPagination: true,
            searchIndividualName: "",
            searchTransactionID: "",
            searchSaccoCountryName: "",
            searchMinAmount: "",
            searchMaxAmount: ""
        }
    },
    created(){
        this.getTransactions();
    },
    methods: {
        getTransactions(page_url){
            page_url = page_url || 'api/v1/getTransactions';
            axios.get(page_url)
            .then( response =>{
                console.log("transactions: "+response.data.transactions.data[0].id);
                this.showPagination = true;
                this.transactions = response.data.transactions.data;
                this.makePagination(response.data.transactions);
            })
            .catch( e => {
              console.log("Error: "+ e);
            })
        },
        onChange() {
            if(this.searchSaccoName.length == 0 &&
               this.searchIndividualName.length == 0 && 
               this.searchTransactionID.length == 0 && 
               this.searchSaccoCountryName.length == 0 && 
               this.searchMinAmount.length == 0 && 
               this.searchMaxAmount.length  == 0){
                   this.getTransactions();
            }else{
                const page_url = 'api/v1/getFilteredTransactions';
                const data = {
                    sacco_name: this.searchSaccoName,
                    individual_name: this.searchIndividualName,
                    transaction_id: this.searchTransactionID,
                    sacco_country: this.searchSaccoCountryName,
                    min_amount: this.searchMinAmount,
                    max_amount: this.searchMaxAmount
                }
                axios.post(page_url,data)
                .then( response =>{
                    this.showPagination = false;
                    console.log("fileterdTransactions: "+response.data.transaction_id);
                    this.transactions = response.data.transactions;
                })
                .catch( e => {
                    console.log("Error: "+e);
                })
            }
        },
        makePagination(response){
            let page = {
                current_page: response.current_page,
                next_page_url: response.next_page_url,
                last_page: response.last_page,
                prev_page_url: response.prev_page_url
            }
            this.pagination = page;
        },

    }
}
</script>
<style scoped>
.th-cell{
  padding: 5px;
  text-align: center;
  font-size: 16px;
}
.td-cell{
    color: black;
    text-align: center;
    font-size: 15px;
}
.chart {
  height: 400px;
}
.page-link{
    /* color: black; */
    font-size: 15px;
}
.navbar{
    background-color: #e3f2fd;
    margin-right: -15px;
    margin-left: -15px;
    text-align: left;
}
.navbar-brand{
    width:-webkit-fill-available;
    font-weight: bold;
    font-size: 17px;
}
.form-label{
    color: black;
    font-size: 15px;
}

.body{
    font-family: Arial, Helvetica, sans-serif;
}
</style>