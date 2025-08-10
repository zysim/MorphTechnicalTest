<script setup lang="ts">
import {
    Dialog,
    DialogClose,
    DialogContent,
    DialogDescription,
    DialogFooter,
    DialogHeader,
    DialogTitle,
    DialogTrigger
} from '@/components/ui/dialog';
import { router } from '@inertiajs/vue3';
import { useMutation } from '@tanstack/vue-query';
import Icon from './Icon.vue';
import Button from './ui/button/Button.vue';

const props = defineProps<{
  isAdmin: boolean,
  postId: number,
}>()

const { mutate, isError, error, isPending } = useMutation({
    mutationKey: ['deletePost', props.postId],
    async mutationFn() {
        try {
            router.delete(`/api/posts/${props.postId}`)
        } catch {
            throw new Error(`Failed to delete post`)
        }
    },
})
</script>

<template>
  <Dialog v-if="props.isAdmin">
    <DialogTrigger class="mt-2 mr-2 self-end">
        <Button variant="destructive" title="Delete post">
            <Icon name="trash" />
        </Button>
    </DialogTrigger>
    <DialogContent>
        <DialogHeader class="space-y-3">
            <DialogTitle>Are you sure you want to delete this post?</DialogTitle>
            <DialogDescription>
                This action can be undone, but you will need to contact the DB admin.
            </DialogDescription>
            <div v-if="isError">{{ error }}</div>
        </DialogHeader>
        <DialogFooter class="gap-2">
            <DialogClose as-child>
                <Button :disabled="isPending" variant="secondary">Cancel</Button>
            </DialogClose>
            <Button type="submit" :disabled="isPending" variant="destructive" @click="mutate">Delete</Button>
        </DialogFooter>
    </DialogContent>
</Dialog>
</template>
