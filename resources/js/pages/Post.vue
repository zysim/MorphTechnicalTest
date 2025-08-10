<script setup lang="ts">
import DeletePostDialog from '@/components/DeletePostDialog.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';

// TODO: Generate types.
interface Post {
    id: number
    author: string
    headerImage: string
    content: string
    updatedAt: string
    title: string
}

const { post, isAdmin } = defineProps<{
	post: {
        data: Post
    },
    isAdmin: boolean
}>()

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
    {
        title: 'Posts',
        href: `/post/${post.data.id}`,
    },
];
</script>

<template>
    <Head :title="post.data.title" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <DeletePostDialog :is-admin="isAdmin" :post-id="post.data.id" />
        <div class="flex h-full flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div class="w-full h-[300px] bg-background">
                <img class="h-fit object-none" :src="post.data.headerImage" alt="Blog post header image" />
            </div>
            <h1 class="text-lg md:text-2xl font-bold">{{ post.data.title }}</h1>
            <div class="flex justify-between text-foreground/60">
                <div>By: {{ post.data.author }}</div>
                <div>Last updated at: {{ new Date(post.data.updatedAt).toUTCString() }}</div>
            </div>
            <div>{{ post.data.content }}</div>
        </div>
    </AppLayout>
</template>
