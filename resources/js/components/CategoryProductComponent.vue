<template>
    <div class="container">


        <select  ref="cats">
            <option v-for="(ID,NAME) in categories" :id="ID">{{NAME}}</option>
        </select>
        <select name="productlist">
            <option v-for="(ID,NAME) in displayedProduct" :id="ID">{{NAME}}</option>
        </select>

    </div>
</template>

<script>
    export default {
        beforeMount() {
            var selectedCategory="";
        },
        mounted() {
            console.log('Component mounted.')
        },

        props: ['categories', 'products','selectedCategory','selectedCategory' ],
        computed: {
            displayedProduct: {
                get: function() {
                    console.log(this.$refs);

                    var myproducts = Object.values(this.products);
                    filterProducts = myproducts.filter(function(car) {
                        return myproducts.ID === this.mySelectedCategory;
                    });
                    return myproducts;
                },
                set: function(val) {
                    // Do something with the val here...
                    this.msg = val;
                },
            },
        }
    }
</script>
