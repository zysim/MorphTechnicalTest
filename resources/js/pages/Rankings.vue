<script setup lang="ts">
import Heading from '@/components/Heading.vue';
import AppLayout from '@/layouts/AppLayout.vue';
import { type BreadcrumbItem } from '@/types';
import { Head } from '@inertiajs/vue3';
import { useQuery } from '@tanstack/vue-query';

const { refetch, isLoading, isSuccess, data, isError, error } = useQuery<{
    name: string,
    posts: number,
}[]>({
    queryKey: ['rankings'],
    async queryFn() {
        const response = await fetch('/api/posts/rank')
        if (!response.ok) {
            throw new Error(`Failed to fetch rankings: ${response.status}`)
        }
        return response.json()
    },
})

const breadcrumbs: BreadcrumbItem[] = [
    {
        title: 'Rankings',
        href: '/rankings',
    },
];
</script>

<template v-if="props.isAdmin">
    <Head title="Rankings" />

    <AppLayout :breadcrumbs="breadcrumbs">
        <div class="flex h-full flex-1 flex-col gap-4 rounded-xl p-4 overflow-x-auto">
            <Heading
                title="Post Count Rankings"
                description="Shows a list of users with a total count of posts they've made."
            />
            <Skeleton v-if="isLoading" class="h-[200px] w-full" />
            <table v-else-if="isSuccess">
                <tr v-for="rank in data" :key="rank.name" class="odd:bg-chart-3/10">
                    <td class="px-1 py-2">{{ rank.name }}</td>
                    <td>{{ rank.posts }}</td>
                </tr>
            </table>
            <div class="h-[200px] flex flex-col gap-3 items-center" v-else-if="isError">
                <div>{{ error }}</div>
                <Button variant="secondary" @click="refetch">Retry</Button>
            </div>
        </div>
    </AppLayout>
</template>
