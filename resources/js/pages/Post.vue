<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';

// TODO: Generate types.
interface Post {
    id: number
    author: string
    headerImage: string
    content: string
    updatedAt: string
}

const { post } = defineProps<{
	post: {
        data: Post
    }
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    // TODO: Add a page that lists all posts
    // {
    //     title: 'Posts',
    //     href: '/posts',
    // },
];
</script>

<template>
    <Head title="Post" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <img class="h-fit object-none" :src="post.data.headerImage" alt="Blog post header image" />
            <div class="flex justify-between text-gray-400">
                <div>By: {{ post.data.author }}</div>
                <div>Last updated at: {{ new Date(post.data.updatedAt).toUTCString() }}</div>
            </div>
            <div>{{ post.data.content }}</div>
        </div>
    </AppLayout>
</template>
