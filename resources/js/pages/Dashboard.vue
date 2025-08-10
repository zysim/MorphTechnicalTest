<script setup lang="ts">
import Paginator from '@/components/ui/paginator/Paginator.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
// import PlaceholderPattern from '../components/PlaceholderPattern.vue';
import { useQuery } from '@tanstack/vue-query';
import { useUrlSearchParams } from '@vueuse/core';

// TODO: Generate types.
interface User {
    name: string
}

interface Paginated<T> {
    data: T[],
    links: {
        first: string | null,
        last: string | null,
        prev: string | null,
        next: string | null,
    },
    meta: {
        current_page: number,
        from: number,
        last_page: number,
        links: {
            label: string,
            active: boolean,
            url: string | null,
        }[],
        path: string,
        per_page: number,
        to: number,
        total: number,
    }
}

interface Post {
    id: number
    author: User
    headerImage: string
    content: string
}

const params = useUrlSearchParams<Partial<{ page: number }>>('history')

const { isSuccess, data, isError, error } = useQuery<Paginated<Post>>({
    queryKey: ['posts'],
    async queryFn() {
        const response = await fetch(`api/posts${params.page != undefined ? '?page=' + params.page : ''}`)
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
    // TODO: Add a page that lists all posts
];
</script>

<template>
    <Head title="Dashboard" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <Paginator
            v-if="data?.meta.links != null"
            routeName="dashboard"
            :links="data?.meta.links"
        />
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <div v-if="isSuccess" class="grid auto-rows-min gap-4 md:grid-cols-3">
                <Link v-for="post in data?.data || []" :key="post.id" :href="route('post', { id: post.id })">
                    <div class="p-2 border border-gray-300 rounded hover:shadow-lg hover:scale-105 motion-safe:transition-transform">
                        <img :src="post.headerImage" />
                        <div>By: {{ post.author }}</div>
                        <div class="overflow-ellipsis line-clamp-3">{{ post.content }}</div>
                    </div>
                </Link>
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
        <Paginator
            v-if="data?.meta.links != null"
            routeName="dashboard"
            :links="data?.meta.links"
        />
    </AppLayout>
</template>
