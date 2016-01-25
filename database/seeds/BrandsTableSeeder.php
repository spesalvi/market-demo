<?php

use Illuminate\Database\Seeder;

class BrandsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('brands')->insert([
			'brand' => 'Amazon',
			'slug' => 'amazon',
			'sv_name' => 'Amazon',
			'img_thumb' => 'http://devcdn.giftbig.com/dev4/brands_logo/large/3_logo.png',
			'img_large' => 'http://devcdn.giftbig.com/dev4/brands_logo/large/3_logo.png'
		]);

		DB::table('brands')->insert([
			'brand' => 'Jabong',
			'slug' => 'jabong',
			'sv_name' => 'Jabong',
			'img_thumb' => 'http://devcdn.giftbig.com/dev4/brands_logo/large/4_logo.png',
			'img_large' => 'http://devcdn.giftbig.com/dev4/brands_logo/large/4_logo.png'
		]);
		DB::table('brands')->insert([
			'brand' => 'Lifestyle',
			'slug' => 'lifestyle',
			'sv_name' => 'Lifestyle',
			'img_thumb' => 'http://devcdn.giftbig.com/dev3/brands_logo/large/2_logo.png',
			'img_large' => 'http://devcdn.giftbig.com/dev3/brands_logo/large/2_logo.png'
		]);
		DB::table('brands')->insert([
			'brand' => 'Shoppers Stop',
			'slug' => 'shoppers-stop',
			'sv_name' => 'ShoppersStop',
			'img_thumb' => 'http://devcdn.giftbig.com/dev4/brands_logo/large/1_logo.png',
			'img_large' => 'http://devcdn.giftbig.com/dev4/brands_logo/large/1_logo.png'
		]);
		DB::table('brands')->insert([
			'brand' => 'Shoppers Stop GiftCard',
			'slug' => 'shoppers-stop-giftcard',
			'sv_name' => 'ShoppersStopGiftcard',
			'img_thumb' => 'http://devcdn.giftbig.com/dev4/brands_logo/large/1_logo.png',
			'img_large' => 'http://devcdn.giftbig.com/dev4/brands_logo/large/1_logo.png'
		]);
		DB::table('brands')->insert([
			'brand' => 'Woohoo GiftCard',
			'slug' => 'woohoo-giftcard',
			'sv_name' => 'WoohooGiftcard',
			'img_thumb' => 'http://devcdn.giftbig.com/dev4/brands_logo/large/5_logo.png',
			'img_large' => 'http://devcdn.giftbig.com/dev4/brands_logo/large/5_logo.png'
		]);
    }
}
