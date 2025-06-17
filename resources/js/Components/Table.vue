<template>
    <div class="card shadow-sm border-0">
        <div class="card-header bg-dark text-white fw-bold text-center fs-5">
            {{ title }}
        </div>
        <div class="card-body p-0">
            <table class="table table-hover table-bordered mb-0 text-center">
                <thead class="table-secondary">
                <tr>
                    <th v-for="(header, index) in headers" :key="index" class="align-middle">
                        {{ header }}
                    </th>
                </tr>
                </thead>
                <tbody>
                <tr v-for="(row, i) in rows" :key="i">
                    <td v-for="(cell, j) in row" :key="j">
                        {{ cell }}
                    </td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
</template>

<script>
export default {
    name: 'Table',
    props: {
        title: {
            type: String,
            required: true,
        },
        headers: {
            type: Array,
            required: true,
        },
        rows: {
            type: Array,
            required: true,
        },
    },
};
</script>

<style scoped>
.card-header {
    background: linear-gradient(90deg, #343a40 0%, #495057 100%);
}
</style>
