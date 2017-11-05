<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use TwitterAPIExchange;
use App\History;

class MapController extends Controller {

	/**
     * Index page to show search page with gmap.
     *
     * @return view
     */
	public function getIndex(){
		Log::info('Showing add client form for user.');
		return view('map');
	}

	/**
	 * Tweets history function to return list of history
	 *
	 * @return histories
	 */
	public function tweets_history(){
		$histories = History::select(array('keyword','count'))->get();
		echo json_encode($histories);
	}

	/**
	 * Post tweet data by city name via ajax only
	 *
	 * @param string $city city lng lat
	 */
	public function tweets(Request $request)
	{

		$hour = date('Y-m-d H:i:s', strtotime('-1 hour'));
		$city = strtoupper($request->input('city'));
		$lng = $request->input('lng');
		$lat = $request->input('lat');
		die('testing');
		$record = History::where('city', $city)->where('updated_at', '>', $hour)->first();
		
		if ($record) {
			$twitter_data = $record->data;
		} else {
			$twitter_data = $this->getTweets($lat,$lng);
			if (empty($twitter_data)) {
				$twitter_data = [];
			} else {
				$record = History::where('keyword', $city)->first();
				if ($record) {
					$record->update(['description' => $twitter_data]);
					$record->increment('count',1);
				} else {
					$history = new History;
					$history->keyword = $city;
					$history->description = $twitter_data;
					$history->latitude = $lat;
					$history->longitude = $lng;
					$history->image_url = 'something';
					$history->count = 1;
					$history->save();
				}
			}
		}
		echo $twitter_data;
	}

	/**
	 * function to get city details
	 *
	 * @return tweet search
	 */
	private function getTweets($lat, $lng){
		$settings = array(
			'oauth_access_token' => "236236965-lceTXuVBvw8DpR9yK2FEz0TcrhOGD0blXHes31Dg",
			'oauth_access_token_secret' => "US4Uo8v6rwYBDwmyC08cax8uIdon9SGygnkHPgmuBEpfW",
			'consumer_key' => "cflkUlMsMjseh1T3Hy2VOq7WF",
			'consumer_secret' => "UTr94J3UY24SkNiOsUPJXomeOWPbqdRT98QpYHCr9U5t5sU9BZ"
			);

		$url = 'https://api.twitter.com/1.1/search/tweets.json';
		$requestMethod = 'GET';
		$getfield = '?geocode='.$lat.','.$lng.',1mi&count=20';
		$twitter = new TwitterAPIExchange($settings);
		$twitter_response = $twitter->setGetfield($getfield)
		->buildOauth($url, $requestMethod)
		->performRequest();
		return $twitter_response;
	}
}
?>