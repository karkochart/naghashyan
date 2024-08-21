<script setup>
import {router, useForm} from "@inertiajs/vue3";

defineProps({
    url: {
        type: String,
        required: true,
    },
    search: {
        type: String,
    },
    // TODO
    sort: {
        type: Object,
        default() {
            return {
                id: {
                    active: true,
                    sortBy: 'ASC',
                },
                name: {
                    active: false,
                    sortBy: 'ASC',
                },
            }
        }
    }
});

const form = useForm({
    search: '',
});

const load = function (url) {
    let params = new URLSearchParams({
        search: form.search,
        sort_by: 'ASC',
    }).toString();
    router.get(url + '?' + params);
}
</script>

<template>
    <div class="relative">
        <input
            class="bg-white w-full pr-11 h-10 pl-3 py-2 bg-transparent placeholder:text-slate-400 text-slate-700 text-sm border border-slate-200 rounded transition duration-200 ease focus:outline-none focus:border-slate-400 hover:border-slate-400 shadow-sm focus:shadow-md"
            :placeholder="search"
            v-model="form.search"
            v-on:keyup.enter="load(url)"
        />
        <button
            class="absolute h-8 w-8 right-1 top-1 my-auto px-2 flex items-center bg-white rounded "
            type="button"
            @click="load(url)"
        >
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                 stroke-width="3" stroke="currentColor" class="w-8 h-8 text-slate-600">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/>
            </svg>
        </button>
    </div>
</template>

<style scoped>

</style>
