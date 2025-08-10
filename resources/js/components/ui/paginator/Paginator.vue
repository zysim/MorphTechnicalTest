<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

const props = defineProps<{
	routeName: string,
	links: {
		label: string,
		active: boolean,
		url: string | null,
	}[]
}>()

const links = computed<{
	label: string,
	active: boolean,
	page: number
}[]>(() => (
	props.links.filter(link => link.url !== null)
	.map(link => {
		const url = new URL(link.url!)
		return {
			...link,
			page: parseInt(url.searchParams.get('page')!, 10)
		}
	})
))

</script>

<template>
	<div class="container">
		<div class="pageContainer">
			<Link v-for="link in links" :href="route(props.routeName, {
				page: link.page
			})">
				<button class="button">
					<span v-html="link.label" />
				</button>
			</Link>
		</div>
	</div>
</template>

<style scoped>
.container {
	display: flex;
	flex-direction: column;
	align-items: flex-end;
}

.pageSelectorContainer {
	display: flex;
	flex-direction: row;
	gap: 1rem;
	justify-content: space-between;
	align-items: center;
}

.pageContainer {
	display: flex;
	flex-direction: row;
	gap: 0.4rem;
	justify-content: space-between;
	align-items: center;
}

.goToPage {
	padding: 0.5rem 0.2rem;
}

.resultsPerPageContainer {
	display: flex;
	align-items: center;
	gap: 0.6rem;
}

.resultsPerPage {
	padding: 0.5rem 0.2rem;
}
</style>
