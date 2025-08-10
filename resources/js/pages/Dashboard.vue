<script setup lang="ts">
import { Card, CardContent, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
import Paginator from '@/components/ui/paginator/Paginator.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head, Link } from '@inertiajs/vue3';
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
    title: string
}

const { isAdmin } = defineProps<{ isAdmin: boolean }>()

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
            <h1 class="text-lg md:text-2xl font-bold">{{ isAdmin ? 'All Posts' : 'My Posts' }}</h1>
            <div v-if="isSuccess" class="grid auto-rows-min gap-4 md:grid-cols-3">
                <Link v-for="post in data?.data || []" :key="post.id" :href="route('post', { id: post.id })">
                    <Card class="rounded hover:shadow-lg hover:scale-105 motion-safe:transition-transform">
                        <CardHeader class="text-center">
                            <img :src="post.headerImage" class="mx-auto object-fit"/>
                            <CardTitle class="md:text-xl">{{ post.title }}</CardTitle>
                            <CardDescription>By: {{ post.author }}</CardDescription>
                        </CardHeader>
                        <CardContent class="overflow-ellipsis line-clamp-3">
                            {{ post.content }}
                        </CardContent>
                    </Card>
                </Link>
            </div>
            <div v-else-if="isError">
                <div>{{ error }}</div>
            </div>
        </div>
        <Paginator
            v-if="data?.meta.links != null"
            routeName="dashboard"
            :links="data?.meta.links"
        />
    </AppLayout>
</template>
