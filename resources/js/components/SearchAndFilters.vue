<template>
    <div class="card-title row col-10">
        <div class="col-md-3">
            <input class="form-control py-2 me-2"  v-model="search"  @input="$emit('search',search)" :placeholder="$t('global.Search')">
        </div>

        <slot></slot>
    </div>
</template>

<script>
import { reactive, ref } from 'vue';
export default {
    setup() {
        const search = ref('')

        //search input and its fields


        const filterColumns = ref([]);
        //   {
        //     column   : '',
        //     operator: false,
        //     value     : '',
        //     type     : '',
        //   }


        return { search };
    }

};
</script>

<style scoped>
.scope-filter {
    margin-bottom: 20px;
}

.search-filter {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.search-in-translations {
    margin-left: 10px;
}

.column-filters {
    border: 1px solid #ccc;
    padding: 10px;
}

.filter-row {
    display: flex;
    align-items: center;
    margin-bottom: 10px;
}

.filter-row>* {
    margin-right: 10px;
}
</style>
