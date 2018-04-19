import Vue from 'vue';
import { Component } from 'vue-property-decorator';
import Axios from 'axios';

class EtsyResult {
	results: Array<EtsyListing>;
}

class EtsyListing {
	listing_id: number;
	state: string;
	title: string;
	description: string;
	price: string;
	currency_code: string;
	quantity: string;
	url: string;
	last_modified_tsz: number;

	MainImage: EtsyListingImage;
}

class EtsyListingImage {
	listing_image_id: number;
	url_75x75: string;
	url_170x135: string;
	url_570xN: string;
	url_fullxfull: string;
}

@Component
export default class App extends Vue {
	listings: Array<EtsyListing> | null = null;

	async mounted() {
		const response = await Axios.get<EtsyResult>(window['esw_wp'].siteurl + '/wp-admin/admin-post.php?action=esw_listings');

		this.listings = response.data.results.sort((a, b) => a.last_modified_tsz - b.last_modified_tsz);
	}
}
