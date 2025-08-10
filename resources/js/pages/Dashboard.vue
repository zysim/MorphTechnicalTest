<script setup lang="ts">
import { Card, CardDescription, CardHeader, CardTitle } from '@/components/ui/card';
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
    createdAt: Date
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

const format = new Intl.DateTimeFormat(
    'en-MY',
    {
        timeZone: 'Asia/Kuala_Lumpur',
        day: '2-digit',
        month: 'short',
        year: 'numeric',
    }
)

function formatDate(from: Date) {
    return format.formatToParts(from)[0].value
}

function formatMonthAndYear(from: Date) {
    const parts = format.formatToParts(from)
    return `${parts[2].value} ${parts[4].value}`
}
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
                    <Card class="rounded-none shadow-lg group relative pt-0">
                        <div class="absolute inset-0 z-10 bg-background w-fit aspect-square px-4 py-5 font-bold flex gap-2 flex-col items-center">
                            <div class="md:text-5xl">{{ formatDate(new Date(post.createdAt)) }}</div>
                            <div class="capitalize">{{ formatMonthAndYear(new Date(post.createdAt)) }}</div>
                        </div>
                        <div class="overflow-clip">
                            <img :src="post.headerImage" class="mx-auto object-fit group-hover:scale-105 motion-safe:transition-transform"/>
                        </div>
                        <CardHeader class="text-center">
                            <CardTitle class="md:text-xl">{{ post.title }}</CardTitle>
                            <CardDescription>By: {{ post.author }}</CardDescription>
                        </CardHeader>
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
