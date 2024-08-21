<script setup>
import {router} from "@inertiajs/vue3";

defineProps({
        url: {
            type: String,
            required: true,
        },
        id: {
            type: String,
            required: true,
        },
    }
)

const remove = function (url, id) {
    axios.delete(url, {data: {id: id}},)
        .then(res => {
            router.get(url)
        })
        .catch(err => {
            alert(err.message);
        });
}
</script>

<template>
    <div>
        <a :href="url + '/edit/' + id"
           class=" font-medium text-blue-600 dark:text-blue-500 hover:underline inline-block mr-5">Edit</a>
        <a @click.prevent="remove(url, id)"
           class="font-medium text-red-600 dark:text-red-500 hover:underline inline-block mr-5">Delete</a>
    </div>
</template>

<style scoped>

</style>
