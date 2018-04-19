<script lang="ts" src="./App.vue.ts"></script>

<style lang="scss" src="./App.vue.scss"></style>

<template>
	<div class="esw-listing-container">
		<div class="esw-listing-item" v-for="listing in listings" v-bind:key="listing.listing_id">
			<a :href="listing.url" target="_blank">
				<img class="esw-listing-item-image" :src="listing.MainImage.url_170x135" />
			</a>

			<a :href="listing.url" target="_blank">
				<div class="esw-listing-item-title" v-html="listing.title"></div>
			</a>

			<div class="esw-listing-item-price">
				{{ listing.price }}
				{{ listing.currency_code }}
			</div>
		</div>
	</div>
</template>
