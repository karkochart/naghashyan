<script setup>
import InputError from '@/Components/InputError.vue';
import InputLabel from '@/Components/InputLabel.vue';
import PrimaryButton from '@/Components/PrimaryButton.vue';
import TextInput from '@/Components/TextInput.vue';
import {Link, router, useForm, usePage} from '@inertiajs/vue3';

const props = defineProps({
    product: {
        type: Object,
        required: true,
    },
    categories: {
        type: Object,
        required: true,
    }
});

const form = useForm({
    id: props.product.id,
    name: props.product.name,
    description: props.product.description,
    price: props.product.price,
    photos: props.product.photos,
    category_id: props.product.category_id,
});
const removePhoto = function (id) {
    document.getElementById('photo-' + id).remove();
    axios.delete('/photos', {data: {id: id}},)
        .then(res => {
            // router.get(photos)
        })
        .catch(err => {
            alert(err.message);
        });
}

</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">Edit Product</h2>
        </header>
        <form @submit.prevent="form.patch(route('products.update'))" class="mt-6 space-y-6">
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
                <div class="grid grid-cols-2 md:grid-cols-2 gap-3">
                    <div v-for="photo in form.photos" class="relative" :id="'photo-' + photo.id">
                        <img class="h-auto max-w-full rounded-lg"
                             :src="'/storage/uploads/' + photo.path" :alt="photo.path">
                        <button type="button"
                                @click="removePhoto(photo.id)"
                                class="absolute top-0 text-red-700 hover:text-white border border-red-700 hover:bg-red-800 focus:ring-4 focus:outline-none focus:ring-red-300 font-medium rounded-lg text-sm px-2 py-1 text-center me-2 mb-2 dark:border-red-500 dark:text-red-500 dark:hover:text-white dark:hover:bg-red-600 dark:focus:ring-red-900">
                            X
                        </button>
                    </div>
                </div>

                <InputLabel for="description" value="photos"/>
                <input type="file" @input="form.photos = $event.target.files[0]" multiple/>

                <InputError class="mt-2" :message="form.errors.photos"/>
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
