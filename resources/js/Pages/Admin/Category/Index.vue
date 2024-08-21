<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import Pagination from "@/Components/Pagination.vue";
import Search from "@/Components/Search.vue";
import Actions from "@/Components/Actions.vue";

defineProps({
    categories: {
        type: Object,
    },
    search: {
        type: String,
    }
});

const baseUrl = '/categories';

</script>

<template>
    <Head title="Profile"/>

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">Products</h2>
        </template>
        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">

                    <div class="relative overflow-x-auto shadow-md sm:rounded-lg">

                        <div class="w-full flex justify-between items-center mb-3 mt-1 pl-3">
                            <div class="ml-3">
                                <div class="w-full max-w-sm min-w-[200px] relative">
                                    <Search
                                        :url="baseUrl"
                                        :search="search"
                                    ></Search>
                                </div>
                            </div>
                        </div>

                        <table class="w-full text-sm text-left rtl:text-right text-gray-500 dark:text-gray-400">
                            <thead
                                class="text-xs text-gray-700 uppercase bg-gray-50 dark:bg-gray-700 dark:text-gray-400">
                            <tr>
                                <th scope="col" class="px-6 py-3 active-sort" @click="">
                                    Id
                                    <div class="rotate-90 inline-block"><</div>
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Name
                                </th>
                                <th scope="col" class="px-6 py-3">
                                    Actions
                                </th>
                            </tr>
                            </thead>
                            <tbody>
                            <tr v-for="category in categories.data"
                                class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <td class="px-6 py-4">
                                    {{ category.id }}
                                </td>
                                <th scope="row"
                                    class="px-6 py-4 font-medium text-gray-900 whitespace-nowrap dark:text-white">
                                    {{ category.name }}
                                </th>
                                <td class="px-6 py-4">
                                    <Actions :id="category.id" :url="baseUrl"/>
                                </td>
                            </tr>
                            </tbody>
                        </table>
                    </div>
                    <div class="py-4">
                        <Pagination :data="categories"/>
                    </div>

                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
