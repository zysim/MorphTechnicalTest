<script setup lang="ts">
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { useQuery } from '@tanstack/vue-query';

// TODO: Generate types.
interface User {
    name: string
}

interface Post {
    id: number
    author: User
    header_image: string
    content: string
}

const { isSuccess, data, isError, error } = useQuery<Post[]>({
    queryKey: ['posts'],
    async queryFn() {
        const response = await fetch('api/posts')
        if (!response.ok) {
            let errorText = 'Unknown error'
            try {
                errorText = await response.text()
            }
            catch {
                console.error('Error parsing response.text()')
            }
            throw new Error(`Failed to fetch posts: ${response.status} ${errorText}`)
        }
        return response.json()
    }
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Dashboard',
        href: '/dashboard',
    },
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div v-if="isSuccess" class="grid auto-rows-min gap-4 md:grid-cols-3">
                <div v-for="post in data" :key="post.id">
                    <img :src="post.header_image" />
                    <span>By: {{ post.author }}</span>
                    <span>{{ post.content }}</span>
                </div>
                <!--div v-for="i in [1,2,3]" :key="i" class="relative aspect-video overflow-hidden rounded-xl border border-sidebar-border/70 dark:border-sidebar-border">
                <PlaceholderPattern />
                </div-->
            </div>
            <div v-else-if="isError">
                <div>{{ error }}</div>
            </div>
            <!--div class="relative min-h-[100vh] flex-1 rounded-xl border border-sidebar-border/70 md:min-h-min dark:border-sidebar-border">
            <PlaceholderPattern />
            </div-->
        </div>
    </AppLayout>
</template>
