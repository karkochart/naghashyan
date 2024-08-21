<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Link, useForm, usePage} from '@inertiajs/vue3';

defineProps({
    categories: {
        type: Object,
    }
});


const form = useForm({
    name: '',
    description: '',
    price: null,
    category_id: null,
    images: [],
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Add Product</h2>
        </header>

        <form @submit.prevent="form.post(route('products.store'))" class="mt-6 space-y-6">
            <div>
                <InputLabel for="name" value="Name"/>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.name"
                    required
                    autofocus
                    autocomplete="name"
                />

                <InputError class="mt-2" :message="form.errors.name"/>
            </div>

            <div>
                <InputLabel for="description" value="Description"/>

                <TextInput
                    id="name"
                    type="text"
                    class="mt-1 block w-full"
                    v-model="form.description"
                    required
                    autofocus
                    autocomplete="description"
                />

                <InputError class="mt-2" :message="form.errors.description"/>
            </div>

            <!--            <div>-->
            <!--                <InputLabel for="description" value="Images"/>-->

            <!--                <div class="mt-3">-->
            <!--                    <input id="gallery-uploader"-->
            <!--                           class="border-solid border-2 border-gray-300 rounded-md p-1.5"-->
            <!--                           name="gallery" type="file" accept="image/png,image/gif,image/jpeg"-->
            <!--                           multiple>-->
            <!--                </div>-->

            <!--                <InputError class="mt-2" :message="form.errors.images"/>-->
            <!--            </div>-->
            <div>
                <InputLabel for="description" value="Images"/>
                <input type="file" @input="form.images = $event.target.files[0]" multiple/>

                <InputError class="mt-2" :message="form.errors.images"/>
            </div>

            <div>
                <InputLabel for="description" value="Price"/>

                <TextInput
                    id="name"
                    type="number"
                    class="mt-1 block w-full"
                    v-model="form.price"
                    required
                    autofocus
                    autocomplete="price"
                />

                <InputError class="mt-2" :message="form.errors.price"/>
            </div>
            <div>
                <InputLabel for="category_id" value="Category"/>
                <select v-model="form.category_id"
                        class="bg-gray-50 border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 EditProductFormbg-gray-700 EditProductFormborder-gray-600 EditProductFormplaceholder-gray-400 EditProductFormtext-white EditProductFormfocus:ring-blue-500 EditProductFormfocus:border-blue-500">
                    <option v-for="category in categories" :value="category.id">{{ category.name }}</option>
                </select>

                <InputError class="mt-2" :message="form.errors.category_id"/>
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton :disabled="form.processing">Save</PrimaryButton>

                <Transition
                    enter-active-class="transition ease-in-out"
                    enter-from-class="opacity-0"
                    leave-active-class="transition ease-in-out"
                    leave-to-class="opacity-0"
                >
                    <p v-if="form.recentlySuccessful" class="text-sm text-gray-600">Saved.</p>
                </Transition>
            </div>
        </form>
    </section>
</template>
