<!-- Shows a table of all users and their total post count. -->

<script setup lang="ts">
import {
    Dialog,
    DialogContent,
    DialogDescription,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/components/ui/dialog';
import { useQuery } from '@tanstack/vue-query';
import Button from './ui/button/Button.vue';
import {Skeleton} from './ui/skeleton';

const props = defineProps<{
  isAdmin: boolean
}>()

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
    enabled: false,
})
</script>

<template>
  <Dialog v-if="props.isAdmin">
    <DialogTrigger class="ml-4 self-start">
        <Button variant="default" @click="refetch">Post Count Rankings</Button>
    </DialogTrigger>
    <DialogContent>
        <DialogHeader class="space-y-3">
            <DialogTitle>Post Count Rankings</DialogTitle>
            <DialogDescription>
                This shows a list of users with a total count of posts they've made.
            </DialogDescription>
        </DialogHeader>
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
    </DialogContent>
</Dialog>
</template>
